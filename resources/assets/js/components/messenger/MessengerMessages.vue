<template>
    <!-- conversation -->
    <div class="w-4/5 bg-white flex flex-col p-4">
        <div v-if="messages.length === 0" class="text-grey-dark">
            <div class="fa fa-arrow-left mr-2"></div>
            Select a thread
        </div>
        <div v-else>
            <div v-for="message in messages" :key="message.id">
                <!-- sender message template -->
                <cca-sender-message
                    v-if="isSender(message)"
                    :message="message"
                    :role="role"
                ></cca-sender-message>
                <!-- recipient message template -->
                <cca-recipient-message v-else :message="message"></cca-recipient-message>
            </div>
        </div>
        <div v-if="typeof participants == 'string'">
            <p>{{ participants }}</p>
        </div>
        <ul class="list-reset" v-if="participants">
            <li v-for="user in participants" :key="user.id">{{ user.name }}</li>
        </ul>
    </div>
</template>

<script type="text/javascript">
import { mapGetters } from 'vuex';
import MessengerMessagesRecipient from './MessengerMessagesRecipient.vue';
import MessengerMessagesSender from './MessengerMessagesSender.vue';

export default {
    props: ['role'],

    components: {
        'cca-recipient-message': MessengerMessagesRecipient,
        'cca-sender-message': MessengerMessagesSender,
    },

    computed: {
        ...mapGetters({
            messages: 'message/list',
            participants: 'thread/participants',
        }),
    },

    methods: {
        isSender: function(message) {
            let user = JSON.parse(localStorage.getItem('user'));
            return message.user_id === user.id;
        },
    },
};
</script>
