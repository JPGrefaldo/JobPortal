<template>
<div class="flex h-full">
    <!-- left pane -->
    <div class="flex w-2/5 border-r border-black">
        <div class="flex-1 overflow-auto bg-white">
            <div v-if="typeof allFlags === 'undefined'" class="bg-white flex flex-col p-4">
                <p>No pending flag messages</p>
            </div>
            <!-- <div v-if="allFlags.length == 0" class="bg-white flex flex-col p-4"><p>No pending flag messages</p></div> -->
            <div v-for="flag in allFlags" :key="flag.key" @click="setReason($event, flag.reason, flag.id)">
                <button class="flex items-center justify-center p-2 hover:bg-grey-light w-full">
                    <div class="h-10 w-10 rounded-full bg-white background-missing-avatar border">
                    </div>
                    <div class="p-2 flex-1">
                        <p class="text-xs" style="text-align: left;">Flag ID: {{ flag.id }} | Thread: {{ flag.thread }}</p>
                        <div style="text-align: left;">{{ flag.message }}</div>
                        <p class="text-xs" style="text-align: left;">By: {{ flag.message_owner }}</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <cca-flag-reason :reason="reason" :flagId="messageId" v-on:refreshPage="fetchFlags()" />
</div>
</template>

<script>
import axios from 'axios'
import FlagMessengerReason from './FlagMessengerReason.vue'

export default {
    name: "Flags",
    data() {
        return {
            allFlags: [],
            reason: '',
            messageId: null,
        }
    },
    mounted() {
        this.$on('refreshList', function() {
            this.reason = ''
            this.messageId = ''
            this.fetchFlags()
        })
    },
    components: {
        'cca-flag-reason': FlagMessengerReason
    },
    methods: {
        fetchFlags: function() {
            axios.get('/api/admin/flag-messages')
                .then(response => {
                    this.allFlags = response.data.data
                })
        },
        setReason: function(event, reason, messageId) {
            this.reason = reason,
            this.messageId = messageId
        }
    },
    created() {
        this.fetchFlags()
    }
}
</script>
