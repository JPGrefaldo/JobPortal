<template>
    <div class="bg-white rounded flex-1 shadow-lg p-8 mb-4">
        <form @submit.prevent="">
            <div class="flex-auto">
                <div class="w-full">
                    <label>Email:</label>
                </div>
                <div class="w-full">
                    <input
                        type="email"
                        name="email"
                        class="form-control md:w-1/2 -md:w-full"
                        placeholder="Endorser Email"
                        v-model="form.email"
                        :disabled="isSending"
                        required
                    >
                    <p class="w-1/3 text-red text-xs italic">
                        {{ form.errors.get('email') }}
                    </p>
                </div>
                <div class="w-full mt-2 mb-1">
                    <label>Messsage:</label>
                </div>
                <div class="w-full">
                    <textarea
                        class="form-control w-full h-48"
                        name="message"
                        v-model="form.message"
                        :disabled="isSending"
                        required
                    ></textarea>
                    <p class="w-1/3 text-red text-xs italic">
                        {{ form.errors.get('message') }}
                    </p>
                </div>
                <div class="w-full mt-2 lg:text-right -lg:text-center">
                    <button class="btn-blue" @click.prevent="storeEndorsementRequest()">Send email</button>
                </div>
            </div>
        </form>
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
            position: {
                type: String,
                required: true
            },
            full_name: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                form: new Form({
                    email: '',
                    message: 'Hello,\n' +
                        '\n' +
                        'Can you please endorse me for ' + this.position + ' by clicking on the link below?\n' +
                        '\n' +
                        'Thanks,\n' +
                        this.full_name,
                }),
                isSending : false,
            }
        },

        methods: {
            storeEndorsementRequest() {
                this.isSending = true;
                this.form
                    .post(this.url, this.form)
                    .then(response => {
                        Vue.swal({
                            text: 'Request email sent',
                            type: 'success',
                            onClose: () => {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(response => {
                        this.isSending = false;
                        this.form.errors.record(response.errors);
                    });
            },
        }
    }
</script>

