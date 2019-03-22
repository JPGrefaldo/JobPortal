<template>
    <div v-if="departments">
        <tabs>
            <tab v-for="(department, index) in departments" 
                 :key="department.id" 
                 :name="department.name" 
                 :selected="(index == 0)"
            >
                <cca-project-create :positions="showByDepartment(department.id)"></cca-project-create>
            </tab>
        </tabs>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ProjectJobCreate from './ProjectJobCreate.vue'
import Tab from '../_partials/Tab'
import Tabs from '../_partials/Tabs'

export default {
    data() {
        return {
            allPositions: [],
        }
    },
    
    components: {
        'cca-project-create': ProjectJobCreate,
        tab: Tab,
        tabs: Tabs
    },

    computed: {
        ...mapGetters({
            departments: 'crew/departments',
            positions: 'crew/positions',
        })
    },

    methods: {
        showByDepartment(id){
            if (this.allPositions.length === 0){
                this.allPositions = this.positions
            }

            let positions = this.allPositions.filter(o => o.department_id == id)
            return positions
        },
    },

     mounted(){
        this.$store.dispatch('crew/fetchByDepartments')
    },
}
</script>
