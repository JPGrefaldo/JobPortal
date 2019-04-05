<template>
    <main class="md:w-3/4 float-left">
        <project-form :mode="'create'"></project-form>
    </main>
</template>

<script>
import ProjectForm from './ProjectForm.vue';
export default {
    components: {
        'project-form': ProjectForm,
    },
};
</script>
