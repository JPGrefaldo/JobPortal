<template>
    <div>
        <div v-for="department in departments" :key="department.id">
            <cca-work-position-component :department="department" />
        </div>
    </div>
</template>

<script>
import WorkPositionComponent from './WorkPositionComponent';
import { mapGetters } from 'vuex';
export default {
    components: { WorkPositionComponent },
    props: {
        departments: Array,
    },
    mounted() {
        this.$store.dispatch('crew/checkPositionIfExist');
    }
};
</script>
