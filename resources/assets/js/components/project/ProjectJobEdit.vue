<template>
  <div v-if="projectJob">
    <div class="flex mb-4 items-center">
      <span
        class="w-full mt-4 font-header text-blue-dark font-semibold mb-3"
      >{{projectJob.position.name}}</span>
      <button
        class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded bg-blue hover:bg-blue-dark text-white"
        @click="edit(projectJob)"
      >{{ editTitle }}</button>
      <button
        class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red"
        @click="deleteProjectJob(projectJob.id)"
      >Remove</button>
    </div>

    <div v-if="isEditing">
      <project-job-form :mode="'edit'" :submitProjectJob="submitProjectJob"></project-job-form>
    </div>
  </div>
</template>

<script>
import { alert } from '../../mixins';
import { mapGetters } from 'vuex';
import ProjectJobForm from './ProjectJobForm.vue';

export default {
    props: {
        projectJob: {
            type: Object,
            required: true,
        },
    },

    mixins: [alert],

    components: {
        'project-job-form': ProjectJobForm,
    },

    data() {
        return {
            editTitle: 'Edit',
            isEditing: false,
        };
    },

    computed: {
        ...mapGetters({
            job: 'project/job',
        }),
    },

    methods: {
        edit(job) {
            this.editButtonToggle();
            this.$store.commit('project/JOB', job);
        },

        submitProjectJob() {
            this.$validator.validateAll().then(() => {
                if (this.$validator.errors.items.length === 0) {
                    this.$store.dispatch('project/updateProjectJob', this.job).then(() => {
                        this.editButtonToggle();

                        this.$swal('Job Updated!', 'The job has been updated.', 'success');
                    });
                }
            });
        },

        deleteProjectJob(job) {
            this.displayDeleteNotification().then(result => {
                if (result.value) {
                    this.$store.dispatch('project/deleteProjectJob', job).then(response => {
                        if (response.data === 204) {
                            location.reload();
                        }
                    });
                }
            });
        },

        editButtonToggle() {
            this.isEditing = !this.isEditing;
            this.editTitle = this.isEditing ? 'Hide' : 'Edit';
        },
    },
};
</script>
