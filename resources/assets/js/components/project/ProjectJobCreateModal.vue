<template>
   <modal @close="close">
        <div slot="body">
            <project-job-create></project-job-create>
        </div>
    </modal>
</template>

<script>
    import ProjectJobCreate from './ProjectJobCreate.vue'
    import Modal from '../_partials/Modal.vue'

    export default {
        components: {
            'modal' : Modal,
            'project-job-create': ProjectJobCreate
        },

        methods: {
            close: function() {
                this.$emit('close')
            }
        }
    }
</script>
