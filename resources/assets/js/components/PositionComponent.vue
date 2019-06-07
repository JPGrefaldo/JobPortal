<template>
    <div>
        <div class="flex justify-between w-full items-center py-2" @click.stop.prevent="toggleSelect">
            <label class="checkbox-control">
                <h3 class="text-md text-grey-200 font-semibold sm-only:text-sm" v-text="position.name"></h3>
                <input type="checkbox" v-model="filled"/>
                <div class="control-indicator"></div>
            </label>
            <a href="#" class="text-grey no-underline">Edit</a>
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
                            <button v-if="resume" @click="removeResume(position.id)" class="btn-outline text-green inline-block cursor-pointer">Remove</button>
                            <div v-if="resume" class="w-full pt-2">
                                <div v-if="position_exist">
                                    <i class="fas fa-file-pdf text-grey"></i>
                                    <span>
                                        <a target="_blank" :href="resume.file_link" class="text-sm text-grey" v-if="resume.path">{{ basename(resume.path) }}</a>
                                    </span>
                                </div>
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
                            <button @click="removeReel(position.id)" class="btn-outline text-green inline-block">Remove</button>
                            <p class="text-sm text-grey mt-4">
                                {{ reel }}
                            </p>
                        </div>
                        <div v-else class="md:w-2/3">
                            <input
                                type="text"
                                class="form-control bg-light w-64 mr-2 mb-2 md:mb-0"
                                :class="{ 'input__error': form.errors.has('reel_link') }"
                                placeholder="Add link"
                                v-model="form.reel_link"
                            />
                            <has-error :form="form" field="reel_link"></has-error>
                            or
                            <label :for="'reel_file' + position.id" class="btn-outline text-white inline-block bg-green"
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
                            <label :for="'gear_photos' + position.id"
                            class="btn-outline text-white inline-block cursor-pointer bg-green md:mb-4">{{form.gear_photos ? "change" : "upload"}} file</label>
                            <input type="file" :id="'gear_photos' + position.id" @change="selectFile" name="gear_photos" class="hidden" />
                            <button v-if="form.gear_photos" @click="removeGearPhotos(position.id)" class="btn-outline text-green inline-block cursor-pointer">Remove</button>
                            <p class="text-sm text-grey" v-if="gear_photo">
                                {{ basename(gear_photo) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                <button class="text-grey bold mr-4 hover:text-green focus:outline-none" @click="onClickLeavePosition()">Leave position</button>
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
import { alert } from '../mixins';

     window.objectToFormData = objectToFormData

export default {
    name: 'PositionComponent',
    components: { 'has-error': InputErrors },
    props: {
        position: Object,
    },
    data() {
        return {
            error_messages       : null,
            has_gear      : false,
            selected      : false,
            filled        : false,
            position_exist: false,
            reel          : null,
            resume        : null,
            gear_photo    : null,
            form          : new Form({
                bio              : '',
                union_description: '',
                resume           : null,
                reel_link        : '',
                gear_photos      : null,
                reel_file        : null,
                gear             : '',
            }),
        };
    },

    mixins: [alert],

    computed: {
        ...mapGetters({
            crewPositionList: 'crew/crewPositionList',
            crewPositionData: 'crew/crewPositionData',
        })
    },

    methods: {
        toggleSelect: function() {
            this.selected = !this.selected;
            return false;
        },

        selectFile: function(e) {
            this.form[e.target.name] = e.target.files[0];
            e.target.value = '';
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

            if (typeof this.form.resume != "undefined") {
                formData.append('resume', this.form.resume);
            } else {
                formData.append('resume', null);
            }

            if (typeof this.form.gear_photos != "undefined") {
                formData.append('gear_photos', this.form.gear_photos);
            } else {
                formData.append('gear_photos', null);
            }

            formData.append('bio', this.form.bio);
            formData.append('union_description', this.form.union_description);
            formData.append('reel_link', this.form.reel_link);
            formData.append('gear', this.form.gear);
            formData.append('position', this.position.id);

            if (this.position_exist) {
                axios
                .post('/crew/positions/' + this.position.id, formData, config)
                .then(({ data }) => {
                    if (data.message === 'success') {
                        this.filled = true;
                        this.getPositionData();
                        this.displayCustomMessage(
                            'Success', 
                            'You have successfully updated ' + this.position.name + ' position'
                        );
                        this.error_messages = null;
                    }
                })
                .catch((error) => {
                    var arr = [].concat.apply([], [
                        error.response.data.errors.bio,
                        error.response.data.errors.union_description,
                        error.response.data.errors.resume,
                        error.response.data.errors.reel_link,
                        error.response.data.errors.gear_photos,
                        error.response.data.errors.reel_file,
                        error.response.data.errors.gear,
                    ]);

                    this.error_messages = arr.filter(function (e) {
                        if (e) {
                            return e;
                        }
                    });

                    this.displayError(this.error_messages);
                });
            } else {
                axios
                .post('/crew/positions/' + this.position.id, formData, config)
                .then(({ data }) => {
                    if (data.message === 'success') {
                        this.filled = true;
                        this.getPositionData();
                        this.displayCustomMessage(
                            'Success', 
                            'You have successfully applied to ' + this.position.name + ' position'
                        );
                        this.error_messages = null;
                    }
                })
                .catch((error) => {
                    var arr = [].concat.apply([], [
                        error.response.data.errors.bio,
                        error.response.data.errors.union_description,
                        error.response.data.errors.resume,
                        error.response.data.errors.reel_link,
                        error.response.data.errors.gear_photos,
                        error.response.data.errors.reel_file,
                        error.response.data.errors.gear,
                    ]);

                    this.error_messages = arr.filter(function (e) {
                        if (e) {
                            return e;
                        }
                    });

                    this.displayError(this.error_messages);
                });
            }
        },

        onClickLeavePosition: function() {
            this.leavePosition();
        },

        leavePosition: function() {
            axios
                .delete(`/crew/positions/${this.position.id}`)
                .then(({data}) => {
                    if(data == 'success'){
                        this.form.bio               = '';
                        this.form.union_description = '';
                        this.form.resume            = null;
                        this.form.reel_link         = '';
                        this.form.gear_photos       = null;
                        this.form.reel_file         = null;
                        this.form.gear              = '';

                        this.position_exist         = false;
                        this.filled                 = false;
                        this.selected               = false;

                        this.displayCustomMessage(
                            'Success', 
                            'You have successfully leaved ' + this.position.name + ' position'
                        );
                    }
            })
        },

        fillData: function(data) {
            this.form = new Form({
                id               : data.id,
                bio              : data.details,
                union_description: data.union_description ? data.union_description: '',
                reel_link        : data.reel ? data.reel.path                     : '',
                gear             : data.gear ? data.gear.description              : '',
            });

            this.reel       = data.reel ? data.reel.path : null;
            this.resume     = data.resume ? data.resume : null;
            this.gear_photo = data.gear ? data.gear.path : null;
        },

        getPositionData: function() {
            axios
                .get(`/crew/positions/${this.position.id}`)
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
                this.getPositionData();
            }
        },

        removeResume: function(positionId) {
            axios
                .delete(`/crew/positions/${positionId}/resume`)
                .then(data => {
                    if(data.data.message == 'success') {
                        this.getPositionData();
                        this.displayCustomMessage(
                            'Successfully removed', 
                            'You have successfully removed resume, please upload a new one'
                        );

                        this.form.resume = null
                        this.resume = null
                    }
            })
        },

        removeReel: function(positionId){
            axios
                .delete(`/crew/positions/${positionId}/reel`)
                .then(response => {
                    if(response.data.message == 'success'){
                        this.getPositionData();
                        this.displayCustomMessage(
                            'Successfully removed', 
                            'You have successfully removed your reel'
                        );

                        this.form.reel_file = null
                        this.form.reel = ''
                    }
                })
        },

        removeGearPhotos: function(positionId) {
            axios
                .delete(`/crew/positions/${positionId}/gear`)
                .then(response => {
                    if(response.data.message == 'success') {
                        this.getPositionData();
                        this.displayCustomMessage(
                            'Successfully removed',
                            'You have successfully removed the gear photos'
                        );
                    }

                    this.form.gear_photos = null
                })
        },

        basename: function(str) {
            if (str == '') {
                return;
            }

            return str.substr(str.lastIndexOf('/') + 1);
        }
    },
    mounted() {
        this.$store.dispatch('crew/checkPositionIfExist');
        setTimeout(() => this.checkPositionIfExist(), 2000);
    }
};
</script>
