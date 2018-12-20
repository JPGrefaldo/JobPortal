<template>
    <a href="#"
       :class="classes"
       @click.prevent="onClick">
        <slot />

        <form ref="logoutLinkForm"
              action="/logout"
              method="POST"
              class="logout-link-form">
            <input type="hidden"
                   name="_token"
                   :value="csrf">
        </form>
    </a>
</template>

<script>
export default {
    props: {
        csrf: {
            type: String,
            default: ''
        },
        classes: {
            type: String,
            default: ''
        }
    },

    methods: {
        onClick (e) {
            this.$store.dispatch('aut/logout')
            this.$refs.logoutLinkForm.submit()
        }
    }
}
</script>

<style scoped>
    .logout-link-form {
        display: none;
    }
</style>
