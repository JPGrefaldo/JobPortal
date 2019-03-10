<template>
    <div v-if="positions">
        <div v-for="item in positions" :key="item.id">
            <label class="text-x1" :class="highlight[item.id]">
                <input class="mb-2" type="checkbox" v-model="position['needed' + item.id]" @click="selected($event)">
                {{ item.name }}
            </label>
            <div class="rounded shadow-lg mb-3 p-5" v-if="position['needed' + item.id]">
                <div class="w-ful lg:flex">
                    <div class="lg:h-auto flex flex-col w-1/2">
                        <p>Position notes:</p>
                        <textarea :v-model="position['notes' + item.id]" rows=13 class="shadow appearance-none border rounded w-full"></textarea>
                    </div>
                    <div class="flex flex-col justify-between leading-normal pl-6">
                        <p>Pay rate:</p>
                        <div>
                            <input :v-model="position['pay_rate' + item.id]" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">
                            <input :v-model="position['pay_type_id' + item.id]" type="radio" value="hourly"> Hourly
                            <input v-model="position['pay_type_id' + item.id]" type="radio" value="daily" > Daily
                            <input v-model="position['pay_type_id' + item.id]" type="radio" value="half_day"> Half day
                        </div>
                        <p>- or -</p>
                        <div>
                            <input v-model="position['pay_type_id' + item.id]"  type="radio"> DOE
                            <input v-model="position['pay_type_id' + item.id]"  type="radio"> TBD
                            <input v-model="position['pay_type_id' + item.id]"  type="radio"> Unpaid/Volunteer
                        </div>
                        <p>Production dates/dates needeed:</p>
                        
                        <input v-model="position['production_date_needed' + item.id]" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline mb-2">
                        <div>
                            <input v-model="position['rush_call' + item.id]" type="checkbox"> Rush Call? (interviews or works in the next 2-3 days?)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        props: ['position'],

        data() {
            return {
                highlight: [],
            }
        },

        mounted(){
            this.$store.dispatch('crew/fetchPositions')
        },

        computed:{
            ...mapGetters({
                positions: 'crew/positions'
            })
        },

        methods: {
            selected(e){
                this.highlight[`${e.target.value}`] = ''

                if (e.target.checked){
                    this.position[`needed${e.target.value}`] = true
                    this.highlight[`${e.target.value}`] = 'font-bold '
                }
            },
        }
    }
</script>