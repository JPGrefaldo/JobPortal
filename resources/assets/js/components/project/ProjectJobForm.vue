<template>
    <div>
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
                <small class="block md:text-right text-red" v-show="errors.has('Equipment Provided')">{{ errors.first('Equipment Provided') }}</small>
            </div>
            <div class="md:w-2/3">
                <textarea 
                         class="w-full form-control h-24"
                         name="Equipment Provided"
                         placeholder="Equipment provided by production"
                         v-model="job.gear_provided" 
                         v-validate="'required'" 
                ></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Equipment needed</span>
                <small class="block md:text-right text-red" v-show="errors.has('Equipment Needed')">{{ errors.first('Equipment Needed') }}</small>
            </div>
            <div class="md:w-2/3">
                <textarea 
                         class="w-full form-control h-24" 
                         name="Equipment Needed"
                         placeholder="Equipment needed from operator/crew"
                         v-model="job.gear_needed" v-validate="'required'" 
                ></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Pay rate</span>
                 <small class="block md:text-right text-red" v-show="errors.has('Pay Rate')">{{ errors.first('Pay Rate') }}</small>
                 <small class="block md:text-right text-red" v-show="errors.has('Pay Rate Type')">{{ errors.first('Pay Rate Type') }}</small>
            </div>
            <div class="md:w-2/3">
                $ <input 
                        class="w-16 text-right form-control" 
                        name="Pay Rate"
                        placeholder="00"
                        ref="pay_rate"
                        type="text" 
                        v-model="job.pay_rate" 
                        v-validate="'required_if:pay_type_id,0'"
                        @input="resetPayType"
                >
                <select 
                    class="form-control w-32 text-grey-dark" 
                    name="Pay Rate Type"  
                    v-validate.immediate="'required_if:pay_rate'"
                    v-model="job.pay_rate_type_id"
                    @change="resetPayType" 
                >
                    <option value="1">Per hour</option>
                    <option value="2">Day</option>
                    <option value="3">Half Day</option>
                </select>
                <span class="my-2 block">or</span>
                <label class="checkbox-control control-radio mb-2">DOE
                    <input name="Pay Type" ref="pay_type_id" type="radio" v-model="job.pay_type_id" value="4" @input="resetPayRateType"/>
                    <div class="control-indicator"></div>
                </label>
                <label class="checkbox-control control-radio mb-2">TBD
                    <input name="Pay Type" ref="pay_type_id" type="radio" v-model="job.pay_type_id" value="5" @input="resetPayRateType"/>
                    <div class="control-indicator"></div>
                </label>
                <label class="checkbox-control control-radio mb-2">Unpaid / Volunteer
                    <input name="Pay Type" ref="pay_type_id" type="radio" v-model="job.pay_type_id" value="6" @input="resetPayRateType"/>
                    <div class="control-indicator"></div>
                </label>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3">Dates needed</span>
                <small class="block md:text-right text-red" v-show="errors.has('Production Dates')">{{ errors.first('Production Dates') }}</small>
            </div>
            <div class="md:w-2/3">
                <input 
                      class="form-control bg-light w-full"
                      name="Production Dates"
                      placeholder="Production dates"
                      type="text" 
                      v-model="job.dates_needed" 
                      v-validate="'required'"
                />
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3">Production notes</span>
                <small class="block md:text-right text-red" v-show="errors.has('Production Notes')">{{ errors.first('Production Notes') }}</small>
            </div>
            <div class="md:w-2/3">
                <textarea 
                         class="w-full form-control h-24"
                         name="Production Notes"
                         placeholder="Production notes"
                         v-model="job.notes" 
                         v-validate="'required'" 
                ></textarea>
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
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import InputNumberType from '../_partials/InputNumberType'

    export default {
        inject: ['$validator'],

        components: {
            'person-needed-input': InputNumberType
        },

        computed: {
            ...mapGetters({
                job: 'project/job'
            })
        },

        mounted(){
            var self = this
            if (self.job.pay_type_id < 4){
                self.job.pay_rate_type_id = self.job.pay_type_id
            }
        },

        methods: {
            resetPayRateType(){
                if (this.job.pay_rate) {
                    this.job.pay_rate = 0
                    this.job.pay_rate_type_id = ''
                }
            },

            resetPayType(){
                if (this.job.pay_rate || this.job.pay_rate_type_id) {
                    this.job.pay_type_id = ''
                }
            }
        }
    }
</script>}

