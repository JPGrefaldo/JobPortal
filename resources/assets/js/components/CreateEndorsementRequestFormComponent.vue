<template>
    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
        <div class="flex">
            <div>Endorser name</div>
            <div>Endorser email</div>
        </div>
        <div class="flex">
            <input type="text" placeholder="John Doe">
            <input type="email" placeholder="john@email.com">
            <button class="bg-red rounded-full p-2 w-8 ">+</button>
        </div>
        <div>
            <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded align-baseline">
                Ask Endorsement
            </button>
        </div>

            <form>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="endorser_name_1">
                            Endorser name
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                            id="endorser_name_1" type="text" placeholder="John Doe">
                    </div>
                    <div class="px-3">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="endorser_email_1">
                            Endorser Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                            id="endorser_email_1"
                            type="text"
                            placeholder="joe@example.com">
                    </div>
                    <div class="bg-red rounded-full shadow-lg p-1">+</div>
                </div>
                <div class="w-full md:w-1/3 px-3">
                    <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded align-baseline">
                        Ask Endorsement
                    </button>
                <div>
            </form>
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
                    endorser_name: '',
                    endorser_email: '',
                })
            }
        },
        methods: {
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

