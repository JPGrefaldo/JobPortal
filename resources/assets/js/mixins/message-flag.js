export default {
    methods: {
        onClickRequestFlag: function (message) {
            this.requestFlag(message);
        },

        async requestFlag (message) {
            const result = await this.displayRequestFlagForm();

            if (!result.value) {
                return
            }

            const response = await this.submitRequestFlagForm(message, result)

            this.displaySuccess(response);
        },

        displayRequestFlagForm: function () {
            return this.$swal({
                title: 'Report this message',
                text: 'Help us understand what\'s happening with this message.',
                input: 'textarea',
                inputPlaceholder: 'Enter reason',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Flag message'
            });
        },

        submitRequestFlagForm: function (message, result) {
            this.form.message_id = message.id;
            this.form.reason = result.value;

            const response = this.form.post('/pending-flag-messages')

            this.form.message_id = '';
            this.form.reason = '';

            return response;
        },
    }
}