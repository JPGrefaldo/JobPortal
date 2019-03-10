<template>
    <div>
        <div v-if="departments">
            <input v-model="department.name" type="button" v-for="department in departments" :key="department.id">
        </div>
        <cca-position :position="position"></cca-position>
    </div>
</template>

<script>
    import Position from './Position.vue'

    export default {
        props: ['department', 'position'],

        components: {
            'cca-position': Position
        },
        data(){
            return {
                departments: null,
            }
        }
    }
</script>
