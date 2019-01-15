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
                <div v-if="isSender(message)"
                    class="flex mb-4">
                    <div class="flex-1"></div>
                    <div class="rounded-lg text-white p-3 max-w-md"
                        :class="getColorByRole(role)">
                        {{ message.body }}
                    </div>
                </div>
                <!-- recipeint message template -->
                <div v-else
                    class="flex items-center justify-center mb-4">
                    <div class="mr-4 border h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                    <div class="rounded-lg bg-grey-light p-3 max-w-md">
                        {{ message.body }}
                    </div>
                    <button class="fa fa-flag mr-2 ml-3"
                        @click="onClickRequestFlag(message)">
                    </button>
                    <div class="flex-1"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { Form, HasError, AlertError } from 'vform';

    export default {

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
                const result = await this.$swal({
                    title: 'Report this message',
                    text: 'Help us understand what\'s happening with this message.',
                    input: 'textarea',
                    inputPlaceholder: 'Enter reason',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Flag message'
                })

                if (!result.value) {
                    return
                }

                this.form.message_id = message.id;
                this.form.reason = result.value;
                this.form.post('/pending-flag-messages')
                    .then(response => {
                        Vue.swal({
                            title: '',
                            text: response.data.message,
                            type: 'success',
                        });
                    });
                this.form.put('/messages/' + message.id);
            },
        }
    }
</script>
