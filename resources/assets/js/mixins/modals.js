export default {
    methods: {
        modal: function (html) {
            this.$swal({
                width: '75%',
                showConfirmButton: false,
                html: html
            })
        },

        projectViewModal: function (project) {
            this.modal(`
            <div class="flex justify-between items-center">
                <h2 class="text-blue-dark font-semibold text-lg mb-1 font-header">${project.title}
                    <span class="badge">ROLES: ${project.jobs.length}</span>
                </h2>
                <div class="text-right">
                    <span class="h4 mb-2 text-yellow block text-xs">
                        Requested submissions</span>
                    <span class="h4 mb-2 text-grey block text-xs">
                        12 days left</span>
                </div>
            </div>
            <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4 text-left">
                <div class="md:w-1/2 px-2">
                    <div class="block text-sm text-blue-dark py-1">
                        <span class="font-semibold">PRODUCTION TITLE:</span> ${project.production_name}
                    </div>
                    <div class="block text-sm text-blue-dark py-1">
                        <span class="font-semibold">LOCATION: </span> ${project.location}
                    </div>
                </div>
                <div class="md:w-1/2 px-2">
                    <div class="block text-sm text-blue-dark py-1">
                        <span class="font-semibold">STATUS:</span> ${this.status(project.status)}
                    </div>
                    <div class="block text-sm text-blue-dark py-1">
                        <span class="font-semibold">CREATED:</span> ${this.dateForHumans(project.created_at)}
                    </div>
                </div>
            </div>
            <div class="md:flex py-6 text-left">
                <div class="w-full md:w-1/4">
                    <h4 class="text-grey mb-3 md:mb-0 mt-1">Project details</h4>
                </div>
                <div class="w-full md:w-3/4">
                    <p>${project.description}</p>
                </div>
            </div>
            `)
        },

        projectJobViewModal: function (job) {
            this.modal(`
            <div class="bg-white p-4 md:p-8 mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-blue-dark font-semibold text-lg mb-1 font-header">${job.position.name}</h2>
                    <div class="text-right">
                        <span class="h4 mb-2 text-yellow block text-xs">
                            Requested submissions</span>
                        <span class="h4 mb-2 text-grey block text-xs">
                            12 days left</span>
                    </div>
                </div>
                <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4 text-left">
                    <div class="md:w-1/2 px-2">
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">PAY:</span> ${this.pay(job.pay_rate, job.pay_type.name)}
                        </div>
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">PERSONS NEEDED:</span> ${job.persons_needed}
                        </div>
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">DATES NEEDED:</span> ${this.showDates(job.dates_needed)}
                        </div>
                    </div>
                    <div class="md:w-1/2 px-2">
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">RUSH CALL:</span> ${this.booleanForHumans(job.rush_call)}
                        </div>
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">CREATED:</span> ${this.dateForHumans(job.created_at)}
                        </div>
                        <div class="block text-sm text-blue-dark py-1">
                            <span class="font-semibold">PAID TRAVEL EXPENSES:</span> ${this.booleanForHumans(job.travel_expenses_paid)}
                        </div>
                    </div>
                </div>
                <div class="md:flex py-6">
                    <div class="w-full md:w-1/4">
                        <h4 class="text-grey mb-3 md:mb-0 mt-1">job details</h4>
                    </div>
                    <div class="w-full md:w-3/4 text-left">
                        <p>${job.notes}</p>
                    </div>
                </div>
            </div>
            `)
        }
    }
}