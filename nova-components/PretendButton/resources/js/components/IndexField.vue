<template>
    <a v-bind:href="'/pretend/' + field.user_id" class="btn btn-default btn-primary"><i class="fas fa-user-friends"></i></a>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
