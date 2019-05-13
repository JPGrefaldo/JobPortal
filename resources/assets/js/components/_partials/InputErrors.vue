<template>
  <div
    v-if="form.errors.has(field)"
    class="text-red text-xs italic"
    v-html="form.errors.get(field)"
  />
</template>

<script>
export default {
    name: 'has-error',
    props: {
        form: {
            type: Object,
            required: true,
        },
        field: {
            type: String,
            required: true,
        },
    },
}
</script>