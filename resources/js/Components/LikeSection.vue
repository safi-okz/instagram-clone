<template>
    <div class="flex items-center z-20 justify-between">
        <div class="flex items-center">
            <button class="-mt-[14px]">
                <HeartOutline class="pl-3 cursor-pointer" :size="30" />
            </button>
            <CommentOutline class="pl-3 pt-[10px]" :size="30" />
            <SendOutline clas="pl-3 pt-[10px]" :size="30" />
        </div>
        <BookMarkOutline class="pl-3 pt-[10px]" :size="30" />
    </div>
</template>

<script setup>
import { ref, toRefs } from 'vue';
import { usePage } from '@inertiajs/vue3'

import Heart from 'vue-material-design-icons/Heart.vue';
import HeartOutline from 'vue-material-design-icons/HeartOutline.vue';
import CommentOutline from 'vue-material-design-icons/CommentOutline.vue';
import SendOutline from 'vue-material-design-icons/SendOutline.vue'
import BookMarkOutline from 'vue-material-design-icons/BookmarkOutline.vue';

const props = defineProps(['posts']);
const { posts } = toRefs(props);

const emits = defineEmits(['like']);

// const user = usePage().props.auth.user;
</script>
