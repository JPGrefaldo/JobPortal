<template>
    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
        <div class="flex my-3 items-center">
            <div class="w-1/3">Endorser name</div>
            <div class="w-1/3">Endorser email</div>
            <button
                class="flex bg-green rounded-full h-8 w-8 items-center justify-center font-bold"
                @click.prevent="addEndorserField()">+</button>
        </div>
        <div v-for="(endorser, index) in form.endorsers">
            <div class="flex my-6">
                <input name="endorser_name" class="w-1/3" type="text" placeholder="John Doe" v-model="endorser.endorser_name" :disabled="isSending">
                <input name="endorser_email" class="w-1/3" type="email" placeholder="john@email.com" v-model="endorser.endorser_email">
                <button
                    class="flex bg-grey-light rounded-full h-8 w-8 items-center justify-center"
                    @click.prevent="removeEndorserField(index)">x</button>
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
        props: {
            url: {
                type: String,
                required: true
            },
        },
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
                isSending: false,
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
            removeEndorserField(index) {
                if (this.form.endorsers.length === 1) {
                   return;
                }
                this.form.endorsers.splice(index, 1);
            },
            storeEndorsementRequest() {
                // async request to send for each endorser field
                // make sure to disable all endorsers fields
                // change the endorser field to some sort of response
                    // can either be
                        // " hey you already sent",
                        // "we sent your request. Here's to hoping endorser will approve :)"
                this.form.endorsers.forEach(endorser => {
                    console.log(endorser.endorser_name);
                    this.isSending = true;
                    this
                        .form
                        .post(this.url, this.form)
                        .then(response => {
                            console.log(response)
                            this.isSending = false;
                        })
                        .catch(errors => {
                            console.log(errors)
                            console.log(errors.errors)
                            console.log(errors.errors.endorser)
                            console.log(errors.errors.endorser.name)
                            console.log(errors.errors.endorser.email)
                        });
                });
            },
        }
    }
</script>

