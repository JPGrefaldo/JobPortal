<template>
    <div class="bg-white rounded flex flex-col shadow-lg p-8 mb-4">
        <div class="my-2">You previously approved Mike Kevin Castro's endorsement request.</div>
        <div class="my-2">Comment:</div>
        <input
            class="shadow appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
            name="comment"
            type="text"
            placeholder="Good luck out there!"
            v-model="form.comment"
            :disabled="isSending">
        <button
            class="my-2 bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded align-baseline"
            @click.prevent="updateEndorsement()">
            Update Endorsement Request
        </button>
    </div>
</template>

<script type="text/javascript">
    import Form from '../form.js';

    export default {
        name: "CreateEndorsementRequestFormComponent",
        props: {
            url: {
                type: String,
                required: true
            },
            comment: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                form: new Form({
                    comment: this.comment
                }),
                isSending : false,
            }
        },
        methods: {
            updateEndorsement() {
                this.isSending = true;
                this
                    .form
                    .put(this.url, this.form)
                    .then(response => {
                        window.location = '/dashboard';
                    })
                    .catch(response => {
                        this.isSending = false;
                        this.form.errors.record(response.errors);
                    });
            },
        }
    }
</script>

