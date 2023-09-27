<template>
    <div id="OverlaySection" class="fixed absolute z-50 top-0 left-0 h-screen w-full bg-[#000] bg-opacity-60 p-3">
        <button class="absolute right-3 cursor-pointer" @click="closeOverly">
            <Close :size="27" fillColor="#fff" />
        </button>

        <div class="min-w-6xl h-[calc(100%-100px)] mx-auto mt-10 rounded-xl opacity-100" style="background-color: rgba(255, 255, 255, 1);">
            <div class="flex items-center justify-between w-full p-3 rounded-t-xl border-b border-b-gray-300">
                <ArrowLeft fillColor="#000" :size="30" @click="closeOverly" />
                <div class="text-lg font-extrabold">New reels</div>
                <button @click="createPostFunc" class="text-lg text-blue-500 hover:text-gray-900 font-extrabold">
                    Share
                </button>
            </div>

            <div class="w-full md:flex h-[calc(100%-55px)] rounded-xl overflow-auto">
                <div class="flex items-center bg-gray-100 w-full h-full overflow-hidden">
                    <div v-if="!fileDisplay" class="flex flex-col items-center mx-auto">
                        <label for="file" class="hover:bg-blue-700 bg-blue-500 rounded-gl p-2.5 text-white font-extrabold cursor-pointer">
                            Select from computer
                        </label>
                        <input type="file" id="file" class="hidden" @input="getUploadImage($event)">
                        <div v-if="error && error.file" class="text-red-500 text-center p-2 font-extrabold">
                            {{ error.file }}
                        </div>
                        <div v-if="!fileDisplay && isValidFile === false" class="text-red-500 text-center p-2 font-extrabold">
                            File not accepted
                        </div>
                    </div>
                    <img v-if="fileDisplay && isValidFile === true" :src="fileDisplay" class="min-w-[400px] p-4 mx-auto" alt="">
                </div>
                <div id="TextAreaSection" class="max-w-[772px] w-full relative">
                    <div class="flex justify-between items-center p-3">
                        <div class="flex items-center">
                            <img src="https://picsum.photos/id/50/300/320" alt="" class="rounded-full h-[38px] w-[38px]">
                            <div class="ml-4 text-[15px] font-extrabold">Name here</div>
                        </div>
                    </div>

                    <div v-if="error && error.text" class="text-red-500 p-2 font-extrabold">{{ error.text }}</div>

                    <div class="flex w-full max-h-[200px] bg-white border-b">
                        <textarea
                                ref="textarea"
                                v-model="form.text"
                                placeholder="Write caption"
                                rows="10"
                                class="placeholde-gray-500 w-full mt-2 mb-2 border-0 z-50 text-[18px] focus:ring-0 text-gray-600"
                        ></textarea>
                    </div>

                    <div class="flex items-center justify-between border-b p-3">
                        <div class="text-lg font-extrabold text-gray-500">Add loaction</div>
                        <MapMarkerOutline :size="37" />
                    </div>
                    <div class="flex items-center justify-between border-b p-3">
                        <div class="text-lg font-extrabold text-gray-500">Accesibilty</div>
                        <ChevronDown :size="37" />
                    </div>
                    <div class="flex items-center justify-between border-b p-3">
                        <div class="text-lg font-extrabold text-gray-500">Adavance Settings</div>
                        <ChevronDown :size="37" />
                    </div>

                    <div class="text-gray-500 mt-3 p-3 text-sm">
                        Yours reels will be share with your followers in their feeds and can be seen your profile.
                        It may also apear in place as a reels, where anyone can see it.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

import Close from 'vue-material-design-icons/Close.vue';
import ArrowLeft from 'vue-material-design-icons/ArrowLeft.vue';
import MapMarkerOutline from 'vue-material-design-icons/MapMarkerOutline.vue';
import ChevronDown from 'vue-material-design-icons/ChevronDown.vue';

const emits = defineEmits(['close']);

const isValidFile = ref(null);
let fileDisplay = ref('');
let textarea = ref('');
const form = reactive({
    text: null,
    file: null
});
let error = ref({
        text: null,
        file: null,
    })

const createPostFunc = () => {
    error.value.text = null;
    error.value.file = null;

    router.post('/posts', form, {
        forceFormData: true,
        preserveScroll: true,
        onError: errors => {
            errors && errors.text ? error.value.text = errors.text : '';
            errors && errors.file ? error.value.file = errors.file : '';
        },
        onSuccess: () => {
            closeOverly();
            emits('close');
        }
    })
}

const getUploadImage = (e) => {
    form.file = e.target.files[0]
    let extention = form.file.name.substring(form.file.name.lastIndexOf('.') + 1);

    if(extention === 'png' || extention === 'jpeg' || extention == 'jpg') {
        isValidFile.value = true;
    } else {
        isValidFile.value = false;
        return;
    }

    fileDisplay.value = URL.createObjectURL(e.target.files[0]);

    setTimeout(() => {
        document.getElementById('TextAreaSection').scrollIntoView({behavior: 'smooth'});
    }, 300);

}

const closeOverly = () => {
    form.text = null;
    form.fill = null;
    fileDisplay.value = '';
    emits('close');
}
</script>
