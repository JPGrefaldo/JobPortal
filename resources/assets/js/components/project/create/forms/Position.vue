<template>
    <div v-if="positions">
        <div v-for="position in positions" :key="position.id">
            <div>
                <input type="checkbox" v-model="checked">
                {{ position.name }}
            </div>
            <div v-if="checked">
                Pay rate:
                <div>
                    <input type="text" name="pay_rate">
                    <input type="radio" value="hourly" name="pay_type_id"> Hourly
                    <input type="radio" value="daily" name="pay_type_id"> Daily
                    <input type="radio" value="half_day" name="pay_type_id"> Half day
                </div>
                - or -
                <div>
                    <input type="radio" name="pay_type_id"> DOE
                    <input type="radio" name="pay_type_id"> TBD
                    <input type="radio" name="pay_type_id"> Unpaid/Volunteer
                </div>
                Production dates/dates needeed:
                <!-- this should be some date picker that will return a string -->
                <input type="text">
                Position notes:
                <textarea name="notes" id=""></textarea>
                <div>
                    <input type="checkbox" name="rush_call"> Rush Call? (interviews or works in the next 2-3 days?)
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                checked: false,
                positions: null
            }
        }
    }
</script>