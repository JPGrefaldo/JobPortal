<template>
    <div class="card mb-6 sm-only:p-2">
        <div class="pb-6">
            <h3
                class="text-blue-dark font-semibold text-lg mb-1 font-header"
                v-text="department.name"
            ></h3>
        </div>
        <div
            class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white"
            v-for="position in department.positions"
            :key="position.id"
        >
            <cca-position-component :position="position" />
        </div>
    </div>
</template>
<script type="text/javascript">
import PositionComponent from './PositionComponent';
export default {
    components: { PositionComponent },
    props: {
        department: Object,
    },
};
</script>
