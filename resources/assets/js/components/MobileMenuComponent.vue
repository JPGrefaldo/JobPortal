<template>
    <li class="py-2 px-4">
        <a v-bind:href="link" class="block text-blue-dark hover:text-green" @click="follow($event)">{{ text }}</a>
    </li>
</template>

<script type="text/javascript">
    export default {
        name: "MobileMenuComponent",
        props: {
            link: String,
            text: String,
        },
        methods: {
            follow: function(event) {
                window.location = event.target.href;
            }
        }
    };
</script>

<style scoped>

</style>