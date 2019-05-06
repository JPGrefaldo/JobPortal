<template>
    <div>
        <div v-for="department in departments" :key="department.id">
            <cca-work-position-component :department="department" />
        </div>
    </div>
</template>

<script>
import WorkPositionComponent from './WorkPositionComponent';
export default {
    components: { WorkPositionComponent },
    props: {
        departments: Array,
        positions  : Array,
    },
};
</script>
