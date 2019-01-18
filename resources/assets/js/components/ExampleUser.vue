<template>
    <span v-if="user"
          id="example-user"
          class="display-none">
        {{ user.first_name }}
        {{ user.last_name }}
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
}
</script>

<style scoped>

</style>
