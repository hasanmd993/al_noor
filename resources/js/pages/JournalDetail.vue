<template>
  <div v-if="blog" class="pt-28 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
    
    <router-link to="/journal" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition-colors flex items-center gap-1.5">
      <span>← Back to Journal</span>
    </router-link>

    <div class="space-y-4">
      <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 border border-amber-500/30 text-amber-400 inline-block">
        {{ blog.category }}
      </span>

      <h1 class="font-cinzel text-3xl sm:text-5xl font-bold text-white leading-tight">
        {{ blog.title }}
      </h1>

      <div class="flex items-center gap-4 text-xs text-slate-300 border-y border-slate-800 py-3">
        <span>By <strong class="text-white">{{ blog.author }}</strong></span>
        <span>•</span>
        <span>Published {{ new Date(blog.published_at).toLocaleDateString() }}</span>
      </div>
    </div>

    <!-- Featured Image -->
    <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl h-[400px]">
      <img :src="blog.featured_image" :alt="blog.title" class="w-full h-full object-cover" />
    </div>

    <!-- Article Content -->
    <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-slate-800 prose prose-invert max-w-none text-slate-300 leading-relaxed text-sm sm:text-base space-y-4" v-html="blog.content">
    </div>

    <!-- Share & Next -->
    <div class="pt-8 border-t border-slate-800 flex items-center justify-between">
      <router-link to="/journal" class="text-xs font-bold text-amber-400 hover:underline">
        ← Browse More Articles
      </router-link>
      <router-link to="/properties" class="px-6 py-2.5 rounded-full gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider">
        Explore Properties
      </router-link>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const blog = ref(null);

onMounted(async () => {
  try {
    const slug = route.params.id;
    const res = await axios.get(`/api/blogs/${route.params.id}`);
    if (res.data?.data) {
      blog.value = res.data.data;
    }
  } catch (err) {
    console.error('Error fetching blog detail', err);
  }
});
</script>
