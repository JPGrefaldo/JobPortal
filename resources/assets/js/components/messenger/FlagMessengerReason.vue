<template>
    <div class="w-3/5 bg-white flex flex-col p-4">
        <p>{{ reason }}</p>
        <p v-if="reason !== ''"><a href="">Approve</a> / <a href="">Disapprove</a></p>
        <p v-else>Select an item</p>
    </div>
</template>

<script>
export default {
    props: [
        'reason'
    ]
}
</script>
