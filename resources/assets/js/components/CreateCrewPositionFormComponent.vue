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
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded"
                @click.prevent="create"
                :disabled="form.busy">
                Apply
            </button>
        </div>
    </div>
</template>

<script type="text/javascript">

    export default {
        name: "CreateCrewPositionFormComponent",
        data() {
            return {
                form: new Form({
                    details: '',
                    union_description: '',
                })
            }
        },
        methods: {
            create() {
                this.form.post(this.url, this.form);
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

