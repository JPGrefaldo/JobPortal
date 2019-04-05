<template>
    <div>
        <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                Project's Job Added
            </h3>
        </div>

        <div v-if="jobs.length > 0">
            <project-job-edit
                v-for="job in jobs"
                :key="job.id"
                :projectJob="job"
            ></project-job-edit>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import ProjectJobEdit from './ProjectJobEdit.vue';

export default {
    components: {
        'project-job-edit': ProjectJobEdit,
    },

    computed: {
        ...mapGetters({
            jobs: 'project/jobs',
        }),
    },
};
</script>
