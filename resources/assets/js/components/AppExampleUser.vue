<template>
    <span v-if="user"
          id="example-user"
          class="display-none">
        Some Text
    </span>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },

    mounted () {
        this.$nextTick(() => {
            console.log(this.user)
        })
    }
}
</script>

<style scoped>

</style>
