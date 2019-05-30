<template>
<div class="md:w-3/4 float-left">
     <project-card v-for="project in projects" :key="project.id" :project="project"/>
</div>
</template>

<script>
    import ProjectCard from '../project/ProjectCard.vue'

    export default {
        props: {
            projects: {
                type : Array,
                required: true,
            }
        },

        components: {
            'project-card': ProjectCard
        }
}
</script>
