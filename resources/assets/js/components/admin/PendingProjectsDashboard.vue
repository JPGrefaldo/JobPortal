<template>
    <div>
        <p>This is working</p>
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
            axios.get('/api/admin/pending-projects')
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
