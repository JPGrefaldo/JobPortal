<template>
    <div v-if="departments">
        <ul class="flex list-reset rounded w-auto">
            <li>
                <input  class="hover:text-white hover:bg-blue text-blue border-r border-grey-light px-3 py-2"
                        v-model="department.name" type="button" 
                        v-for="department in departments" :key="department.id" 
                        @click="showByDepartment(department.id)">
            </li>
        </ul>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data(){
            return {
                allPositions: []
            }
        },

        mounted(){
            this.$store.dispatch('crew/fetchDepartments')
        },

        computed: {
            ...mapGetters({
                departments: 'crew/departments',
                positions: 'crew/positions'
            })
        },

        methods: {
            showByDepartment(id){
                if (this.allPositions.length === 0){
                    this.allPositions = this.positions
                }

                let positions = this.allPositions.filter(o => o.department_id == id)
                this.$store.commit('crew/POSITIONS', positions)
            }
        }
    }
</script>
