<template>
    <div class="flex-1 overflow-auto bg-white">
        <!-- thread -->
        <div class="flex items-center justify-center p-2 hover:bg-grey-light"
            v-for="thread in threads" :key="thread.id"
            @click="onClickSetThread(thread)">
            <div class="h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
            <div class="p-2 flex-1">
                <div class="mb-1 truncate w-32">
                    {{ thread.subject }}
                </div>
                <p class="text-xs truncate w-32">
                    {{ thread.messages[0].body }}
                </p>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {

        props: {
            threads: {
                type: Array,
                required: true
            },
        },

        data() {
            return {
                thread: {}
            }
        },

        methods: {
            onClickSetThread: function (thread) {
                this.setThread(thread);
            },

            setThread(thread) {
                this.$emit('setThread', thread);
            }
        }
    }
</script>
