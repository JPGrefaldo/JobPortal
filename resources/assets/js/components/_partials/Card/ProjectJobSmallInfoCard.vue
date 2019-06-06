<template>
    <div class="px-2">
        <div class="flex flex-wrap -mx-2">
             <div class="w-1/4 px-2" v-for="job in jobs" :key="job.id">
                <div class="mt-4 bg-white rounded p-8 shadow">
                    <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                        {{ job.position.name }}
                        <span class="badge"><strong>{{ job.persons_needed }}</strong> needed</span>
                    </h3>
                    <small class="font-bold font-header text-blue-darker block">
                        {{ job.project.title }}
                    </small>
                    <small class="text-blue-darker block mb-3">
                        {{ job.project.location }}
                    </small>

                    <div class="badge mt-3 text-black">

                            <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-24">
                                <span class="font-bold font-header text-blue-darkr block md:text-right">
                                    Rush Call
                                </span>
                            </div>
                            <div class="md:w-2/3">
                                {{ booleanForHumans(job.rush_call) }}
                            </div>
                        </div>

                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-24">
                                <span class="font-bold font-header text-blue-darkr block md:text-right mb-2">
                                    PAY
                                </span>
                            </div>
                            <div class="md:w-2/3">
                                {{ pay(job.pay_rate, job.pay_type.name) }}
                            </div>
                        </div>

                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-24">
                                <span class="font-bold font-header text-blue-darkr block md:text-right mb-2">
                                    UNION
                                </span>
                            </div>
                            <div class="md:w-2/3">
                                (but accepting non-union submissions)
                            </div>
                        </div>

                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-24">
                                <span class="font-bold font-header text-blue-darkr block md:text-right mb-2">
                                    Gear Provided
                                </span>
                            </div>
                            <div class="md:w-2/3">
                                {{ job.gear_provided }}
                            </div>
                        </div>

                        <div class="md:flex py-2">
                            <div class="md:w-1/3 pr-24">
                                <span class="font-bold font-header text-blue-darkr block md:text-right mb-2">
                                    Gear Needed
                                </span>
                            </div>
                            <div class="md:w-2/3">
                                {{ job.gear_needed }}
                            </div>
                        </div>


                    </div>

                    <div class="pt-4">
                        <label class="text-blue-dark">Job Details</label>
                        <p class="text-justify">
                            {{ job.notes }}
                        </p>
                    </div>

                    <slot name="job" :job="job"></slot>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
    import {format} from '../../../mixins'

    export default {
        props: {
            jobs: {
                type: Array,
                required: true
            }
        },

        mixins: [format],
    }
</script>
