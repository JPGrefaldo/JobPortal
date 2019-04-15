export default {
    methods: {
        pay: function(payRate, payType) {
            return payRate == 0 || typeof(payRate) == 'undefined' ?  payType : `$${payRate}/${payType}`
        },

        sqlDate: function(date) {
            return date.toISOString().slice(0, 10);
        },

        forHumansDate: function(date) {
            return new Date(date).toDateString().slice(0, 16)
        }
    }
}