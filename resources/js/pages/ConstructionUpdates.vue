<template>
  <div class="pt-28 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    
    <div class="text-center max-w-3xl mx-auto space-y-3">
      <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
        Total Milestone Transparency
      </span>
      <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white">
        Live Construction Progress Tracker
      </h1>
      <p class="text-sm text-slate-300">
        Monitor real-time progress percentages, substructure piling, structural casting, and architectural finishing across all active Al-Noor landmarks.
      </p>
    </div>

    <div class="space-y-8">
      <div 
        v-for="prop in propertiesWithUpdates" 
        :key="prop.id"
        class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-6"
      >
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-4">
          <div>
            <span class="text-xs text-amber-400 font-bold uppercase tracking-wider block">
              📍 {{ prop.location?.name || prop.address }}
            </span>
            <h2 class="font-cinzel text-2xl font-bold text-white mt-1">
              {{ prop.name }}
            </h2>
          </div>

          <!-- Progress Pill -->
          <div class="flex items-center gap-4">
            <div class="text-right">
              <span class="text-[10px] text-slate-300 uppercase block">Overall Completion</span>
              <span class="font-cinzel text-2xl font-bold text-amber-400 font-mono">{{ prop.progress_percentage }}%</span>
            </div>
            <router-link :to="`/properties/${prop.id}`" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white font-bold text-xs uppercase transition-colors">
              View Project
            </router-link>
          </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-slate-900 h-3 rounded-full overflow-hidden border border-slate-800">
          <div class="gold-gradient-bg h-full rounded-full transition-all duration-1000" :style="{ width: `${prop.progress_percentage}%` }"></div>
        </div>

        <!-- Construction Milestones Grid -->
        <div v-if="prop.construction_updates && prop.construction_updates.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div 
            v-for="(update, idx) in prop.construction_updates" 
            :key="idx"
            class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 space-y-2"
          >
            <div class="flex items-center justify-between text-xs">
              <span class="font-bold text-amber-400">{{ update.title }}</span>
              <span class="text-slate-300 font-mono">{{ update.update_date }}</span>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">{{ update.description }}</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { useSeoMeta } from '@unhead/vue';

useSeoMeta({
  "title": "Live Construction Milestones & Handover Progress | Al-Noor Properties",
  "description": "Track real-time engineering milestones, structural progress, and site photography across all active projects.",
  "ogTitle": "Project Construction Progress | Al-Noor Properties BD",
  "ogDescription": "Transparent milestone tracking and handover timeline verification.",
  "ogImage": "/images/logo.jpeg"
});

import { ref, onMounted } from 'vue';
import axios from 'axios';

const propertiesWithUpdates = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/properties');
    if (res.data?.data) {
      propertiesWithUpdates.value = res.data.data.filter(p => p.status !== 'upcoming');
    }
  } catch (err) {
    console.error('Error fetching progress tracker', err);
  }
});
</script>
