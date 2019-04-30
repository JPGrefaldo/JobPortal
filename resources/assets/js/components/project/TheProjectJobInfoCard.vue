<template>
    <div>
        <div class="flex justify-between items-center">
            <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> {{ job.position.name }} <span
                    class="badge"><strong>{{ job.persons_needed }}</strong> needed</span></h3>
            <div>
                <span class="h4 mr-2 text-yellow inline-block text-xs"><i
                        class="fas fa-pause mr-1"></i>paused</span>
                <a class="btn-more inline-block" href="#"></a>
            </div>
        </div>
        <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4">
            <div class="md:w-1/2 px-2">
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PAY:</strong> {{ pay(job.pay_rate, job.pay_type.name) }}
                </div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>UNION</strong> (but accepting non-union submissions)
                </div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>EQUIPMENT:</strong> provided by production
                </div>
            </div>
            <div class="md:w-1/2 px-2">
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PRODUCTION TITLE:</strong> {{ project.title }}
                </div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>PRODUCTION COMPANY: </strong> {{ project.production_name }}
                </div>
                <div class="block text-sm text-blue-dark py-1">
                    <strong>LOCATION: </strong> {{ project.location }}
                </div>
            </div>
        </div>

        <div class="md:flex mt-6">
            <div class="w-full md:w-1/4">
                <h4 class="text-grey mb-3 md:mb-0 mt-1">job details</h4>
            </div>
            <div class="w-full md:w-3/4">
                <p> {{ job.notes | truncate(100) }}
                    <a class="text-sm" href="#" @click.stop="showProjectJobModal(job)">MORE</a>
                </p>
            </div>
        </div>
    </div>    
</template>

<script>
    import { format, modals } from '../../mixins'

    export default {
        props: ['job', 'project'],

        mixins: [format, modals],

        methods: {
            showProjectJobModal: function (job) {
                this.projectJobViewModal(job)
            },
        }
    }
</script>

