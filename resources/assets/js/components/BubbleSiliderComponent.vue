<template>
    <span class="border rounded-full border-grey flex items-center cursor-pointer my-4 w-12"
          v-bind:id="name"
          v-bind:class="[isOn ? 'switch-on' : 'switch-off']"
          v-on:click="switchState"
    >
    <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow"></span>
    <input type="hidden" v-bind:value="[isOn ? 1 : 0]" v-bind:name="name">
</span>
</template>

<script type="text/javascript">
    export default {
        name: "BubbleSliderComponent",
        props: {
            on: Boolean,
            name: String,
            value: String,
        },
        data() {
            return {
                isOn: this.on,
            }
        },
        methods: {
            switchState: function() {
                this.isOn = ! this.isOn;
            }
        }
    };
</script>

<style scoped>

</style>