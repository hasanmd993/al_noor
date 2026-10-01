<template>
  <div class="pt-28 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
    
    <!-- Hero Section -->
    <section class="text-center max-w-3xl mx-auto space-y-4">
      <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 border border-amber-500/30 text-amber-400 inline-block">
        Heritage & Distinction
      </span>
      <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white leading-tight">
        25 Years of Architectural Excellence
      </h1>
      <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-light">
        Al-Noor Properties BD was founded on a singularly uncompromising ethos: to craft architectural landmarks that merge timeless elegance with structural invulnerability across Bangladesh.
      </p>
    </section>

    <!-- Company Story & Mission -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      <div class="lg:col-span-6 relative">
        <div class="relative rounded-3xl overflow-hidden border border-amber-500/30 shadow-2xl">
          <img 
            src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1000&q=80" 
            alt="Al-Noor Properties BD Legacy" 
            class="w-full h-[450px] object-cover"
          />
        </div>
      </div>

      <div class="lg:col-span-6 space-y-6">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-1">
          Our Foundation
        </span>
        <h2 class="font-cinzel text-3xl font-bold text-white">
          Where Engineering Integrity Meets Aesthetic Mastery
        </h2>
        <p class="text-sm text-slate-300 leading-relaxed">
          Over the past two and a half decades, Al-Noor Properties BD has delivered more than 3.5 million square feet of residential, commercial, and mixed-use luxury spaces. We have redefined Dhaka’s skyline through seismic-resilient engineering, biophilic green facades, and world-class interior finishing.
        </p>
        <p class="text-sm text-slate-300 leading-relaxed">
          Every project we undertake is subjected to rigorous soil dynamics testing, BUET-certified structural audits, and international fire safety protocols (NFPA compliance), guaranteeing lifelong security for generations to come.
        </p>

        <div class="grid grid-cols-2 gap-4 pt-2">
          <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
            <h4 class="text-amber-400 font-bold text-sm">99.4% On-Time Record</h4>
            <p class="text-xs text-slate-300 mt-0.5">Firm commitment to handover milestones.</p>
          </div>
          <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
            <h4 class="text-amber-400 font-bold text-sm">LEED Green Standards</h4>
            <p class="text-xs text-slate-300 mt-0.5">Energy efficiency and rainwater reuse.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Leadership Team -->
    <section class="space-y-10">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
          Visionary Leadership
        </span>
        <h2 class="font-cinzel text-3xl font-bold text-white">
          Board of Directors & Executives
        </h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div 
          v-for="member in team" 
          :key="member.id"
          class="glass-panel p-6 rounded-3xl border border-slate-800 text-center space-y-4"
        >
          <div class="w-32 h-32 rounded-full overflow-hidden mx-auto border-2 border-amber-500/40 shadow-xl">
            <img :src="member.photo" :alt="member.name" class="w-full h-full object-cover" />
          </div>
          <div>
            <h3 class="font-cinzel text-lg font-bold text-white">{{ member.name }}</h3>
            <p class="text-xs text-amber-400 font-medium">{{ member.designation }}</p>
          </div>
          <p class="text-xs text-slate-300 leading-relaxed">
            {{ member.bio }}
          </p>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { useSeoMeta } from '@unhead/vue';

useSeoMeta({
  "title": "About Al-Noor Properties BD | Architectural Vision & Heritage",
  "description": "Learn about Al-Noor's legacy of uncompromising engineering, sustainable luxury, and architectural brilliance.",
  "ogTitle": "About Us | Al-Noor Properties BD",
  "ogDescription": "Our vision, leadership, and dedication to timeless Dhaka architecture.",
  "ogImage": "/images/logo.jpeg"
});

import { ref, onMounted } from 'vue';
import axios from 'axios';

const team = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/team');
    if (res.data?.data) {
      team.value = res.data.data;
    }
  } catch (err) {
    console.error('Error fetching team', err);
  }
});
</script>
