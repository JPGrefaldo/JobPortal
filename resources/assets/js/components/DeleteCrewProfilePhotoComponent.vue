<template>
    <form>
        <button @click.prevent="deletePhoto"
             class="btn-red" :disabled="form.busy">Delete Profile Picture</button>
    </form>
</template>

<script type="text/javascript">
import Form from '../form.js';
export default {
    name: 'DeleteCrewProfilePhotoComponent',
    props: {
        crew: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: new Form({
                crew: this.crew.id,
            }),
        };
    },
    methods: {
        deletePhoto() {
            this.form
                .delete('/crew/photos/' + this.crew.id, this.form)
                .then(response => {
                    this.deleteNotification();
                });
        },
        deleteNotification() {
            this.$swal({
                   title: "Profile Picture Deleted",
                   type: "success",
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/crew/profile/edit';
                }
            });
        }
    }
};
</script>
