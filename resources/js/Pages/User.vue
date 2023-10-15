<script setup>
import { reactive, toRefs } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ContentOverlay from '@/Components/ContentOverlay.vue';
import ShowPostOverlayVue from '@/Components/ShowPostOverlay.vue';
import Cog from 'vue-material-design-icons/Cog.vue';
import Grid from 'vue-material-design-icons/Grid.vue';
import PlayBoxOutline from 'vue-material-design-icons/PlayBoxOutline.vue';
import BookmarkOutline from 'vue-material-design-icons/BookmarkOutline.vue';
import AccountBoxOutline from 'vue-material-design-icons/AccountBoxOutline.vue';

let data = reactive({post: null});
const form = reactive({file: null});

const props = defineProps({postByUser: Object, user: Object});
const { postByUser, user } = toRefs(props);

const getUploadedImage = (e) => {
    form.file = e.target.files[0]

    router.post(`/users`, form, {
        preserveState: false
    });
}

const addComment = (object) => {
    console.log('comment data ', object.post.id)
    router.post('/comments', {
        post_id: object.post.id,
        user_id: object.user.id,
        comment: object.comment
    }, {
        onFinish: () => updatePost(object)
    })
}

const deleteFunc = (object) => {
        let url = '';
        if(object.deleteType === 'Post'){
            url = '/posts/' + object.id;
            setTimeout(() => data.post = null, 100);
        } else {
            url = '/comments/' + object.id;
        }

        router.delete(url, {
            onFinish: () => updatePost(object)
        });
}

const updateLike = (object) => {
    let deleteLike = false;
    let id = null;

    for(let i = 0; i < object.post.likes.length; i++){
        const like = object.post.likes[i];

        if(like.user_id == object.user.id && like.post_id === object.post.id){
            deleteLike = true;
            id = like.id;
        }
    }

    if(deleteLike){
        router.delete('/likes/' + id, {
            onFinish: () => updatePost(object)
        });
    } else {
        router.post('/likes', {
            post_id: object.post.id
        },
        {
            onFinish: () => updatePost(object)
        })
    }
}

const updatePost = (object) => {
    for(let i = 0; i < postByUser.value.data.length; i++){
        const post = postByUser.value.data[i];
        if(post.id === object.post.id) {
            data.post = post;
        }
    }
}
</script>

<template>
    <Head title="Instagram" />
    <MainLayout>
        <div class="pt-2 md:pt-6"></div>
        <div class="max-w-[880px] lg:ml-0 md:ml-[80px] md:pl-20 px-4 w-[100vh]">
            <div class="flex items-center md:justify-between">
                <label for="fileUser">
                    <img
                        class="rounded-full object-fit md:w-[200px] w-[100px] cursor-pointer"
                        :src="user.file"
                    >
                </label>
                <input
                    v-if="user.id === $page.props.auth.user.id"
                    id="fileUser"
                    class="hidden"
                    type="file"
                    @input="getUploadedImage($event)"
                >

                <div class="ml-6 w-full">
                    <div class="flex items-center md:mb-8 mb-5">
                        <div class="md:mr-6 mr-3 rounded-lg text-[22px]">{{ user.name }}</div>
                        <button class="md:block hidden md:mr-6 p-1 px-4 text-[16px] rounded-lg font-exrtabold bg-gray-100 hover:bg-gray200">
                            Edit Profile
                        </button>
                        <Cog :size="28" class="cursor-pointer" />
                    </div>
                    <button class="md:hidden hidden md:mr-6 p-1 px-4 text-[16px] rounded-lg font-exrtabold bg-gray-100 hover:bg-gray200">
                            Edit Profile
                    </button>
                    <div class="md:block hidden">
                        <div class="flex items-center text-[18px]">
                            <div class="mr-6">
                                <span class="font-extrabold">{{ postByUser.data.length }}</span> posts
                            </div>
                            <div class="mr-6">
                                <span class="font-extrabold">4</span> followers
                            </div>
                            <div class="mr-6">
                                <span class="font-extrabold">4</span> following
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:hidden">
            <div class="w-full flex items-center justify-around border-t border-t-gray-300 mt-8">
                <div class="text-center pt-3">
                    <div class="font-extrabold">{{ postByUser.data.length }}</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">Posts</div>
                </div>
                <div class="text-center pt-3">
                    <div class="font-extrabold">4</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">Followers</div>
                </div>
                <div class="text-center pt-3">
                    <div class="font-extrabold">4</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">Following</div>
                </div>
            </div>

            <div class="w-full flex items-center justify-between border-t border-t-gray-300">
                <div class="p-3 w-1/4 flex justify-center border-t border-t-gray-900">
                    <Grid :size="28" fillColor="#0095F6" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <PlayBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <BookmarkOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <AccountBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
            </div>
        </div>

        <div id="ContentSection" class="md:pr-1.5 lg:pl-0 md:pl-[90px]">
            <div class="md:block mt-10 hidden border-t border-t-gray-300">
                <div class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-400 text-[15px]">
                    <div class="p-[17px] w-1/4 flex justify-center items-center border-t border-t-gray-900">
                        <Grid :size="15" fillColor="#000000" class="cursor-pointer"/>
                        <div class="ml-2 -mb-[1px] text-gray-900">POSTS</div>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <PlayBoxOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer"/>
                        <div class="ml-2 -mb-[1px] text-gray-900">REELS</div>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <BookmarkOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer"/>
                        <span class="ml-2 -mb-[1px]">SAVED</span>
                    </div>
                    <div class="p-[17px] w-1/4 flex justify-center items-center">
                        <AccountBoxOutline :size="15" fillColor="#8E8E8E" class="cursor-pointer"/>
                        <span class="ml-2 -mb-[1px]">TAGGED</span>
                    </div>
                </div>
            </div>

            <div class="grid md:gap-4 gap-1 grid-cols-3 relative">
                <div v-for="postByUser in postByUser.data" :key="postByUser">
                    <ContentOverlay
                                :postByUser="postByUser"
                                @selectedPost="data.post = $event"
                    />
                </div>
            </div>

            <div class="pb-20"></div>
        </div>
    </MainLayout>

    <ShowPostOverlay
                v-if="data.post"
                :post="data.post"
                @addComment="addComment($event)"
                @updateLike="updateLike($event)"
                @deleteSelected="deleteFunc($event)"
                @closeOverlay="data.post = null"
    />
</template>
