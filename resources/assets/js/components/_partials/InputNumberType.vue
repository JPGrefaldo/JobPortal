<template>
    <div class="w-24">
        <div class="flex justify-center border border-grey-light rounded">
            <button class="w-8 h-10" @click="preventNegativeValue(modelValue)">–</button>
            <input type="text" class="bg-light text-center w-8 h-10" 
                   :value="modelValue" @input="updateValue($event.target.value)">
            <button class="w-8 h-10" @click="incrementValue(modelValue)">+</button>
        </div>
    </div>
</template>

<script>
export default {
    model: {
        prop: 'modelValue',
        event: 'input'
    },

    props: ['modelValue'],

    methods: {
        updateValue(value){
            this.$emit('input', value)
        },

        preventNegativeValue(value){
            (value == 1) ? this.$emit('input', 1) : this.$emit('input', value-1)
        },

        incrementValue(value){
            this.$emit('input', value+1)
        }
    }
}
</script>
