<template>
    <div v-if="loaded">
        <h2>Featured Posts</h2>
        <ul>
            <li v-for="post in posts" :key="post.id">{{ post.title }}</li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
const posts = ref([])
const loaded = ref(false)

onMounted(async () => {
    const res = await fetch('/api/featured-posts')
    posts.value = await res.json()
    loaded.value = true
})
</script>
