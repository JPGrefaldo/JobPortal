<template>
    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <project-side-nav :projects="projects"></project-side-nav>

            <!-- Content Section
            ******************************************-->
            <div class="md:w-3/4 float-left">
                <div class="pb-4 md:pb-8">
                    <a href="/producer/projects" class="h4 text-grey">
                        <span class="btn-arrow-back mr-2 inline-block"></span>
                        Back to project list
                    </a>
                </div>

                <project-job-info class="bg-white mt-4 rounded p-4 md:p-8 shadow" :job="job" :project="project"></project-job-info>

                <!-- Submissions Section
                ******************************************-->
                <div class="py-6 md:flex justify-between">
                    <h3 class="text-md mb-3">Submissions
                        <span class="badge bg-white">5</span>
                    </h3>
                    <div class="block">
                        <a href="#" class="btn-outline inline-block mr-2 mb-1 md:mb-0">export "yes" selections</a>
                        <a href="#" class="btn-outline inline-block bg-green text-white">CONTACT ALL “YES” SELECTIONS</a>
                    </div>
                </div>

                <div class="md:hidden w-full md:w-1/4 float-left md:mb-3">
                    <div class="has-menu relative">
                        <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
                            <div>Unseen
                                <span class="badge">5</span>
                            </div>
                            <span class="btn-toggle float-right"></span>
                        </div>
                        <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                            <ul class="list-reset text-left">
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">View profile</a>
                                </li>
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">Subscription</a>
                                </li>
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">Settings</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="hidden md:block list-reset font-header text-right px-md py-6">
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Subscription</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Password</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 border-b-2 border-red hover:text-green">Add manager</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Notification setttings</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Close account</a>
                        </li>
                    </ul>
                </div>

                <div class="hidden md:flex justify-between border-b-2 border-grey-light">
                    <div>
                        <ul class="list-reset flex items-center">
                            <li class="mr-4">
                                <a class="border-b-2 border-red block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                                    href="#">unseen
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li>
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">seen
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="list-reset flex items-center">
                            <li class="mr-4">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"Yes"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li class="mr-4">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"no"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li>
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"maybe"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- Cards Section
                ******************************************-->
                <div class="w-full float-left py-6 md:py-lg grid-cards">
                    <div v-for="submission in submissions" :key="submission.id">
                        <div class="bg-white rounded border-grey-lighter shadow-md w-full flex flex-col justify-between" 
                             :class="{'overlay': isRejected(submission)}">
                             
                            <div class="p-6 relative">
                                <span class="text-yellow h4 mb-2 w-full absolute text-xs pin-top-left">
                                    <i class="fas fa-star mr-1"></i>
                                    requested submission
                                </span>

                                <a href="#" class="absolute pin-top-right text-red" v-if="isRejected(submission)" @click.stop="restore(submission.id)">
                                    <i class="fa fa-times-circle"></i>
                                </a>

                                <a href="#" class="absolute pin-top-right text-color-green" v-if="isApproved(submission)">
                                    <i class="fa fa-check-square"></i>
                                </a>

                                <a href="#" class="btn-more absolute pin-top-right" v-if="! isRejected(submission) && ! isApproved(submission)"></a>

                                <div class="rounded-full w-48 h-48 m-auto mt-3" style="background: url(/images/thumb.jpg) no-repeat center; background-size: cover"></div>

                                <div class="py-2 w-full float-left -mt-6">
                                    <ul class="list-reset text-center flex justify-center">
                                        <li class="w-8 h-8 bg-yellow-imdb rounded-full responsive p-1 inline-block -mr-2">
                                            <a href="#">
                                                <img src="/images/imdb.svg" alt="imdb">
                                            </a>
                                        </li>
                                        <li class="w-8 h-8 bg-blue-linkedin rounded-full responsive p-1 items-center justify-center inline-block">
                                            <a href="#" class="block">
                                                <i class="fab fa-linkedin-in text-white"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="text-center">
                                    <div class="pb-4">
                                        <h3 class="mb-1">{{ submission.crew.user.first_name }} {{ submission.crew.user.last_name }}</h3>
                                        <span class="text-grey">{{ job.position.name }}</span>
                                    </div>
                                    <p class="text-sm">{{ submission.crew.details }}</p>
                                    <a href="#" class="h4 my-4 block">view full profile</a>
                                </div>

                                <div class="border-t border-grey-light pt-3 mt-6 block">
                                    <ul class="list-reset">
                                        <li class="my-2">
                                            <a href="#" class="flex items-center">
                                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                                    <img src="images/play.svg" alt="" class="pos-center" />
                                                </div> Professional Work Reel</a>
                                        </li>
                                        <li class="my-2">
                                            <a href="#" class="flex items-center">
                                                <div class="relative w-6 h-6 bg-green rounded-full mr-2">
                                                    <i class="far fa-file-alt text-white pos-center"></i>
                                                </div> Professional Resume</a>
                                        </li>
                                        <li class="my-2" v-if="submission.crew.submission_count > 1">
                                            <label class="flex text-center text-grey">
                                                {{ submission.crew.submission_count }} positions applied on this project 
                                            </label>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                            <div :class="{'bg-grey-lighter ': !isRejected(submission)}" class="rounded-b px-6 py-3">
                                <div class="border border-grey-light overflow-hidden rounded-full flex bg-white justify-center text-center">
                                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey" @click.stop="approve(submission.id)">
                                        yes
                                    </div>
                                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 border-r border-grey-light border-l h4 text-grey">
                                        maybe
                                    </div>
                                    <div class="w-1/3 cursor-pointer text-xs px-4 py-3 h4 text-grey" @click.stop="reject(submission.id)">
                                        no
                                    </div>
                                </div>
                                <div v-if="isRejected(submission)" class="justify-center text-center">
                                    <a href="#" class="w-full px-4 py-3 h4 text-white" @click.stop="swap(job.id, submission)">
                                        <i class="fa fa-exchange-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
</template>

<script>
    import { mapGetters } from 'vuex'
    import TheProjectSideNav from '../TheProjectSideNav.vue'
    import TheProjectJobInfoCard from '../project/TheProjectJobInfoCard.vue'

    export default {
        props: ['job', 'project', 'submissions'],

        components: {
            'project-side-nav': TheProjectSideNav,
            'project-job-info' : TheProjectJobInfoCard
        },

        created: function() {
            this.$store.dispatch('submission/fetchAllApproved', this.job.id)
            this.$store.dispatch('project/fetch')
            this.$store.dispatch('project/fetchAllApprovedCount')
            // this.$store.dispatch('project/fetchAllPendingCount')
        },

        computed: {
            ...mapGetters({
                'projects': 'project/list',
                'approvedSubmissions': 'submission/approvedSubmissions',
            })
        },

        methods: {
            approve: function(id) {
                this.$store.dispatch('submission/approve', id)
                    .then(() => location.reload())
            },

            reject: function(id) {
                this.$store.dispatch('submission/reject', id)
                    .then(() => location.reload())
            },

            restore: function(id) {
                this.$store.dispatch('submission/restore', id)
                    .then(() => location.reload())
            },

            swap: function(job, submissionToApprove) {
                var content = '<div>'
                for (const submission of this.approvedSubmissions) {
                    content +=`
                        <input id="submission-to-reject" type="radio" value="${submission.id}" />
                        <label>
                            ${submission.crew.user.first_name} ${submission.crew.user.last_name}
                        </label>
                    `
                }
                content += '</div>'

                this.$swal({
                    title: `Swap ${submissionToApprove.crew.user.first_name} ${submissionToApprove.crew.user.last_name} with`,
                    html: content,
                    showCloseButton: true,
                    confirmButtonText: '<i class="fa fa-exchange-alt"></i>',
                })
                .then(result => {
                    if (result.value) {
                        const content = this.$swal.getContent()
                        const $ = content.querySelector.bind(content)
                        const submissionToReject = $('input[id=submission-to-reject]:checked').value

                        const submissions = {toReject: parseInt(submissionToReject, 10), toApprove: submissionToApprove.id}
                        this.$store.dispatch('submission/swap', submissions)

                        location.reload()
                    }
                })
            },
            
            isApproved: function(submission) {
                 return submission.approved_at !== null
            },

            isRejected: function(submission) {
                 return submission.rejected_at !== null
            }
        }
    }
</script>

<style scoped>
.overlay {
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(128,128,128,0.5);
}
</style>
