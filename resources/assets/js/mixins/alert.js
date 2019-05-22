export default {
    methods: {
        displaySuccess: function(response) {
            this.$swal({
                title: '',
                text: response.data.message,
                type: 'success',
            });
        },

        displayError: function(message) {
            this.$swal({
                title: '',
                text: message,
                type: 'error',
            });
        },

        displayDeleteNotification: function() {
            return this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            });
        },

        displayCustomMessage: function(title, message) {
            return this.$swal({
                title: title,
                text: message,
                type: 'success',
            })
        }
    },
};
