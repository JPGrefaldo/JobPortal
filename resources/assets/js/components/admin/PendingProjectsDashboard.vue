<template>
    <div>
        <div v-for="project in projects" :key="project.id">
            <p>Title: {{ project.title }}</p>
            <p>Production Name: {{ project.production_name }}</p>
            <hr>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            projects: []
        }
    },
    methods: {
        fetchPendingProjects: function() {
            axios.get('/api/admin/projects/unapproved')
                .then(response => {
                    this.projects = response.data.projects
                })
        }
    },
    mounted() {
        this.fetchPendingProjects()
    }
}
</script>

<style>

</style>