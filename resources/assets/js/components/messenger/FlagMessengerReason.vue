<template>
    <div class="w-3/5 bg-white flex flex-col p-4">
        <div v-if="reason !== ''">
            <strong>Flag ID: {{ flagId }}</strong>
            <p>{{ reason }}</p>
            <p><a class="py-6 px-4 tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" @click="onClickApproveFlag(flagId)">Approve</a>
            <a class="py-6 px-4 tracking-wide font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" @click="onClickDisapproveFlag(flagId)">Disapprove</a></p>
        </div>
        <div v-else>
            <p>Select an item</p>
        </div>
    </div>
</template>

<script>
import { alert } from '../../mixins';

export default {
    props: [
        'reason',
        'flagId'
    ],

    mixins: [alert],

    methods: {
        onClickApproveFlag: function() {
            axios.put(`/pending-flag-messages/${this.flagId}`, {
                'action': 'approve'
            }).then(response => {
                this.displaySuccess(response)
                this.$parent.$emit('refreshList')
            })
        },
        onClickDisapproveFlag: function() {
            axios.put(`/pending-flag-messages/${this.flagId}`, {
                'action': 'disapprove'
            }).then(response => {
                this.displaySuccess(response)
                this.$parent.$emit('refreshList')
            })
        }
    },
}
</script>
