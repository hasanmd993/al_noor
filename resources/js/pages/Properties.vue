<template>
  <div class="pt-28 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
    
    <!-- Page Header -->
    <div class="text-center max-w-3xl mx-auto space-y-3">
      <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
        Dhaka's Finest Living Spaces
      </span>
      <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white">
        Signature Properties Collection
      </h1>
      <p class="text-sm text-slate-300">
        Discover bespoke luxury residences, waterfront sky apartments, and Grade-A commercial landmarks across Gulshan, Banani, Dhanmondi, Bashundhara, and Uttara.
      </p>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="glass-panel p-6 rounded-3xl border border-amber-500/20 shadow-xl space-y-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- Search Input -->
        <div class="lg:col-span-2 relative">
          <input 
            v-model="filters.search" 
            type="text" 
            placeholder="Search by project name, address, or zone..."
            class="w-full bg-[#070a11] border border-slate-700 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500"
          />
          <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>

        <!-- Status Filter -->
        <div>
          <select 
            v-model="filters.status" 
            class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"
          >
            <option value="">All Statuses</option>
            <option value="ongoing">Ongoing Construction</option>
            <option value="ready">Ready to Handover</option>
            <option value="upcoming">Upcoming Launches</option>
          </select>
        </div>

        <!-- Type Filter -->
        <div>
          <select 
            v-model="filters.type" 
            class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"
          >
            <option value="">All Categories</option>
            <option value="residential">Luxury Residential</option>
            <option value="commercial">Commercial Tower</option>
          </select>
        </div>

        <!-- Sorting -->
        <div>
          <select 
            v-model="filters.sort" 
            class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"
          >
            <option value="featured">Featured First</option>
            <option value="price_low">Price: Low to High</option>
            <option value="price_high">Price: High to Low</option>
            <option value="latest">Recently Added</option>
          </select>
        </div>

      </div>

      <!-- Quick Location Pill Buttons -->
      <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-800 text-xs">
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-slate-300 font-semibold mr-1">Locations:</span>
          <button 
            v-for="loc in ['All', 'Gulshan 2', 'Banani', 'Dhanmondi', 'Bashundhara R/A', 'Uttara']" 
            :key="loc"
            @click="selectLocationPill(loc)"
            :class="[
              'px-3 py-1 rounded-full text-xs font-medium transition-colors',
              (selectedLocation === loc || (loc === 'All' && !selectedLocation)) 
                ? 'gold-gradient-bg text-slate-950 font-bold' 
                : 'bg-slate-800 text-slate-300 hover:text-white'
            ]"
          >
            {{ loc }}
          </button>
        </div>

        <!-- View Mode (Grid vs Map View) -->
        <div class="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
          <button 
            @click="viewMode = 'grid'"
            :class="[
              'px-3 py-1 rounded-lg text-xs font-medium flex items-center gap-1.5 transition-colors',
              viewMode === 'grid' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-300 hover:text-white'
            ]"
          >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>Grid</span>
          </button>

          <button 
            @click="viewMode = 'map'"
            :class="[
              'px-3 py-1 rounded-lg text-xs font-medium flex items-center gap-1.5 transition-colors',
              viewMode === 'map' ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-300 hover:text-white'
            ]"
          >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            <span>Interactive Map</span>
          </button>
        </div>

      </div>
    </div>

    <!-- Active Projects Count -->
    <div class="flex items-center justify-between text-xs text-slate-300">
      <span>Showing <strong>{{ filteredProperties.length }}</strong> luxury properties</span>
      <span v-if="filteredProperties.length === 0" class="text-amber-400">No properties matched your filter. Showing all available.</span>
    </div>

    <!-- View Mode: Map View -->
    <div v-if="viewMode === 'map'" class="space-y-6">
      <InteractiveMap :properties="filteredProperties" />
    </div>

    <!-- View Mode: Grid View -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div 
        v-for="property in filteredProperties" 
        :key="property.id"
        class="glass-panel-hover rounded-3xl overflow-hidden border border-slate-800 bg-[#0d1322] flex flex-col group"
      >
        <!-- Thumbnail -->
        <div class="relative h-64 overflow-hidden">
          <img 
            :src="property.featured_image || 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80'" 
            :alt="property.name" 
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
          />
          
          <div class="absolute top-4 left-4 flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider gold-gradient-bg text-slate-950 shadow-md">
              {{ property.status === 'completed' ? 'Ready' : (property.status === 'upcoming' ? 'Upcoming' : 'Ongoing') }}
            </span>
          </div>

          <div class="absolute bottom-3 right-3 px-3 py-1.5 rounded-xl bg-[#070a11]/90 backdrop-blur-md border border-amber-500/30 text-xs font-bold text-amber-400">
            {{ property.price_label || 'Price on Inquiry' }}
          </div>
        </div>

        <!-- Body -->
        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
          <div>
            <div class="flex items-center gap-2 text-xs text-amber-400 font-medium mb-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              </svg>
              <span>{{ property.location?.name || property.address }}</span>
            </div>

            <h3 class="font-cinzel text-xl font-bold text-white group-hover:text-amber-400 transition-colors">
              {{ property.name }}
            </h3>

            <p class="text-xs text-slate-300 line-clamp-2 mt-2 leading-relaxed">
              {{ property.short_description || property.description }}
            </p>
          </div>

          <!-- Specs -->
          <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-800/80 text-center text-xs">
            <div>
              <span class="text-[10px] text-slate-300 block uppercase">Land</span>
              <strong class="text-white font-medium">{{ property.land_area }} Katha</strong>
            </div>
            <div>
              <span class="text-[10px] text-slate-300 block uppercase">Floors</span>
              <strong class="text-white font-medium">G+{{ property.total_floors }}</strong>
            </div>
            <div>
              <span class="text-[10px] text-slate-300 block uppercase">Progress</span>
              <strong class="text-amber-400 font-medium">{{ property.progress_percentage }}%</strong>
            </div>
          </div>

          <!-- Actions -->
          <div class="pt-2 flex items-center justify-between gap-3">
            <router-link 
              :to="`/properties/${property.id}`" 
              class="flex-1 py-2.5 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white font-semibold text-xs uppercase tracking-wider text-center transition-all duration-300"
            >
              Explore Property
            </router-link>

            <button 
              @click="$emit('open-vip-modal', property.name)"
              aria-label="Schedule VIP Tour"
              class="p-2.5 rounded-xl border border-slate-700 hover:border-amber-400 text-slate-300 hover:text-amber-400 transition-colors"
              title="Book VIP Viewing"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </button>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { useSeoMeta } from '@unhead/vue';

useSeoMeta({
  "title": "Exclusive Property Portfolio | Penthouses & Luxury Apartments | Al-Noor",
  "description": "Browse our curated collection of upcoming, ongoing, and ready luxury residential projects in Dhaka.",
  "ogTitle": "Curated Luxury Properties | Al-Noor Properties BD",
  "ogDescription": "Browse ongoing, upcoming, and ready architectural developments in Dhaka's premier zones.",
  "ogImage": "/images/logo.jpeg"
});

import { ref, reactive, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import InteractiveMap from '../components/InteractiveMap.vue';

const route = useRoute();
defineEmits(['open-vip-modal']);

const viewMode = ref('grid');
const properties = ref([]);
const selectedLocation = ref('');

const filters = reactive({
  search: '',
  status: '',
  type: '',
  sort: 'featured'
});

const selectLocationPill = (loc) => {
  if (loc === 'All') {
    selectedLocation.value = '';
    filters.search = '';
  } else {
    selectedLocation.value = loc;
    filters.search = loc;
  }
};

const filteredProperties = computed(() => {
  let result = [...properties.value];

  if (filters.search) {
    const s = filters.search.toLowerCase();
    result = result.filter(p => 
      (p.name && p.name.toLowerCase().includes(s)) ||
      (p.address && p.address.toLowerCase().includes(s)) ||
      (p.short_description && p.short_description.toLowerCase().includes(s)) ||
      (p.location?.name && p.location.name.toLowerCase().includes(s))
    );
  }

  if (filters.status) {
    result = result.filter(p => p.status === filters.status);
  }

  if (filters.type) {
    result = result.filter(p => p.type === filters.type);
  }

  // Sorting
  if (filters.sort === 'price_low') {
    result.sort((a, b) => (parseFloat(a.price_from) || 0) - (parseFloat(b.price_from) || 0));
  } else if (filters.sort === 'price_high') {
    result.sort((a, b) => (parseFloat(b.price_from) || 0) - (parseFloat(a.price_from) || 0));
  } else if (filters.sort === 'latest') {
    result.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
  }

  return result;
});

const fetchProperties = async () => {
  try {
    const res = await axios.get('/api/properties');
    if (res.data?.data) {
      properties.value = res.data.data;
    }
  } catch (err) {
    console.error('Error loading properties', err);
  }
};

onMounted(() => {
  if (route.query.search) {
    filters.search = route.query.search;
  }
  if (route.query.status) {
    filters.status = route.query.status;
  }
  if (route.query.type) {
    filters.type = route.query.type;
  }
  fetchProperties();
});

watch(() => route.query, (newQ) => {
  if (newQ.search) filters.search = newQ.search;
  if (newQ.status) filters.status = newQ.status;
  if (newQ.type) filters.type = newQ.type;
});
</script>
