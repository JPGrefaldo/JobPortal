<template>
    <div>
        <button class="btn btn-green float-right mt-2 py-3">Subscribe</button>
        <tabs>
            <tab :key="1" :name="'Open'" :active="'#open'">
                <div class="px-2">
                    <div class="flex flex-wrap -mx-2">

                        <div class="w-1/4 px-2" v-for="job in jobs" :key="job.id">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    {{ job.position.name }}
                                    <span class="badge"><strong>{{ job.persons_needed }}</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            {{ pay(job.pay_rate, job.pay_type.name) }}
                                        </div>
                                    </div>

                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                UNION
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            (but accepting non-union submissions)
                                        </div>
                                    </div>

                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                EQUIPMENT
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            provided by production
                                        </div>
                                    </div>
                                </div>
      
                                <div class="pt-4">
                                    <label class="text-blue-dark">Job Details</label>
                                    <p class="text-justify">
                                        {{ job.notes }}
                                    </p>
                                </div>

                                <div class="clearfix">
                                    <div class="float-right mt-4">
                                        <button class="btn-blue font-bold py-2">Ignore</button>
                                        <button class="btn-green font-bold py-2">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tab>
            <tab :key="2" :name="'Applied'"><h1>Applied</h1></tab>
            <tab :key="3" :name="'Ignored'"><h1>Ignored</h1></tab>
        </tabs>
    </div>
</template>
<script>
    import {format} from '../../mixins'
    import Tab from '../_partials/Tab.vue'
    import Tabs from '../_partials/Tabs.vue'
    import ProjectCard from '../project/ProjectCard.vue'

    export default {
        props: {
            jobs: {
                type: Array,
                required: true
            }
        },

        mixins: [format],

        data() {
            return {
                index: 0
            }
        },

        components: {
            tab: Tab,
            tabs: Tabs,
            'project-card': ProjectCard
        },

        created: function() {

        },

        computed: {

        }
    }
</script>