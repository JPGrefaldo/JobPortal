<template>
    <div>
        <div class="py-2">
            <label class="checkbox-control" @click.stop.prevent="toggleSelect">
                <h3 class="text-md" v-text="position.name"></h3>
                <input type="checkbox" v-model="filled"/>
                <div class="control-indicator"></div>
            </label>
        </div>
        <div v-if="selected">
            <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                <div class="py-2">
                    <div class="mb-2">
                        <textarea
                            class="form-control w-full h-64"
                            placeholder="Position Biography"
                            v-model="form.bio"
                            :class="{ 'input__error': form.errors.has('bio') }"
                        >
                        </textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>
                </div>
                <div class="py-2">
                    <div class="mb-2">
                        <input
                            type="text"
                            class="form-control w-full"
                            placeholder="Union Description"
                            v-model="form.union_description"
                        />
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mb-2 md:mb-0">Resume</h3>
                        </div>
                        <div class="md:w-2/3">
                            <label :for="'resume' + position.id" 
                                class="btn-outline text-white inline-block cursor-pointer bg-green">{{form.resume ? "change" : "upload"}} file</label>
                            <input type="file" :id="'resume' + position.id" @change="selectFile" name="resume" class="hidden"/> 
                            <button v-if="form.resume" @click="removeResume(form.id)" class="btn-outline text-green inline-block cursor-pointer">Remove</button>
                            <div v-if="form.resume" class="w-full pt-2">
                                <i class="fas fa-file-pdf"></i>
                                <span>
                                    <a target="_blank" :href="form.resume.file_link">Resume</a>
                                </span>
                            </div>
                            <has-error :form="form" field="resume"></has-error>
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Reel</h3>
                        </div>
                        <div v-if="reel" class="md:w-2/3">
                            <a :href="reel" target="_blank" class="btn-outline text-white inline-block bg-green">View File</a>
                            <button @click="removeReel(form.id)" class="btn-outline text-green inline-block">Remove</button>
                        </div>
                        <div v-if="! reel" class="md:w-2/3">
                            <input
                                type="text"
                                class="form-control bg-light w-64 mr-2 mb-2 md:mb-0"
                                :class="{ 'input__error': form.errors.has('reel_link') }"
                                placeholder="Add link"
                                v-model="form.reel_link"
                            />
                            <has-error :form="form" field="reel_link"></has-error>
                            or
                            <label :for="'reel_file' + position.id" class="btn-outline text-green inline-block"
                                :class="{ 'input__error': form.errors.has('reel_file') }"
                                >Upload file</label
                            >
                            <input type="file" :id="'reel_file' + position.id" @change="selectFile" name="reel_file" class="hidden" />
                            <has-error :form="form" field="reel_file"></has-error>
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
                                    <input
                                        type="checkbox"
                                        class="hidden"
                                        v-model="has_gear"
                                    />
                                    <span
                                            class="border rounded-full border-grey flex items-center cursor-pointer my-4 w-12"
                                            v-bind:class="[has_gear ? 'switch-on' : 'switch-off']"
                                    >
                                    <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow"></span>
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="md:flex" v-if="has_gear">
                        <div class="md:w-1/3 pr-8"></div>
                        <div class="md:w-2/3">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">
                                What gear do you have for this position?
                            </h3>
                            <br />
                            <div class="mb-2">
                                <textarea
                                    class="form-control w-full h-64"
                                    placeholder="Your gear"
                                    v-model="form.gear"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                <button class="text-grey bold mr-4 hover:text-green focus:outline-none" @click="selected = false">Cancel</button>
                <button class="btn-green focus:outline-none" @click="onClickSave">SAVE CHANGES</button>
            </div>
        </div>
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform';
import { mapGetters } from 'vuex';
import InputErrors from './_partials/InputErrors';
import objectToFormData from 'object-to-formdata';

     window.objectToFormData = objectToFormData

export default {
    name: 'PositionComponent',
    components: { 'has-error': InputErrors },
    props: {
        position: Object,
    },
    data() {
        return {
            has_gear      : false,
            selected      : false,
            filled        : false,
            positionData  : {},
            positionData  : [],
            position_exist: false,
            reel          : null,
            form          : new Form({
                bio              : '',
                union_description: '',
                resume           : null,
                reel_link        : '',
                reel_file        : null,
                gear             : '',
                position         : this.position.id,
            }),
        };
    },

    computed: {
        ...mapGetters({
            crewPositionList: 'crew/crewPositionList',
            crewPositionData: 'crew/crewPositionData',
        })
    },

    methods: {
        toggleSelect: function() {
            this.selected = !this.selected;
            this.filled   = !this.filled;
            return false;
        },

        selectFile: function(e) {
            this.form[e.target.name] = e.target.files[0]
            e.target.value = ''
        },

        onClickSave: function() {
            this.saveCrewPosition();
        },

        saveCrewPosition: function() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let formData = new FormData();
            
            formData.append('bio', this.form.bio);
            formData.append('union_description', this.form.union_description);
            formData.append('resume', this.form.resume);
            formData.append('reel_link', this.form.reel_link);
            formData.append('gear', this.form.gear);
            formData.append('position', this.form.position);

            if (this.position_exist) {
                axios
                .post('/crew/positions/' + this.position.id + '/update', formData, config)
                .then(({ data }) => {
                    if (data === 'success') {
                        this.filled = true;
                        this.getPositionData();
                    }
                });
            } else {
                axios
                .post('/crew/positions/' + this.position.id, formData, config)
                .then(({ data }) => {
                    if (data === 'success') {
                        this.filled = true;
                        this.getPositionData();
                    }
                });
            }
        },

        fillData: function(data) {   
            this.form = new Form({
                id               : data.id,
                bio              : data.details,
                union_description: data.union_description ? data.union_description: '',
                resume           : data.resume ? data.resume : null,
                reel             : data.reel ? data.reel : false,
                gear             : data.gear ? data.gear.description : '',
            });

            this.reel = data.reel ? data.reel.path : null;
        },

        getPositionData: function() {
            axios
                .get(`/crew/positions/${this.position.id}/show`)
                .then(response => {
                    this.filled = true
                    this.fillData(response.data)
                    if (response.data.gear != null) {
                        this.has_gear = true;
                    }
                })
        },

        checkPositionIfExist: function() {
            if (this.crewPositionList.includes(this.position.id)) {
                this.position_exist = true;
                this.selected       = true;
                this.getPositionData();
            }
        },

        removeResume: function(positionId){
            axios
                .delete(`/crew/positions/${positionId}/resume`)
                .then(({data}) => {
                    if(data == 'success'){
                        this.getPositionData();
                    }
            })

            this.form.resume = null
        },

        removeReel: function(positionId){
            axios
                .get(`/crew/positions/${positionId}/reel`)
                .then(({data}) => {
                    if(data == 'success'){
                        this.getPositionData();
                    }
                })

            this.form.reel_file = null
        }
    },
    mounted() {
        this.$store.dispatch('crew/checkPositionIfExist');
        setTimeout(() => this.checkPositionIfExist(), 1000);
    }
};
</script>
