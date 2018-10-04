<template>
    <div class="flex flex-col">
        <div class="my-2">
            Details:
        </div>
        <textarea name="details" id="" cols="30" rows="10" v-model="form.details"></textarea>

        <div class="my-2">
            Union Description:
        </div>
        <textarea name="union_description" id="" cols="30" rows="10" v-model="form.union_description"></textarea>

        <div>
            <button
                type="submit"
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 mt-4 rounded"
                @click.prevent="create"
                :disabled="form.busy">
                Apply
            </button>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Form from '../form.js';

    export default {
        name: "CreateCrewPositionFormComponent",
        props: ['url', 'details', 'union_description'],
        data() {
            return {
                form: new Form({
                    details: details,
                    union_description: union_description,
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

