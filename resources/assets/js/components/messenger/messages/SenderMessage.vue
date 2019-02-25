<template>
    <div class="flex mb-4">
        <div class="flex-1"></div>
        <div class="rounded-lg text-white p-3 max-w-md"
            :class="getColorByRole(role)">
            {{ message.body }}
        </div>
    </div>
</template>

<script>
    import { color } from '../../../mixins'

    export default {
        props: [
            'message', 'role'
        ],

        mixins: [
            color
        ]
    }
</script>
