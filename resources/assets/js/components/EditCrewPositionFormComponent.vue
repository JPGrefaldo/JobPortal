<template>
    <div>
        <form @submit.prevent="" @keydown="form.errors.clear($event.target.name)">
            <div class="flex">
                <div class="w-1/2 mr-4">
                    <div>
                        Details:
                    </div>
                    <textarea
                        name="details"
                        cols="30"
                        rows="10"
                        class="w-full"
                        v-model="form.details"
                    ></textarea>
                    <p class="w-1/3 text-red text-xs italic">
                        {{ form.errors.get('details') }}
                    </p>
                </div>

                <div class="w-1/2 ml-4">
                    <div>
                        Union Description:
                    </div>
                    <textarea
                        name="union_description"
                        cols="30"
                        rows="10"
                        class="w-full"
                        v-model="form.union_description"
                    ></textarea>
                    <p class="w-1/3 text-red text-xs italic">
                        {{ form.errors.get('union_description') }}
                    </p>
                </div>
            </div>

            <button
                type="submit"
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 mt-4 rounded"
                @click.prevent="updateCrewPosition"
                :disabled="form.busy"
            >
                Edit
            </button>
        </form>
    </div>
</template>

<script type="text/javascript">
import Form from '../form.js';

export default {
    name: 'CreateCrewPositionFormComponent',
    props: {
        url: {
            type: String,
            required: true,
        },
        details: {
            type: String,
            required: true,
        },
        union_description: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            form: new Form({
                details: this.details,
                union_description: this.union_description,
            }),
        };
    },
    methods: {
        updateCrewPosition() {
            this.form
                .put(this.url, this.form)
                .then(response => {
                    window.location = '../';
                })
                .catch(response => {
                    this.form.errors.record(response.errors);
                });
        },
    },
};
</script>
