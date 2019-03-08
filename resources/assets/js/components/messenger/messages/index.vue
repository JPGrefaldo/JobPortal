<template>
    <!-- conversation -->
    <div class="w-4/5 bg-white flex flex-col p-4">
        <p v-if="typeof(participants) == 'string'">
            {{ participants }}
        </p>
        <ul class="list-reset" v-if="participants">
            <li v-for="user in participants" :key="user.id">
                {{ user.name }}
            </li>
        </ul>
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

        computed: {
            ...mapGetters({
                messages: 'message/list',
                participants: 'thread/participants'
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
