<template>
    <div class="w-3/5 bg-white flex flex-col p-4">
        <div v-if="reason !== ''">
            <strong>Flag ID: {{ messageId }}</strong>
            <p>{{ reason }}</p>
            <p><a href="">Approve</a> / <a href="">Disapprove</a></p>
        </div>
        <div v-else>
            <p>Select an item</p>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'reason',
        'messageId'
    ]
}
</script>
