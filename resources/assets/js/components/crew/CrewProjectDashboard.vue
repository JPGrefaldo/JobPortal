<template>
    <div>
        <button class="btn btn-green float-right mt-1">Subscribe</button>
        <tabs>
            <tab :key="1" :name="'Open'" :active="'#open'">
                <div class="px-2">
                    <div class="flex flex-wrap -mx-2">

                        <div class="w-1/4 px-2">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    Set Designer
                                    <span class="badge"><strong>8</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            $1.00/per hour
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Suspendisse vestibulum tellus justo, quis accumsan dolor vehicula ut. 
                                        Integer dui orci, fringilla vitae ultrices et, pulvinar at mi. 
                                        Nam eu lacus sit amet urna viverra fermentum.
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


                        <div class="w-1/4 px-2">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    Camera Man
                                    <span class="badge"><strong>11</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            $1.00/per hour
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Suspendisse vestibulum tellus justo, quis accumsan dolor vehicula ut. 
                                        Integer dui orci, fringilla vitae ultrices et, pulvinar at mi. 
                                        Nam eu lacus sit amet urna viverra fermentum.
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

                        <div class="w-1/4 px-2">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    Gaffer
                                    <span class="badge"><strong>2</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            $1.00/per hour
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Suspendisse vestibulum tellus justo, quis accumsan dolor vehicula ut. 
                                        Integer dui orci, fringilla vitae ultrices et, pulvinar at mi. 
                                        Nam eu lacus sit amet urna viverra fermentum.
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


                        <div class="w-1/4 px-2">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    Video Editor
                                    <span class="badge"><strong>1</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            $1.00/per hour
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Suspendisse vestibulum tellus justo, quis accumsan dolor vehicula ut. 
                                        Integer dui orci, fringilla vitae ultrices et, pulvinar at mi. 
                                        Nam eu lacus sit amet urna viverra fermentum.
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

                        <div class="w-1/4 px-2">
                            <div class="mt-4 bg-white rounded p-8 shadow">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> 
                                    Set Designer
                                    <span class="badge"><strong>8</strong> needed</span>
                                </h3>

                                <div class="badge mt-3 text-black">
                                    <div class="md:flex py-2">
                                        <div class="md:w-1/3 pr-24">
                                            <span class="font-bold font-header text-blue-darkr block md:text-right mb-3">
                                                PAY
                                            </span>
                                        </div>
                                        <div class="md:w-2/3">
                                            $1.00/per hour
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Suspendisse vestibulum tellus justo, quis accumsan dolor vehicula ut. 
                                        Integer dui orci, fringilla vitae ultrices et, pulvinar at mi. 
                                        Nam eu lacus sit amet urna viverra fermentum.
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
    import Tab from '../_partials/Tab.vue'
    import Tabs from '../_partials/Tabs.vue'
    import ProjectCard from '../project/ProjectCard.vue'

    export default {
        props: {
            projects: {
                type: Array,
                required: true
            }
        },

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