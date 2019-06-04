<template>
    <div class="md:w-3/4 float-left">
        <project-form :mode="'create'"></project-form>
    </div>
</template>

<script>
import ProjectForm from './ProjectForm.vue';
export default {
    components: {
        'project-form': ProjectForm,
    },
};
</script>
