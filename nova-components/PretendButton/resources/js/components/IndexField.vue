<template>
    <a v-bind:href="'/pretend/' + field.user_id" class="btn btn-default btn-primary hover:bg-blue-dark font-bold py-2 px-4 rounded-full">
        <svg class="fill-current w-4 h-4 mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M0 2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm7 4v2a3 3 0 1 0 6 0V6a3 3 0 1 0-6 0zm11 9.14A15.93 15.93 0 0 0 10 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"/>
        </svg>
    </a>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
