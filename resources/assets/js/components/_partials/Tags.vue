<template>
    <div>
        <div v-for="(tag, index) in value" v-bind:key="index" class="px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{index+1}}. {{tag}}</span>

            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6"
                 role="button" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20"
                 @click="remove(index)"
            >
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
        </div>
        <span class="my-2 block"></span>
    </div>

</template>

<script>
    export default {
        name: "Tags",
        props: ['value'],
        methods: {
            remove (index) {
                var clonedValue = this.value.slice()
                clonedValue.splice(index, 1)
                this.$emit('input', clonedValue)
            }
        }
    }
</script>