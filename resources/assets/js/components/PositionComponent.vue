<template>
    <div>
        <div>
            <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                <div class="py-2">
                    <div class="mb-2">
                        <textarea class="form-control w-full h-64" placeholder="Biography" v-model="bio"></textarea>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mb-2 md:mb-0">Resume</h3>
                        </div>
                        <div class="md:w-2/3">
                            <label for="resume" class="btn-outline text-green inline-block" >Upload file</label>
                            <input type="file"
                                   name="resume"
                                   class="invisible">
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Reel</h3>
                        </div>
                        <div class="md:w-2/3">
                            <input type="text" v-model="reel_link" class="form-control bg-light w-64 mr-2 mb-2 md:mb-0" placeholder="Add link"> or
                            <label for="resume" class="btn-outline text-green inline-block" >Upload file</label>
                            <input type="file"
                                   name="resume"
                                   class="invisible">
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Gear</h3>
                        </div>
                        <div class="md:w-2/3">
                            <div class="display">
                                <label class="label toggle">
                                    <input type="checkbox" class="toggle_input" />
                                    <div class="toggle-control"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                        </div>
                        <div class="md:w-2/3">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">What gear do you have for this position?</h3>
                            <br>
                            <div class="mb-2">
                                <textarea class="form-control w-full h-64" placeholder="Your gear" v-model="gear"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
            <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
            <a href="#" class="btn-green" @click="onClickSave">SAVE CHANGES</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PositionComponent"
    }
</script>

<style scoped>

</style>
