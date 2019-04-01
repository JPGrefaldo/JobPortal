export default {
    methods: {
        displaySuccess: function (response) {
            this.$swal({
                title: '',
                text: response.data.message,
                type: 'success',
            });
        },

        displayError: function (message) {
            this.$swal({
                title: '',
                text: message,
                type: 'error',
            });
        }
    }
}