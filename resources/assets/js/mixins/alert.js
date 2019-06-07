export default {
    methods: {
        displaySuccess: function(response) {
            this.$swal({
                title: '',
                text: response.data.message,
                type: 'success',
            });
        },

        displayError: function(messages) {
            var err_message = '';

            if (typeof messages == "object") {
                messages.forEach(item => {
                    err_message = item + ' ' + err_message;
                });

                this.$swal({
                    title: '',
                    text: err_message,
                    type: 'error',
                });
            } else {
                this.$swal({
                    title: '',
                    text: messages,
                    type: 'error',
                });
            }
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
