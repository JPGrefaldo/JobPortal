<template>
    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
        <div class="flex my-3 items-center">
            <div class="w-1/3">Endorser name</div>
            <div class="w-1/3">Endorser email</div>
            <button
                class="flex bg-green rounded-full h-8 w-8 items-center justify-center font-bold"
                @click.prevent="addEndorserField()">+</button>
        </div>
        <div v-for="endorser in form.endorsers">
            <div class="flex my-6">
                <input name="endorser_name" class="w-1/3" type="text" placeholder="John Doe" v-model="endorser.endorser_name">
                <input name="endorser_email" class="w-1/3" type="email" placeholder="john@email.com" v-model="endorser.endorser_email">
            </div>
        </div>
        <div>
            <button
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded align-baseline"
                @click.prevent="storeEndorsementRequest()">
                Ask Endorsement
            </button>
        </div>

    </div>
</template>

<script type="text/javascript">
    import Form from '../form.js';

    export default {
        name: "CreateEndorsementRequestFormComponent",
        props: ['url'],
        data() {
            return {
                form: new Form({
                    endorsers: [
                        {
                            endorser_name: '',
                            endorser_email: '',
                        }
                    ]
                }),
            }
        },
        methods: {
            addEndorserField() {
                this.form.endorsers.push(
                    {
                        "endorser_name": '',
                        "endorser_email": ''
                    }
                );
            },
            storeEndorsementRequest() {
                // post request
                // this
                //     .form
                //     .post(this.url, this.form)
                //     .then()
                //     .catch();
            },
            create() {
                // TODO: handle data validation after post
                // review promise errors
                this
                    .form
                    .post(this.url, this.form)
                    .then(
                        () => {
                            // things to do when success
                            // self.form.finishProcessing();
                            // window.location.href = '/projects/create';
                        },
                        (error) => {
                            this.form.setErrors(error.response.data.errors);
                        }

                    );
                // this.form.setErrors(error.response.data.errors);
            },

            validateFields() {
                let hasErrors = false;

                if (! this.form.details) {
                    this.form.errors.set({
                        details: ['Details is required'],
                    });
                    hasErrors = true;
                }

                if (! this.form.union_description) {
                    this.form.errors.set({
                        days: ['Union description is required'],
                    });
                    hasErrors = true;
                }

                return ! hasErrors;
            },
        }
    }
</script>

