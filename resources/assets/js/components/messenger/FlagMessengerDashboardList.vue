<template>
    <div class="flex-1 overflow-auto bg-white">
        <div v-for="flag in allFlags" :key="flag.key">
            <button class="flex items-center justify-center p-2 hover:bg-grey-light w-full">
                <div class="h-10 w-10 rounded-full bg-white background-missing-avatar border">
                </div>
                <div class="p-2 flex-1">
                    <div style="text-align: left;">{{ flag.message }}</div>
                    <p class="text-xs" style="text-align: left;">{{ flag.message_owner }}</p>
                </div>
            </button>
        </div>
        
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "Flags",
    data() {
        return {
            allFlags: [],
            tests: [
                'test1',
                'test2',
                'test3'
            ]
        }
    },
    methods: {
        fetchFlags: function() {
            axios.get('/api/admin/flag-messages')
                .then(response => {
                    this.allFlags = response.data.data
                })
        }
    },
    created() {
        this.fetchFlags()
    }
}
</script>
