<template>
    <div class="w-1/5 border-b border-r border-black flex items-center justify-center px-2">
        <button class="fa fa-search mr-2"></button>
        <input type="text" class="rounded-full bg-white flex-1 px-3 mr-2 outline-none w-4" placeholder="Search" v-model="keyword">
        <button class="fa fa-edit" @click.stop="search"></button>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
   
    export default {
        data() {
            return {
                keyword: null
            }
        },

        computed: {
            ...mapGetters({
                participants: 'thread/participants',
                thread: 'thread/thread'
            })
        },

        methods:{
            search(){
                let params = {
                    thread: this.thread.id,
                    keyword: this.keyword
                }

                this.$store.commit('message/MESSAGES', [])
                this.$store.dispatch('thread/searchParticipants', params)
            },
        }
    }
</script>