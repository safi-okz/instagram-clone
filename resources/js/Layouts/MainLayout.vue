<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

import Magnify from 'vue-material-design-icons/Magnify.vue';
import HeartOutline from 'vue-material-design-icons/HeartOutline.vue';
import HomeOutline from 'vue-material-design-icons/HomeOutline.vue';
import Compass from 'vue-material-design-icons/Compass.vue';
import SendOutline from 'vue-material-design-icons/SendOutline.vue';
import Plus from 'vue-material-design-icons/Plus.vue';
import AccountOutline from 'vue-material-design-icons/AccountOutline.vue';
import ChevronLeft from 'vue-material-design-icons/ChevronLeft.vue';
import AccountPlusOutline from 'vue-material-design-icons/AccountPlusOutline.vue';

import MenuItem from '@/Components/MenuItem.vue'
// import CreatePostOverlay from '@/Components/CreatePostOverlay.vue'
import CreatePostOverlay from '@/Components/CreatePostOverlay.vue';

let showCreatePost = ref(false)

</script>

<template>
    <div class="w-full h-screen" id="MainLayout">
        <div v-if="$page.url === '/'" id="ToNavHome" class="fixed z-30 md:hidden block w-full bg-white h-[61px] border-b border-b-gray-300">
            <div class="flex items-center justify-between h-full">
                <Link href="/">
                    <img class="w-[105px] ml-6 cursor-pointer" src="/insta-logo.png"/>
                </Link>
                <div class="flex items-center w-[50%]">
                    <div class="flex items-center bg-gray-100 w-full rounded-full">
                        <Magnify class="pl-4" fillColor="#bebebe" size="27" />
                        <input type="text" placeholder="Search" class="bg-transparent placeholder-[#8e8e8e] w-full border-0 ring-0 focus:ring-0">
                    </div>
                    <HeartOutline class="px-4" fillColor="#000000" :size="27" />
                </div>
            </div>
        </div>
        <div
            v-if="$page.url !== '/'"
            id="TopNavUser"
            class="md:hidden fixed flex items-center justify-between z-30 w-full bg-white h-[61px] border-b border-b-gray-300"
            >
            <Link href="/" class="px-4">
                <ChevronLeft size="30" class="cursor-pointer" />
            </Link>
            <div class="font-extrabold text-gl">{{ $page.props.auth.user.name }}</div>
            <AccountPlusOutline size="30" class="curosr-pointer px-4" />

        </div>
        <div id="SideNav" class="h-full fixed w-full be-white xl:w-[280px] w-[80px] border-r border-r-gray-300 md:block hidden">
            <Link href="/">
                <img src="/insta-logo-small.png" class="xl:hidden w-[25px] mt-10 ml-[25px] mb-10 cursor-pointer" alt="">
                <img src="/insta-logo.png" class="xl:block hidden w-[120px] mt-10 ml-6 mb-10 cursor-pointer" alt="">
            </Link>
            <div class="px-3">
                <Link href="/">
                    <MenuItem iconString="Home" class="mb-4" />
                    <!-- <MenuItem iconString="" class="mb-4" /> -->
                </Link>
                <MenuItem iconString="Explore" class="mb-4" />
                <MenuItem iconString="Messages" class="mb-4" />
                <MenuItem iconString="Notifications" class="mb-4" />
                <MenuItem @click="showCreatePost = true" iconString="Create" class="mb-4" />
                <Link :href="route('user.show', { id: $page.props.auth.user.id })">
                    <MenuItem iconString="Profile" class="mb-4" />
                </Link>
            </div>
            <Link :href="route('logout')" class="absolute bottom-0 px-3 w-full">
                <MenuItem icon-string="Log out" class="mb-4" />
            </Link>
        </div>
        <div class="flex lg:justify-between bg-white h-full w-[100%-280px] xl:pl-[280px] lg:pl-[100px] overflow-auto">
            <div
                class="mx-auto md:pt-6 pt-20"
                :class="$page.url === '/' ? 'w-8/12 w-full' : 'max-w-[1200px]'"
                >
                <main>
                    <slot />
                </main>
            </div>
            <div v-if="$page.url === '/'" id="SuggestionsSection" class="lg:w-4/12 lg:block hidden text-black mt-10">
                <Link :href="route('user.show', { id: $page.props.auth.user.id })" class="flex items-center justify-between max-w-[300px]">
                    <div class="flex items-center">
                        <img :src="$page.props.auth.user.file" alt="" class="rounded-full z-50 w-[58px] h-[58px]">
                        <div class="pl-4">
                            <div class="text-black font-extrabold">{{ $page.props.auth.user.name }}</div>
                            <div class="text-gray-500 font-extrabold text-sm">{{ $page.props.auth.user.name }}</div>
                        </div>
                    </div>
                    <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                        Switch
                    </button>
                </Link>
                <div class="max-w-[300px] flex items-center justify-between py-3">
                    <div class="text-gray-500 font-extrabold">Suggection for you</div>
                    <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                        See all
                    </button>
                </div>
                <div v-for="randomUser in $page.props.randomUsers" :key="randomUser">
                    <Link :href="route('user.show', {id: randomUser.id})" class="flex items-center justify-between max-w-[300px] pb-2">
                    <div class="flex items-center">
                        <img :src="randomUser.file" alt="" class="rounded-full z-50 w-[37px] h-[37px]">
                        <div class="pl-4">
                            <div class="text-black font-extrabold">{{ randomUser.name }}</div>
                            <div class="text-gray-500 font-extrabold text-sm">Suggested for you</div>
                        </div>
                    </div>
                    <button class="text-blue-500 hover:text-gray-900 text-xs font-extrabold">
                        Follow
                    </button>
                </Link>
                </div>
                <div class="max-w-[300px] mt-5">
                    <div class="text-sm text-gray-500">About help press api job privacy trems loaction language</div>
                    <div class="text-left text-gray-400 mt-4">&copy; INSTAGRAM FROM META</div>
                </div>
            </div>
        </div>

        <div id="BottomNav" class="fixed bottom-0 z-30 w-full md:hidden flex items-center justify-around bg-white py-2 border-t border-t-gray-300">
            <Link href="/">
                <HomeOutline fillColor="#000" :size="33" class="cursor-pointer" />
            </Link>
            <Compass fillColor="#000" :size="33" class="cursor-pointer" />
            <SendOutline fillColor="#000" :size="33" class="cursor-pointer" />
            <Plus @click="showCreatePost = true" fillColor="#000" :size="33" class="cursor-pointer" />
            <AccountPlusOutline fillColor="#000" :size="33" class="cursor-pointer" />
            <Link :href="route('user.show', { id: $page.props.auth.user.id })">
                <img :src="$page.props.auth.user.file" class="rounded-full w-[30px] cursor-pointer" alt="">
            </Link>
        </div>
    </div>
    <CreatePostOverlay v-if="showCreatePost" @close="showCreatePost = false" />
</template>
