<template>
    <div class="flex-1 overflow-auto bg-white">
        <!-- thread -->
        <button class="flex items-center justify-center p-2 hover:bg-grey-light w-full"
            v-for="thread in threads" :key="thread.id"
            @click="$emit('onClickSetThread', thread)">
            <div class="h-10 w-10 rounded-full bg-white background-missing-avatar border"></div>
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
</template>

<script type="text/javascript">
    export default {

        props: {
            threads: {
                type: Array,
                required: false
            },
        },

        data() {
            return {
            }
        },

        methods: {
        }
    }
</script>
