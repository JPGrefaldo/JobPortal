<template>
    <div>
        <modal :show="show" @close="close">
            <div class="p-4 md:p-8 mb-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ proj.title }}
                            <span class="badge">ROLES: {{ proj.jobs.length }}</span>
                        </h2>
                        <div class="text-right">
                            <span class="h4 mb-2 text-yellow block text-xs">
                                Requested submissions</span>
                            <span class="h4 mb-2 text-grey block text-xs">
                                12 days left</span>
                        </div>
                    </div>
                    <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4">
                        <div class="md:w-1/2 px-2">
                            <div class="block text-sm text-blue-dark py-1">
                                <strong>PRODUCTION TITLE:</strong> {{ proj.production_name }}
                            </div>
                            <div class="block text-sm text-blue-dark py-1">
                                <strong>LOCATION: </strong> {{ proj.location }}
                            </div>
                        </div>
                        <div class="md:w-1/2 px-2">
                            <div class="block text-sm text-blue-dark py-1">
                                <strong>STATUS:</strong> {{ status(this.proj.status) }}
                            </div>
                            <div class="block text-sm text-blue-dark py-1">
                                <strong>CREATED:</strong> {{ forHumansDate(proj.created_at) }}
                            </div>
                        </div>
                    </div>
                    <div class="md:flex py-6">
                        <div class="w-full md:w-1/4">
                            <h4 class="text-grey mb-3 md:mb-0 mt-1">Project details</h4>
                        </div>
                        <div class="w-full md:w-3/4">
                            <p>{{ proj.description }}</p>
                        </div>
                    </div>
                </div>
        </modal>
    </div>
</template>

<script>
    import { format } from '../../mixins'
    import Modal from '../_partials/Modal'

    export default {
        props: ['project', 'show'],

        mixins: [format],

        data() {
            return {
                proj: this.project
            }
        },

        components: {
            modal: Modal
        },

        methods: {
            close: function() {
                this.$emit('close')
            },
            status: function(status) {
                return status == 0 ? 'NOT YET APPROVED' : 'APPROVED'
            }
        }
    }
</script>
