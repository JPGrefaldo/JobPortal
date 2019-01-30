<template>
    <div class="my-6">
        <div v-for="(endorsement, index) in endorsements" class="flex items-center mb-2">
            <div class="mr-2 pr-2 border-r-2">
                <a href="#" @click.prevent="deleteEndorsement(endorsement, index)">Delete</a>
            </div>
            <div class="">{{ endorsement.request.endorser.email }}</div>
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
            deleteEndorsement(endorsement, index) {
                this.$swal({
                    title: 'Are you sure?',
                    html: "Delete <u>" + endorsement.request.endorser.email + "</u> endorsement?<br />You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove endorsement'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/crew/endorsement/positions/request/' + endorsement.id).then(response => {
                            this.endorsements.splice(index, 1);
                            this.$swal({
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
