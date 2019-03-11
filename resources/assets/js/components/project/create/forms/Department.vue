<template>
    <div v-if="departments">
        <input v-model="department.name" type="button" v-for="department in departments" :key="department.id">
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        mounted(){
            this.$store.dispatch('crew/fetchDepartments')
        },

        computed: {
            ...mapGetters({
                departments: 'crew/departments'
            })
        }
    }
</script>
