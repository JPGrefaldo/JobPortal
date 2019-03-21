<template>
    <div v-if="!isAdded">
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Persons needed</span>
            </div>
            <div class="md:w-2/3">
                <person-needed-input v-model="job.persons_needed"></person-needed-input>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Equipment provided</span>
            </div>
            <div class="md:w-2/3">
                <textarea v-model="job.gear_provided" class="w-full form-control h-24" placeholder="Equipment provided by production"></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Equipment needed</span>
            </div>
            <div class="md:w-2/3">
                <textarea v-model="job.gear_needed" class="w-full form-control h-24" placeholder="Equipment needed from operator/crew"></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Pay rate</span>
            </div>
            <div class="md:w-2/3">
                $ <input v-model="job.pay_rate" type="text" class="w-16 text-right form-control" placeholder="00"> 
                <select v-model="job.pay_type_id" class="form-control w-32 text-grey-dark">
                    <option value="1">Per hour</option>
                    <option value="2">Day</option>
                    <option value="3">Half Day</option>
                </select>
            
                <span class="my-2 block">or</span>
                    <label class="checkbox-control control-radio mb-2">DOE
                        <input type="radio" v-model="job.pay_type_id" value="4"/>
                        <div class="control-indicator"></div>
                    </label>
                    <label class="checkbox-control control-radio mb-2">TBD
                        <input type="radio" v-model="job.pay_type_id" value="5"/>
                        <div class="control-indicator"></div>
                    </label>
                    <label class="checkbox-control control-radio mb-2">Unpaid / Volunteer
                        <input type="radio" v-model="job.pay_type_id" value="6"/>
                        <div class="control-indicator"></div>
                    </label>

            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Dates needed</span>
            </div>
            <div class="md:w-2/3">
                <input v-model="job.dates_needed" type="text" class="form-control bg-light w-full" placeholder="Production dates" />
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Production notes</span>
            </div>
            <div class="md:w-2/3">
                <textarea v-model="job.notes" class="w-full form-control h-24" placeholder="Production notes"></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header mt-2 text-blue-dark block md:text-right mb-3">Pay travel expensenses?</span>
            </div>
            <div class="md:w-2/3 flex items-center">
                <label class="switch">
                    <input v-model="job.travel_expenses_paid" type="checkbox">
                    <span class="form-slider"></span>
                </label> <span class="ml-2 text-grey">Travel expensenses for out-of-area crew</span>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Rush call?</span>
            </div>
            <div class="md:w-2/3 flex items-center">
                <label class="switch">
                    <input v-model="job.rush_call" type="checkbox">
                    <span class="form-slider"></span>
                </label><span class="ml-2 text-grey">Interviews or work needed in the next 2-3 days</span>
            </div>
        </div>

        <div class="py-6">
            <div class="md:flex">
                <div class="md:w-1/3 pr-8">
                    <span class="font-bold font-header text-blue-dark mt-1 block md:text-right mb-3">General resume</span>
                </div>
                <div class="md:w-2/3">
                    <a href="#" class="btn-outline inline-block">Upload file</a>
                </div>
            </div>
        </div>
        
        <div class="border-t-2 border-grey-lighter py-6">
            <div class="md:flex">
                <div class="md:w-1/3 pr-8">
                    <span class="font-bold font-header text-blue-dark mt-2 block md:text-right">Gear</span>
                </div>
                <div class="md:w-2/3">
                    <div class="pb-4">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="form-slider"></span>
                        </label>
                    </div>
                    <label for="" class="block mb-3">What gear do you have for this position?</label>
                    <textarea class="form-control w-full h-32" placeholder="Your gear"></textarea>
                </div>
            </div>
        </div>

        <error-notification :errors="errors"></error-notification>

        <div class="flex justify-center mt-4">
            <button class="flex-grow btn-green" @click="addPosition(position.id)">Add Position</button>
        </div>

    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ErrorNotification from './ErrorNotification.vue'
import InputNumberType from '../_partials/InputNumberType'

export default {
    props: {
        position: {
            type: Object,
            required: true
        },

        project: {
            type: Object,
            required: true
        },
    },

    components: {
        'error-notification': ErrorNotification,
        'person-needed-input': InputNumberType
    },

    data() {
        return {
            errors:[],
            isAdded: false
        }
    },

    computed: {
        ...mapGetters({
            job: 'project/job',
            selectedPosition: 'crew/selectedPosition'
        })
    },

    methods: {
        addPosition(id){
            if (! this.hasErrors()){
                if (typeof(this.project.jobs) != 'undefined'){
                    // Check if the positiion data is already added and get the index  
                    let i = this.project.jobs.findIndex(o => o.position_id == id)

                    if (i !== -1){
                        // Update the value if it was already added
                        this.project.jobs[i] = this.job
                    } 
                }

                // Add to the array if it was not added
                this.project.jobs.push(this.job)
                this.$store.commit('project/JOB', {
                    persons_needed: 1
                })

                // State resets
                this.errors = []
                this.isAdded = true
            }
        },

        hasErrors(){
            this.errors = []

            if(! this.job.gear_provided) {
                this.errors.push('Equipment Provided is required')
            }

            if(! this.job.gear_needed) {
                this.errors.push('Equipment Needed is required')
            }

            if (! this.job.pay_rate){
                this.errors.push('Pay Rate is required')
            }

            if (! this.job.pay_type_id){
                this.errors.push('Pay Type option is required')
            }

            if (! this.job.dates_needed){
                this.errors.push('Dates Needed is required')
            }

            if (! this.job.notes){
                this.errors.push('Position Notes is required')
            }

            if(this.errors.length > 0) {
                return true
            }

            return false
        },
    }
}
</script>

<style>
.collapsed {
    display: none;
}
</style>

