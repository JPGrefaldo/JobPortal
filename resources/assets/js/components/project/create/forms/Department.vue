<template>
    <div>
        <div v-if="departments">
            <input type="button" v-for="department in departments" :key="department.id" value="department->name">
        </div>
        <cca-position></cca-position>
    </div>
</template>

<script>
    import Position from './Position.vue'

    export default {
        components: {
            'cca-position': Position
        },
        data(){
            return {
                departments: null
            }
        }
    }
</script>
