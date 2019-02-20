<template>
    <!-- conversation -->
    <div class="w-4/5 bg-white flex flex-col p-4">
        <div v-if="messages.length === 0"
            class="text-grey-dark">
            <div class="fa fa-arrow-left mr-2"></div>
            Select a thread
        </div>
        <div v-else>
            <div v-for="message in messages"
                :key="message.id">
                <!-- sender message template -->
                <message-sender  v-if="isSender(message)" :message="message"></message-sender>
                <!-- recipient message template -->
                <message-recepient v-else :message="message"></message-recepient>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { Form, HasError, AlertError } from 'vform';
    import MessageRecepient from './MessageRecepient.vue'
    import MessageSender from './MessageSender.vue'

    export default {
        components: {
            'message-recepient': MessageRecepient,
            'message-sender': MessageSender
        },

        props: {
            user: {
                type: Object,
                required: true,
            },
            role: {
                type: String,
                required: true
            },
            messages: {
                type: Array,
                required: false
            },
        },

        data() {
            return {
                form: new Form({
                    message_id: '',
                    reason: '',
                }),
            }
        },

        methods: {
            getColorByRole: function (role) {
                const colorDictionary = {
                    Producer: [
                        'bg-blue',
                        'hover:bg-blue-dark',
                    ],
                    Crew: [
                        'bg-green',
                        'hover:bg-green-dark',
                    ]
                }

                return colorDictionary[role]
            },

            isSender: function (message) {
                return message.user_id === this.user.id
            },

            onClickRequestFlag: function (message) {
                this.requestFlag(message);
            },

            async requestFlag (message) {
                const result = await this.displayRequestFlagForm();

                if (!result.value) {
                    return
                }

                const response = await this.submitRequestFlagForm(message, result)

                this.displaySuccess(response);
            },

            displayRequestFlagForm: function () {
                return this.$swal({
                    title: 'Report this message',
                    text: 'Help us understand what\'s happening with this message.',
                    input: 'textarea',
                    inputPlaceholder: 'Enter reason',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Flag message'
                });
            },

            submitRequestFlagForm: function (message, result) {
                this.form.message_id = message.id;
                this.form.reason = result.value;

                const response = this.form.post('/pending-flag-messages')

                this.form.message_id = '';
                this.form.reason = '';

                return response;
            },

            displaySuccess: function (response) {
                this.$swal({
                    title: '',
                    text: response.data.message,
                    type: 'success',
                });
            }
        }
    }
</script>
