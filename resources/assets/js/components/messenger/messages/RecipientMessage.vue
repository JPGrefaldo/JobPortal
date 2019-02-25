<template>
    <div class="flex items-center justify-center mb-4">
        <div class="mr-4 border h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
        <div class="rounded-lg bg-grey-light p-3 max-w-md">
            {{ message.body }}
        </div>
        <button class="fa fa-flag mr-2 ml-3"
            @click="onClickRequestFlag(message)">
        </button>
        <div class="flex-1"></div>
    </div>
</template>

<script>
    import { messageFlag } from '../../../mixins'

    export default {

        props: [
            'message'
        ],
        
        mixins: [
            messageFlag
        ]
    }
</script>
