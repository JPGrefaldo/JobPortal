<template>
    <div class="bg-white rounded flex flex-col shadow-lg p-8 mb-4">
        <div class="my-2">Mike Kevin Castro is asking for your to approve his endorsement request for Set Decorator</div>
        <div class="my-4">Please feel free to leave a comment for this endorsement request.</div>
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
            @click.prevent="storeEndorsement()">
            Approve Endorsement Request
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
        },
        data() {
            return {
                form: new Form({
                    comment: '',
                }),
                isSending : false,
            }
        },
        methods: {
            storeEndorsement() {
                this.isSending = true;
                this
                    .form
                    .post(this.url, this.form)
                    .then(response => {
                        endorser.isSending = false;
                        window.location = '/dasboard';
                    })
                    .catch(response => {
                        this.isSending = false;
                        this.form.errors.record(response.errors);
                    });
            },
        }
    }
</script>

