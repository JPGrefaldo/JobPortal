export default {
    methods: {
        pay: function(payRate, payType) {
            return payRate == 0 || typeof(payRate) == 'undefined' ?  payType : `$${payRate}/${payType}`
        },

        dateForDatabase: function(date) {
            return date.toISOString().slice(0, 10);
        },

        dateForHumans: function(date) {
            return new Date(date).toDateString().slice(0, 16)
        },

        booleanForHumans: function(data) {
            return data ? 'YES' : 'NO'
        },

        showDates(date) {
            let dates = JSON.parse(date)

            if (dates.length === 2) {
                if (dates[0] === dates[1]) {
                    return this.dateForHumans(dates[0])
                }
                return `${this.dateForHumans(dates[0])} to ${this.dateForHumans(dates[1])}`
            }

            let dates_needed = '<ol>'
            for (var i=0; i < dates.length; i++) {
                dates_needed += '<li>'
                dates_needed += this.dateForHumans(dates[i])
                dates_needed += '</li>'
            }
            dates_needed += '</ol>'
            return dates_needed;
        }
    }
}