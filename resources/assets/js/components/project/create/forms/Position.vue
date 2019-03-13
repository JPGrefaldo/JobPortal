<template>
    <div v-if="positions">
        <div v-for="item in positions" :key="item.id">
            <label class="text-x1" :class="highlight[item.id]">
                <input class="mb-2" type="checkbox" v-model="needed['selected' + item.id]" :value="item.id" @click="selected($event)">
                {{ item.name }}
            </label>
            <div class="rounded shadow-lg mb-3 p-5" v-if="needed['selected' + item.id]">
                <div class="w-ful lg:flex">
                    <div class="lg:h-auto flex flex-col w-1/2">
                        <p>Position notes:</p>
                        <textarea v-model="project_job.notes" rows=13 class="shadow appearance-none border rounded w-full"></textarea>
                    </div>
                    <div class="flex flex-col justify-between leading-normal pl-6">
                        <p>Pay rate:</p>
                         <input v-model="project_job.pay_rate" type="text" @input="addPayRate" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">
                           
                        <div v-if="hasPayRate">
                            <input v-model="project_job.pay_type_id" type="radio" value="1"> Hourly
                            <input v-model="project_job.pay_type_id" type="radio" value="2" > Daily
                            <input v-model="project_job.pay_type_id" type="radio" value="3"> Half day
                            <p>- or -</p>
                            <input v-model="project_job.pay_type_id" type="radio" value="4"> DOE
                            <input v-model="project_job.pay_type_id" type="radio" value="5"> TBD
                            <input v-model="project_job.pay_type_id" type="radio" value="6"> Unpaid/Volunteer
                        </div>
                        <p>Production dates/dates needeed:</p>
                        
                        <input v-model="project_job.dates_needed" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline mb-2">
                        <div>
                            <input v-model="project_job.rush_call" type="checkbox"> Rush Call? (interviews or works in the next 2-3 days?)
                        </div>
                    </div>
                </div>
                <div v-if="errors.length > 0" class="bg-red-lightest border border-red-light text-red-dark px-4 py-3 rounded relative" role="alert">
                    <strong class="block font-bold">Holy smokes!</strong>
                    <ul>
                        <li class="text-red-dark" v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                    <span class="absolute pin-t pin-b pin-r px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div> 
                <div class="flex justify-center mt-4">
                    <button class="flex-grow bg-blue hover:bg-blue-dark text-white font-bold w-24 py-2 px-4 rounded-full" @click.stop="addPosition(item.id)">Add Position</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        data() {
            return {
                errors: [],
                hasPayRate: false,
                highlight: [],
                needed: [], 
                project_job: {
                    pay_type_id: ''
                },
                currentID: 0
            }
        },

        mounted(){
            this.$store.dispatch('crew/fetchPositions')
        },

        computed:{
            ...mapGetters({
                position: 'crew/position',
                positions: 'crew/positions',
                project: 'project/project',
            })
        },

        methods: {
            selected(e){
                this.hideOpenedPositionCard()

                let job = this.project.project_job.find(o => o.position_id == e.target.value)

                // Retain the text bold style of those checkboxes that already had a data entered
                if(typeof(job) == 'undefined'){
                    this.highlight[`${e.target.value}`] = ''
                }

                if (e.target.checked){
                    this.highlight[`${e.target.value}`] = 'font-bold '
                    this.currentID                      = e.target.value
                    this.project_job.position_id        = e.target.value

                    if (typeof(job) != 'undefined'){
                        this.setJobValues(job)
                        return
                    }

                    // Clear objects value so it won't be displayed on another checked item
                    this.clearJobValues(job)
                }
            },

            setJobValues(job){
                this.project_job.notes          = job.notes
                this.project_job.pay_rate       = job.pay_rate
                this.project_job.pay_type_id    = job.pay_type_id
                this.project_job.dates_needed   = job.dates_needed
                this.project_job.rush_call      = job.rush_call
            },

            clearJobValues(job){
                this.project_job.notes          = ''
                this.project_job.pay_rate       = ''
                this.project_job.pay_type_id    = ''
                this.project_job.dates_needed   = ''
                this.project_job.rush_call      = ''
            },

            addPosition(id){
                if (this.hasErrors()){
                    return
                }

                this.needed[`selected${id}`] = false

                // Check if the positiion data is already added and get the index  
                let i = this.project.project_job.findIndex(o => o.position_id == id)
               
                if (i == -1){
                    // Add to the array if it was not added
                    this.project.project_job.push(this.project_job)
                } else {
                    // Update the value if it was already added
                    this.project.project_job[i] = this.project_job
                }

                this.project_job = {}
            },

            hasErrors(){
                this.errors = []

                if (! this.project_job.notes){
                    this.errors.push('Position Notes should not be empty')
                }

                if (! this.project_job.pay_rate){
                    this.errors.push('Pay Rate should not be empty')
                }

                if (! this.project_job.pay_type_id){
                    this.errors.push('Pay Type should be selected')
                }

                if (! this.project_job.dates_needed){
                    this.errors.push('Dates Needed should not be empty')
                }

                if (this.errors.length > 0){
                    return true
                }

                return false
            },

            addPayRate(){
                if ( this.project_job.pay_rate 
                     && ! isNaN(this.project_job.pay_rate)
                     && this.project_job.pay_rate  != 0
                ){
                    this.hasPayRate = true
                }
            },

            hideOpenedPositionCard(e){
                // Fixed overlapping open position card when multiple checkboxes is selected
                this.needed[`selected${this.currentID}`] = false
            }
        }
    }
</script>