<template>
    <div class="bg-white shadow-md rounded mb-8 border border-grey-light">
        <div class="p-8">
            <div class="w-full mb-6 flex justify-between">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">
                    {{project.title}}
                    <span class="badge">{{submissions_count}} submissions</span>
                </h3>
                <a href="#" class="btn-more"></a>
            </div>
            <div class="flex">
                <div class="w-1/4">
                    <h3 class="text-grey">Project details</h3>
                </div>
                <div class="w-3/4">
                    <p>
                        {{project.description | truncate(100)}}
                        <a href="#" class="text-sm">MORE</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-grey-lighter pb-4 px-8 border-t border-grey-light rounded-b">
            <div class="flex justify-between items-center pt-5">
                <div>
                    <a href="#" class="h4" @click.prevent.stop="toggleSelect">
                        {{ project.jobs.length }} Role
                        <span class="btn-toggle inline-block ml-1" :class="{ 'rotate-1/2':selected}"></span>
                    </a>
                    <span class="badge bg-white ml-2">0 active</span>
                    <span class="badge bg-white">2 paused</span>
                </div>
            </div>
            <div v-if="selected">
                <project-job v-for="job in project.jobs" 
                            :key="job.position_id" 
                            :job="job"
                            :project="project" />
            </div>
        </div>
    </div>
</template>

<script>
    import ProjectJobCard from './ProjectJobCard';

    export default {
        components: {
            'project-job': ProjectJobCard
        },
        props: {
            project: Object,
        },
        created() {
            var self = this
            this.submissions_count = this.totalSubmissions(self.project.jobs)
        },
        methods: {
            toggleSelect: function(jobs) {
                this.selected = ! this.selected
            },
            totalSubmissions: function(jobs) {
                let count = 0;
                jobs.forEach(job => {
                    count += job.submissions_count;
                });

                return count
            }
        },
        data() {
            return {
                selected: false,
                submissions_count: 0
            }
        },
    }
</script>