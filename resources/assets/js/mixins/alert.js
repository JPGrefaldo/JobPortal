export default {
    methods: {
        displaySuccess: function (response) {
            this.$swal({
                title: '',
                text: response.data.message,
                type: 'success',
            });
        }
    }
}