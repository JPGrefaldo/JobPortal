<template>
    <div id="app">  
        <file-pond class="w-full md:w-2/5" name="photo" ref="photo" label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
            allow-multiple="true" accepted-file-types="image/jpeg, image/png" imagePreviewHeight="200" imagePreviewWidth="200" allowImageResize="true" imageResizeTargetWidth="1000" imageResizeTargetHeight="1000" imageResizeMode="cover" imageResizeUpscale="true" allowImageCrop="true" imageCropAspectRatio="1:1" v-bind:files="myFiles"/>
    </div>
</template>

<script>

// Import FilePond styles
import 'filepond/dist/filepond.min.css'

// Import image preview plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

import { vueFilePond, FilePondPluginFileValidateType, FilePondPluginImagePreview, FilePondPluginImageResize, FilePondPluginImageTransform, FilePondPluginImageCrop } from '../filepond.js' 

import { setOptions } from 'vue-filepond'

setOptions({
    server: {
        process: {
            url: '/crew/photos',
            method: 'POST',
            withCredentials: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            onload: null,
            onerror: null,
            ondata: null
        }
    }
})

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageResize,
    FilePondPluginImageTransform,
    FilePondPluginImageCrop
)
export default {
    name: 'app',
    data: function() {
        return { myFiles: [] }
    },
    components: {
        FilePond,
        vueFilePond,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageResize,
        FilePondPluginImageTransform,
        FilePondPluginImageCrop
    }
}
</script>
