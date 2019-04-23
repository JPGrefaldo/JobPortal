<template>
    <div>
        <div class="flex flex-col h-full">
            <!-- top bar -->
            <div class="flex h-12 bg-grey-light">
                <div class="w-2/5 border-b border-r border-black flex items-center justify-center px-2">
                    Flag Messages
                </div>
                <div class="w-3/5 text-md border-black border-b font-bold flex justify-center items-center">
                    Reason
                </div>
            </div>
            <!-- main -->
            <div class="flex h-full">
                <!-- left pane -->
                <div class="flex w-2/5 border-r border-black">
                    <cca-flag-messages />
                </div>
                <cca-flag-reason />
            </div>
        </div>
    </div>
</template>

<script>
import FlagMessengerDashboardList from './FlagMessengerDashboardList.vue'
import FlagMessengerReason from './FlagMessengerReason.vue'

export default {
    name: "flag-messages",

    components: {
        'cca-flag-messages': FlagMessengerDashboardList,
        'cca-flag-reason': FlagMessengerReason
    }
}
</script>
