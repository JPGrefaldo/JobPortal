<template>
    <div v-if="positions">
        <div v-for="item in positions" :key="item.id">
            <div class="p-2 border-t-2 border-grey-lighter bg-grey-lighter">
                <div class="py-2">
                    <div class="md:flex">
                        <div class="w-full pb-4">
                            <label class="checkbox-control">
                                <h3 class="text-md">{{ item.name }}</h3>
                                <input type="checkbox" v-model="needed['selected' + item.id]" :value="item.id" @change="selected(item.id)"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div v-show="needed['selected' + item.id]">
                    <div class="md:flex py-2">
                        <div class="md:w-1/3 pr-8">
                            <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Persons needed</span>
                        </div>
                        <div class="md:w-2/3">
                            <div class="w-24">
                                <div class="flex justify-center border border-grey-light rounded">
                                    <button class="w-8 h-10" @click="preventNegativeValue(job.persons_needed--)">–</button>
                                    <input v-model="job.persons_needed" type="text" class="bg-light text-center w-8 h-10" value="1">
                                    <button class="w-8 h-10" @click="job.persons_needed++">+</button>
                                </div>
                            </div>
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
                    <div class="py-6">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <span class="font-bold font-header text-blue-dark block md:text-right mb-3">Post add on these websites:</span>
                            </div>
                            <div class="md:w-2/3 text-blue-dark">
                                <label class="checkbox-control mb-6">Check all
                                    <input type="checkbox" v-model="job.sites" value="all" @click="allSitesSelected"/>
                                    <div class="control-indicator"></div>
                                </label>

                                <div v-show="isAllSitesNotChecked">
                                    <label v-for="site in sites" :key="site.id" class="checkbox-control mb-2">
                                        {{ site.name }}
                                        <input v-model="job.sites" :value="site.id" type="checkbox">
                                        <div class="control-indicator"></div>
                                    </label>
                                </div>

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
                        <button class="flex-grow btn-green" @click.stop="addPosition(item.id)">Add Position</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { alert } from '../../../../mixins'
    import { mapGetters } from 'vuex'
    import ErrorNotification from './ErrorNotification.vue'

    export default {
        mixins: [ 
            alert 
        ],
        
        components: {
            'error-notification': ErrorNotification
        },

        data() {
            return {
                isAllSitesNotChecked: true,
                errors: [],
                needed: [], 
                job: {
                    pay_type_id: '',
                    persons_needed: 1,
                    sites: []
                },
                lastPositionId: 0
            }
        },

        mounted(){
            this.$store.dispatch('crew/fetchPositions')
            this.$store.dispatch('crew/fetchSites')
        },

        computed:{
            ...mapGetters({
                position: 'crew/position',
                positions: 'crew/positions',
                project: 'project/project',
                sites: 'crew/sites',
            })
        },

        methods: {
            selected(id){
                this.hideOpenedPositionCard(id)

                let job = this.project.jobs.find(o => o.position_id == id)

                // Store the id globally to be used in hiding the the job fields 
                this.lastPositionId     = id
                this.job.position_id    = id

                if (typeof(job) != 'undefined'){
                    this.setJobValues(job)
                    return
                }

                // Clear objects value so it won't be displayed on another checked item
                this.clearJobValues()
            },

            setJobValues(job){
                this.job.dates_needed          = job.dates_needed
                this.job.gear_needed           = job.gear_needed
                this.job.gear_provided         = job.gear_provided
                this.job.notes                 = job.notes
                this.job.pay_rate              = job.pay_rate
                this.job.pay_type_id           = job.pay_type_id
                this.job.persons_needed        = job.persons_needed
                this.job.rush_call             = job.rush_call
                this.job.travel_expenses_paid  = job.travel_expenses_paid
                this.job.sites                 = job.sites
            },

            clearJobValues(){
                this.job.dates_needed          = ''
                this.job.gear_needed           = ''
                this.job.gear_provided         = ''
                this.job.notes                 = ''
                this.job.pay_rate              = ''
                this.job.pay_type_id           = ''
                this.job.persons_needed        = 1
                this.job.rush_call             = ''
                this.job.travel_expenses_paid  = ''
                this.job.sites                 = []
            },

            addPosition(id){
                if (! this.hasErrors()){
                    // Check if the positiion data is already added and get the index  
                    let i = this.project.jobs.findIndex(o => o.position_id == id)
                
                    if (i == -1){
                        // Add to the array if it was not added
                        this.project.jobs.push(this.job)
                    } else {
                        // Update the value if it was already added
                        this.project.jobs[i] = this.job
                    }

                    this.job = {
                        pay_type_id: '',
                        persons_needed: 1,
                        sites: []
                    }
 
                    // State resets
                    this.errors = []
                    this.isAllSitesNotChecked = true
                    this.needed[`selected${id}`] = false
                }
            },

            allSitesSelected(){
                this.job.sites = []
                
                if(this.isAllSitesNotChecked){
                    this.isAllSitesNotChecked = false
                    return
                }
                this.isAllSitesNotChecked = true
            },

            preventNegativeValue(val){
                return (val == 1) ? this.job.persons_needed = 1 : this.job.persons_needed
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

                if(this.job.sites.length == 0) {
                    this.errors.push('Post add on these websites is required')
                }

                if(this.errors.length > 0) {
                    return true
                }

                return false
            },

            hideOpenedPositionCard(id){
                // Fixed overlapping open position card when multiple checkboxes is selected
                if (this.lastPositionId != 0){
                    this.needed[`selected${this.lastPositionId}`] = false
                }
            }
        }
    }
</script>