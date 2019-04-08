<template>
    <div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3"
                    >Persons needed</span
                >
            </div>
            <div class="md:w-2/3">
                <person-needed-input v-model="form.persons_needed"></person-needed-input>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3"
                    >Equipment provided</span
                >
                <small
                    class="block md:text-right text-red"
                    v-show="errors.has('Equipment Provided')"
                    >{{ errors.first('Equipment Provided') }}</small
                >
            </div>
            <div class="md:w-2/3">
                <textarea
                    class="w-full form-control h-24"
                    name="Equipment Provided"
                    placeholder="Equipment provided by production"
                    v-model="form.gear_provided"
                    v-validate="'required|min:3'"
                ></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3"
                    >Equipment needed</span
                >
                <small
                    class="block md:text-right text-red"
                    v-show="errors.has('Equipment Needed')"
                    >{{ errors.first('Equipment Needed') }}</small
                >
            </div>
            <div class="md:w-2/3">
                <textarea
                    class="w-full form-control h-24"
                    name="Equipment Needed"
                    placeholder="Equipment needed from operator/crew"
                    v-model="form.gear_needed"
                    v-validate="'required|min:3'"
                ></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3"
                    >Pay rate</span
                >
                <small class="block md:text-right text-red" v-show="errors.has('Pay Rate')">{{
                    errors.first('Pay Rate')
                }}</small>
                <small class="block md:text-right text-red" v-show="errors.has('Pay Rate Type')">{{
                    errors.first('Pay Rate Type')
                }}</small>
            </div>
            <div class="md:w-2/3">
                $
                <input
                    class="w-16 text-right form-control"
                    name="Pay Rate"
                    placeholder="00"
                    ref="pay_rate"
                    type="text"
                    v-model="form.pay_rate"
                    v-validate="'required_if:pay_type_id,0'"
                    @input="resetPayType"
                />
                <select
                    class="form-control w-32 text-grey-dark"
                    name="Pay Rate Type"
                    v-validate.immediate="'required_if:pay_rate'"
                    v-model="form.pay_rate_type_id"
                    @change="resetPayType"
                >
                    <option value="1">Per hour</option>
                    <option value="2">Day</option>
                    <option value="3">Half Day</option>
                </select>
                <span class="my-2 block">or</span>
                <label class="checkbox-control control-radio mb-2">
                    DOE
                    <input
                        name="Pay Type"
                        ref="pay_type_id"
                        type="radio"
                        v-model="form.pay_type_id"
                        value="4"
                        @input="resetPayRateType"
                    />
                    <div class="control-indicator"></div>
                </label>
                <label class="checkbox-control control-radio mb-2">
                    TBD
                    <input
                        name="Pay Type"
                        ref="pay_type_id"
                        type="radio"
                        v-model="form.pay_type_id"
                        value="5"
                        @input="resetPayRateType"
                    />
                    <div class="control-indicator"></div>
                </label>
                <label class="checkbox-control control-radio mb-2">
                    Unpaid / Volunteer
                    <input
                        name="Pay Type"
                        ref="pay_type_id"
                        type="radio"
                        v-model="form.pay_type_id"
                        value="6"
                        @input="resetPayRateType"
                    />
                    <div class="control-indicator"></div>
                </label>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3"
                    >Dates needed</span
                >
                <small
                    class="block md:text-right text-red"
                    v-show="errors.has('Production Dates')"
                    >{{ errors.first('Production Dates') }}</small
                >
            </div>
            <div class="md:w-2/3">
                <label class="checkbox-control control-radio mb-2">
                    Single/Range Date
                    <input
                            type="radio"
                            v-model="calendarType"
                            value="1"
                            @click="defaultDateValue(1)"
                    />
                    <div class="control-indicator"></div>
                </label>
                <label class="checkbox-control control-radio mb-2">
                    Multiple Dates
                    <input
                            type="radio"
                            v-model="calendarType"
                            value="2"
                            @click="defaultDateValue(2)"
                    />
                    <div class="control-indicator"></div>
                </label>
                <div v-if="calendarType == '1'">
                    <Calendar
                            v-model="datepicker.value"
                            :lang="datepicker.lang"
                            :position="datepicker.position"
                            :range="true"
                    />
                </div>
                <div v-if="calendarType == '2'" class="flex mb-4 items-center">
                    <span class="mt-4 mb-3">
                        <Calendar
                                v-model="datepicker.value"
                                :lang="datepicker.lang"
                                :position="datepicker.position"
                        />
                    </span>
                    <button
                            class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded bg-blue hover:bg-blue-dark text-white"
                            @click="addDate"
                    >
                        Add
                    </button>

                    <span class="my-2 block"></span>
                    <ol v-if="multipleShootingDates.length > 0">
                        <li v-for="date in multipleShootingDates">{{ date }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-4 block md:text-right mb-3"
                    >Production notes</span
                >
                <small
                    class="block md:text-right text-red"
                    v-show="errors.has('Production Notes')"
                    >{{ errors.first('Production Notes') }}</small
                >
            </div>
            <div class="md:w-2/3">
                <textarea
                    class="w-full form-control h-24"
                    name="Production Notes"
                    placeholder="Production notes"
                    v-model="form.notes"
                    v-validate="'required|min:3'"
                ></textarea>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header mt-2 text-blue-dark block md:text-right mb-3"
                    >Pay travel expensenses?</span
                >
            </div>
            <div class="md:w-2/3 flex items-center">
                <label class="switch">
                    <input v-model="form.travel_expenses_paid" type="checkbox" />
                    <span class="form-slider"></span>
                </label>
                <span class="ml-2 text-grey">Travel expensenses for out-of-area crew</span>
            </div>
        </div>
        <div class="md:flex py-2">
            <div class="md:w-1/3 pr-8">
                <span class="font-bold font-header text-blue-dark mt-2 block md:text-right mb-3"
                    >Rush call?</span
                >
            </div>
            <div class="md:w-2/3 flex items-center">
                <label class="switch">
                    <input v-model="form.rush_call" type="checkbox" />
                    <span class="form-slider"></span>
                </label>
                <span class="ml-2 text-grey">Interviews or work needed in the next 2-3 days</span>
            </div>
        </div>

        <div class="flex justify-center mt-4">
            <button class="flex-grow btn-green" @click.stop="submit">Add Position</button>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import InputNumberType from '../_partials/InputNumberType';
import Calendar from 'vue-datepicker-ui';

export default {
    inject: ['$validator'],

    props: ['submitProjectJob', 'mode'],

    components: {
        'person-needed-input': InputNumberType,
        Calendar,
    },

    data() {
        return {
            calendarType: '1',

            form: {
                persons_needed: 1,
                gear_provided: '',
                gear_needed: '',
                pay_rate: null,
                pay_rate_type_id: null,
                pay_type_id: null,
                notes: '',
                travel_expenses_paid: 0,
                rush_call: 0,
            },

            datepicker: {
                lang: 'en',
                position: 'bottom'
            },

            multipleShootingDates: [],
        };
    },

    computed: {
        ...mapGetters({
            job: 'project/job',
        }),
    },

    created() {
        var self = this;

        if (self.mode === 'edit') {
            self.form = self.job;
        }

        if (self.job.pay_type_id < 4) {
            self.form.pay_rate_type_id = self.job.pay_type_id;
        }

        let dates = this.dbDateValue(self.job.dates_needed);

        if (dates.length > 2) {
            self.calendarType = '2';
            self.multipleShootingDates = dates;
        }else {
            self.datepicker.value = dates;
        }
    },

    methods: {
        addDate() {
            this.multipleShootingDates.push(this.singleDate(this.datepicker.value));
        },

        dbDateValue(dbDates) {
            if (typeof dbDates != 'undefined') {
                return JSON.parse(dbDates)
            }

            return this.rangeDates();
        },

        defaultDateValue(type) {
            this.resetDates();

            if (type === 1) {
                this.datepicker.value = this.dbDateValue(this.job.dates_needed);
            }

            if (type === 2) {
                this.datepicker.value = new Date();
            }
        },

        singleDate(date) {
            return this.sqlDateFormat(date);
        },

        rangeDates() {
            return [
                this.sqlDateFormat(new Date()),
                this.sqlDateFormat(new Date())
            ];
        },

        resetDates() {
            this.datepicker.value = [];
            this.multipleShootingDates = [];
        },

        resetPayRateType() {
            if (this.form.pay_rate) {
                this.form.pay_rate = 0;
                this.form.pay_rate_type_id = '';
            }
        },

        resetPayType() {
            if (this.form.pay_rate || this.form.pay_rate_type_id) {
                this.form.pay_type_id = '';
            }
        },

        setDateNeededValue() {
            if (this.multipleShootingDates.length > 0) {
                return JSON.stringify(this.multipleShootingDates);
            }
            return JSON.stringify(this.datepicker.value);
        },

        submit() {
            this.form.pay_type_id = this.form.pay_rate_type_id || this.form.pay_type_id;
            this.form.dates_needed = this.setDateNeededValue();

            this.$store.commit('project/JOB', this.form);
            this.submitProjectJob();
        },

        sqlDateFormat(date) {
            return date.toISOString().slice(0, 10);
        }
    },
};
</script>

<style scoped>
.v-calendar .calendar .days .day {
    padding: 2px !important;
}
</style>
