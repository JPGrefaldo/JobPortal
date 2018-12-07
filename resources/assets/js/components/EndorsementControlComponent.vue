<template>
    <div class="my-6">
        <div v-for="(endorsement, index) in endorsements" class="flex items-center mb-2">
            <div class="w-5/6">{{ endorsement.request.endorser.email }}</div>
            <div class="w-1/6 text-right">
                <button
                    class="btn-red-small"
                    v-on:click.prevent="remove(endorsement, index)"
                >X</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            position: {
                type: String,
                required: true
            },
            type: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                endorsements: (window[this.type] ? JSON.parse(window[this.type]) : [])
            }
        },
        methods: {
            remove(endorsement, index) {
                Vue.swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove endorsement'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/crew/endorsement/positions/request/' + endorsement.id).then(response => {
                            this.endorsements.splice(index, 1);
                            Vue.swal({
                                title: '',
                                text: "Endorsement has been deleted!",
                                type: 'success',
                            });
                        });
                    }
                });

            },
        }
    }
</script>
