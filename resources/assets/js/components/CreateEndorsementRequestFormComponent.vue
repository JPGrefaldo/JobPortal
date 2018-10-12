<template>
    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
        <div class="flex my-3 items-center">
            <div class="w-1/3">Endorser name</div>
            <div class="w-1/3">Endorser email</div>
            <button
                class="flex bg-green rounded-full h-8 w-8 items-center justify-center font-bold"
                @click.prevent="addEndorserField()">+</button>
        </div>
        <div v-for="(endorser, index) in endorsers">
            <form @submit.prevent="" @keydown="endorser.form.errors.clear($event.target.name)">
                <div class="my-6">
                    <div class="flex items-center">
                        <input
                            class="w-1/3 shadow appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            name="name"
                            type="text"
                            placeholder="John Doe"
                            v-model="endorser.form.name"
                            :disabled="endorser.isSending">
                        <input
                            class="w-1/3 shadow appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            name="email"
                            type="email"
                            placeholder="john@email.com"
                            v-model="endorser.form.email"
                            :disabled="endorser.isSending">
                        <button
                            class="flex bg-grey-light rounded-full h-8 w-8 items-center justify-center"
                            @click.prevent="removeEndorserField(index)">x</button>
                    </div>
                    <div class="flex">
                        <p class="w-1/3 text-red text-xs italic">
                            {{ endorser.form.errors.get('name') }}
                        </p>
                        <p class="w-1/3 text-red text-xs italic">
                            {{ endorser.form.errors.get('email') }}
                        </p>
                    </div>
                </div>
            </form>
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
        props: {
            url: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                endorsers: [{
                    form: new Form({
                        name: '',
                        email: '',
                    }),
                    isSending : false,
                }],
            }
        },
        methods: {
            addEndorserField() {
                this.endorsers.push({
                    form: new Form({
                        "name" : '',
                        "email" : '',
                    }),
                    isSending : false,
                });
            },
            removeEndorserField(index) {
                if (this.endorsers.length === 1) {
                    return;
                }
                this.endorsers.splice(index, 1);
            },
            storeEndorsementRequest() {
                this.endorsers.forEach(endorser => {
                    endorser.isSending = true;
                    endorser
                        .form
                        .post(this.url, endorser.form)
                        .then(response => {
                            // TODO open a toast with the response
                            // "we sent your request. Here's to hoping endorser will approve :)"
                            endorser.isSending = false;
                        })
                        .catch(response => {
                            endorser.isSending = false;
                            endorser.form.errors.record(response.errors);
                        });
                });
            },
        }
    }
</script>

