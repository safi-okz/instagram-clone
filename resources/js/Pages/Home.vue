<script setup>
import { ref, onMounted, toRefs } from 'vue';
import ShowPostOverlay from '@/Components/ShowPostOverlay.vue'
import LikeSection from '@/Components/LikeSection.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';

import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue';

let width = ref(window.innerWidth);
let currentSlide = ref(0);
let currentPost = ref(null);
let openOverlay = ref(false);

const props = defineProps({
    posts: Object,
    allUsers: Object
});

const { posts, allUsers } = toRefs(props);

onMounted(() => {
    window.addEventListener('resize', () => {
        width.value = window.innerWidth;
    })
})
</script>

<template>
    <Head title="Instagram" />
    <MainLayout>
        <!-- {{ posts }} -->
        <div class="mx-auto lg:pl-0 md:pl-[80px] pl-0">
            <Carousel
                    v-model="currentSlide"
                    class="mx-auto max-w-[700px]"
                    :items-to-scroll="4"
                    :transition="500"
                    snap-align="start"
                    :itemsToShow="9" :wrapAround="true"

            >
                <Slide v-for="slide in allUsers" :key="slide">
                    <Link :href="route('user.show', {id: slide.id})" class="relative mx-auto text-center mt-4 px-2 cursor-pointer">
                        <div class="z-[-1] flex w-[64px] rounded-full rotate-45 h-[64px] bg-red contrast-[1.3] bg-gradient-to-t from-yellow-300 to-purple-200 via-red-500">
                            <div class="rounded-full flex ml-[3px] mt-[3px] mb-[3px] w-[58px] h-[58px] bg-white">

                                <img :src="slide.file" alt="" class="rounded-full w-[58px] h-[58px]" />
                            </div>
                        </div>
                        <div class="text-xs mt-2 w-[60px] turncate text-ellipsise overflow-hidden">
                         {{ slide.name }}
                        </div>
                    </Link>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>

            <div id="Posts" v-for="post in posts.data" :key="post" class="px-4 max-w-[600px] mx-auto mt-10">
                <div class="flex justify-between items-center py-2">
                    <div class="flex items-center">
                        <Link :href="route('user.show', {id: post.user.id})" class="flex items-center">
                            <img :src="post.user.file" alt="" class="rounded-full h-[38px] h-[38px]">
                            <div class="ml-4 font-extrabold text-[15px]">{{ post.user.name }}</div>
                        </Link>
                        <div class="flex items-center text-[15px] text-gray-500">
                            <span class="-mt-5 ml-2 mr-[5px] text-[35px]">.</span>
                            <div>{{ post.created_at }}</div>
                        </div>
                    </div>

                    <DotsHorizontal class="cursor-pointer" :size="27" />
                </div>
                <div class="bg-black rounded-lg w-full flex items-center min-h-[400px]">
                    <img :src="post.file" alt="" class="mx-auto w-full">
                </div>

                <LikeSection
                            :post="post"
                            @like="updateLike($event)"
                 />
                <div class="text-black font-extrabold py-1">{{ post.liekes.length }} Likes</div>

                <div>
                    <span class="text-black font-extrabold">{{ post.user.name }}</span>
                    {{ post.text }}
                </div>
                <button @click="currentPost = post; openOverlay = true" class="text-gray-500 font-extrabold py-1">
                    View all {{ post.comments.length }} commnets
                </button>
            </div>

            <div class="py-20"></div>
        </div>
        <!-- <ShowPostOverlay /> -->
    </MainLayout>
    <ShowPostOverlay
                v-if="openOverlay"
                :post="currentPost"
                @closeOverlay="openOverlay = false"
    />
</template>

<style>
    .carousel__prev,
    .carousel__next,
    .carousel__prev:hover,
    .carousel__next:hover {
        color: rgb(49, 49, 49);
        background-color: rgb(255, 255, 255);
        border-radius: 100%;
        margin: 0 20px;
    }
</style>
