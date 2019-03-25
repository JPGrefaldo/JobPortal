<template>
    <main class="md:w-3/4 float-left">
       <project-form></project-form>
    </main>
</template>

<script>
    import ProjectForm from './ProjectForm.vue'

    export default {
        props: {
            project: {
                type: Object,
                required: true
            }
        },

        components: {
            'project-form': ProjectForm
        },

        mounted() {
            this.$store.commit('project/PROJECT', this.project)
        }
    }
</script>
