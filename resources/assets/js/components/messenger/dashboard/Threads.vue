<template>
    <div class="flex-1 overflow-auto bg-white"  @onClickSetThread="onClickSetThread" >
        <!-- thread -->
        <div v-if="threads.length === 0">
            <div class="flex p-4 justify-center text-grey-dark">
                <div class="fa fa-arrow-left mr-2"></div>
                Select a project
            </div>
        </div>
        <div v-else>
            <button v-for="thread in threads"
                :key="thread.id"
                class="flex items-center justify-center p-2 hover:bg-grey-light w-full"
                @click="onClickSetThread(thread)">
                <div :title="thread.subject"
                    class="h-10 w-10 rounded-full bg-white background-missing-avatar border"></div>
                <div class="p-2 flex-1">
                    <div class="mb-1 truncate w-32">
                        {{ thread.subject }}
                    </div>
                    <p class="text-xs truncate w-32">
                        last message
                    </p>
                </div>
            </button>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { mapGetters } from 'vuex'

    export default {
        props: [ 
            'role' 
        ],
        computed: {
            ...mapGetters({
                project: 'project/project',
                threads: 'thread/list'
            })
        },

        methods: {
            onClickSetThread(thread) {
                this.setThread(thread)

                let params = {
                    role: this.role.toLowerCase(),
                    project: this.project.id
                }
                
                this.$store.dispatch('thread/fetch', params)
                this.$store.dispatch('message/fetch', thread.id)
            },

            setThread(thread) {
                this.$store.commit('thread/THREAD', thread)
            },
        }
    }
</script>
