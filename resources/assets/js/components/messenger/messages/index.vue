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
                :key="message.id" >
                <!-- sender message template -->
                <cca-sender-message  v-if="isSender(message)" :message="message" :role="role"></cca-sender-message>
                <!-- recipient message template -->
                <cca-recipient-message v-else :message="message"></cca-recipient-message>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { mapGetters } from 'vuex'
    import RecipientMessage from './RecipientMessage.vue'
    import SenderMessage from './SenderMessage.vue'

    export default {
        props: [
            'role'
        ],
        
        components: {
            'cca-recipient-message': RecipientMessage,
            'cca-sender-message': SenderMessage
        },

        mounted() {
            //TODO: Replace 3 with thread.id
            this.$store.dispatch('message/fetch', 3)
        },

        computed: {
            ...mapGetters({
                messages: 'message/list',
            })
        },

        methods: {
            isSender: function (message) {
                let user = JSON.parse(localStorage.getItem('user'))
                return message.user_id === user.id
            },
        }
    }
</script>
