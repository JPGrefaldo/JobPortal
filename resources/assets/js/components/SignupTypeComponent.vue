<template>
    <div class="bg-white md:shadow md:border border-grey-light md:rounded-full overflow-hidden md:flex text-center items-stretch">
        <input type="button"
               class="block text-center border-grey-light p-3 mb-2 border rounded-full sm-only:w-full md:w-1/2 md:mb-0 md:rounded-none md:border-t-0 md:border-b-0 md:border-r"
               id="select-want-project"
               value="Hire for a Project"
               v-on:click="switchState('Producer')"
               v-bind:class="[isProducerGreen ? 'want-to__selected' : 'want-to__default']"
        >
        <input type="button"
               class="block border md:border-none border-grey-light sm-only:w-full md:border-none text-center rounded-full md:rounded-none md:w-1/2 p-3"
               id="select-want-work"
               value="Work as Crew"
               v-on:click="switchState('Crew')"
               v-bind:class="[isCrewGreen ? 'want-to__selected' : 'want-to__default']"
        >
        <input type="hidden" v-bind:name="[isProducerGreen ? 'type[]' : 'trash']" v-bind:value="producerType">
        <input type="hidden" v-bind:name="[isCrewGreen ? 'type[]' : 'trash']" v-bind:value="crewType">
    </div>
</template>

<script type="text/javascript">
    export default {
        name: "SignupTypeComponent",
        props: {
            isProducerActive: Boolean,
            isCrewActive: Boolean,
            producerType: String,
            crewType: String,
        },
        data() {
            return {
                isCrewGreen: this.isCrewActive,
                isProducerGreen: this.isProducerActive,
            }
        },
        methods: {
            switchState: function(type) {
                if (type === 'Producer') {
                    this.isProducerGreen = ! this.isProducerGreen;
                } else {
                    this.isCrewGreen = ! this.isCrewGreen;
                }
            }
        }
    };
</script>

<style scoped>

</style>