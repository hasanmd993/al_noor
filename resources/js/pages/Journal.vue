<template>
  <div class="pt-28 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    
    <div class="text-center max-w-3xl mx-auto space-y-3">
      <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
        Market Intelligence & Architecture
      </span>
      <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white">
        The Al-Noor Journal
      </h1>
      <p class="text-sm text-slate-300">
        In-depth analyses of Dhaka real estate market trends, landowner guidance, biophilic architecture, and luxury lifestyle perspectives.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <article 
        v-for="blog in blogs" 
        :key="blog.id"
        class="glass-panel-hover rounded-3xl overflow-hidden border border-slate-800 bg-[#0d1322] flex flex-col"
      >
        <div class="h-52 overflow-hidden relative">
          <img :src="blog.featured_image" :alt="blog.title" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
          <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/80 text-amber-400 border border-amber-500/30">
            {{ blog.category }}
          </span>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
          <div>
            <div class="text-[11px] text-slate-300 flex items-center justify-between">
              <span>{{ blog.author }}</span>
              <span>{{ new Date(blog.published_at).toLocaleDateString() }}</span>
            </div>
            <h3 class="font-cinzel text-lg font-bold text-white hover:text-amber-400 transition-colors mt-2">
              <router-link :to="`/journal/${blog.id}`">{{ blog.title }}</router-link>
            </h3>
            <p class="text-xs text-slate-300 line-clamp-3 mt-2 leading-relaxed">
              {{ blog.excerpt }}
            </p>
          </div>

          <router-link :to="`/journal/${blog.id}`" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition-colors flex items-center gap-1.5">
            <span>Read Article</span>
            <span>→</span>
          </router-link>
        </div>
      </article>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const blogs = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/blogs');
    if (res.data?.data) {
      blogs.value = res.data.data;
    }
  } catch (err) {
    console.error('Error fetching blogs', err);
  }
});
</script>
