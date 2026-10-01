<template>
  <div class="space-y-6 w-full">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">{{ isEdit ? 'Edit Landmark Project' : 'Create New Luxury Landmark' }}</h1>
        <p class="text-xs text-slate-400">{{ isEdit ? 'Update architectural specifications, pricing, and media' : 'Fill in project details to publish to Al-Noor website' }}</p>
      </div>
      <router-link to="/admin/properties" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl flex items-center gap-1.5 transition-colors">
        <i class="bx bx-arrow-back"></i> Back to Projects
      </router-link>
    </div>

    <!-- Alert -->
    <div v-if="successMsg" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
      <i class="bx bx-check-circle text-lg"></i> {{ successMsg }}
    </div>

    <!-- Main Form -->
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Section 1: Basic Information -->
      <div class="bg-white rounded-2xl p-6 border border-[#e7e7e8] shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">1. Core Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Project Name *</label>
            <input v-model="form.name" required type="text" placeholder="e.g. Al-Noor Crown Palace" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Full Address *</label>
            <input v-model="form.address" required type="text" placeholder="e.g. Plot 14, Road 84, Gulshan-2, Dhaka" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Prime Location *</label>
            <select v-model="form.location_id" required class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800">
              <option disabled value="">Select Location</option>
              <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Category *</label>
            <select v-model="form.category_id" required class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800">
              <option disabled value="">Select Category</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Construction Status *</label>
            <select v-model="form.status" required class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800">
              <option value="ongoing">Ongoing Construction</option>
              <option value="completed">Completed / Ready</option>
              <option value="upcoming">Upcoming Launch</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Property Type *</label>
            <select v-model="form.type" required class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800">
              <option value="residential">Luxury Residential</option>
              <option value="commercial">Commercial Landmark</option>
              <option value="mixed">Mixed-Use Complex</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Section 2: Financial & Structural Specs -->
      <div class="bg-white rounded-2xl p-6 border border-[#e7e7e8] shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">2. Pricing & Structural Specifications</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Price Display Guide</label>
            <input v-model="form.price_label" type="text" placeholder="e.g. Starting from BDT 4.85 Cr" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Price Starting Numeric (BDT)</label>
            <input v-model="form.price_from" type="number" step="1000" placeholder="48500000" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Land Area (Katha)</label>
            <input v-model="form.land_area" type="number" step="0.1" placeholder="10.5" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Floors</label>
            <input v-model="form.total_floors" type="number" placeholder="18" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Units Per Floor</label>
            <input v-model="form.apartments_per_floor" type="number" placeholder="2" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Construction Progress (%)</label>
            <input v-model="form.progress_percentage" type="number" min="0" max="100" placeholder="65" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>
        </div>
      </div>

      <!-- Section 3: Media & Descriptions -->
      <div class="bg-white rounded-2xl p-6 border border-[#e7e7e8] shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">3. Media & Overview</h3>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Featured Image URL</label>
            <div class="flex gap-3">
              <input v-model="form.featured_image" type="text" placeholder="https://images.unsplash.com/..." class="flex-1 px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
              <img v-if="form.featured_image" :src="form.featured_image" class="w-11 h-11 rounded-xl object-cover border border-slate-200 shadow-sm" />
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Virtual Tour / Video URL (YouTube/Vimeo)</label>
            <input v-model="form.video_url" type="text" placeholder="https://youtube.com/..." class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Short Highlights</label>
            <textarea v-model="form.short_description" rows="2" placeholder="Brief 1-2 sentence highlight for property cards" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800"></textarea>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Detailed Architectural Overview</label>
            <textarea v-model="form.description" rows="4" placeholder="Full comprehensive description of the landmark and amenities" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800"></textarea>
          </div>
        </div>
      </div>

      <!-- Section 4: Visibility Controls -->
      <div class="bg-white rounded-2xl p-6 border border-[#e7e7e8] shadow-sm flex flex-wrap gap-6 items-center justify-between">
        <div class="flex items-center gap-6">
          <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
            <input type="checkbox" v-model="form.is_featured" class="w-4 h-4 rounded text-[#696cff] focus:ring-[#696cff]" />
            <span>Show in Signature Collection</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
            <input type="checkbox" v-model="form.is_published" class="w-4 h-4 rounded text-[#696cff] focus:ring-[#696cff]" />
            <span>Published on Website</span>
          </label>
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="px-6 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-lg shadow-[#696cff]/20 transition-all flex items-center gap-2 cursor-pointer"
        >
          <i v-if="loading" class="bx bx-loader-alt animate-spin text-base"></i>
          <span>{{ loading ? 'Saving...' : (isEdit ? 'Update Project' : 'Publish Project') }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const isEdit = ref(false);
const loading = ref(false);
const successMsg = ref('');
const locations = ref([]);
const categories = ref([]);

const form = ref({
  name: '',
  location_id: '',
  category_id: '',
  address: '',
  status: 'ongoing',
  type: 'residential',
  price_label: '',
  price_from: '',
  land_area: '',
  total_floors: '',
  apartments_per_floor: '',
  progress_percentage: 0,
  featured_image: '',
  video_url: '',
  short_description: '',
  description: '',
  is_featured: true,
  is_published: true,
  sort_order: 0,
});

const loadInitial = async () => {
  try {
    const [lRes, cRes] = await Promise.all([
      axios.get('/api/admin/locations'),
      axios.get('/api/admin/categories')
    ]);
    locations.value = lRes.data.data || [];
    categories.value = cRes.data.data || [];

    if (route.params.id) {
      isEdit.value = true;
      const propRes = await axios.get(`/api/properties/${route.params.id}`);
      if (propRes.data && propRes.data.data) {
        Object.assign(form.value, propRes.data.data);
      }
    }
  } catch (err) {
    console.error('Failed to load project details:', err);
  }
};

const handleSubmit = async () => {
  loading.value = true;
  successMsg.value = '';
  try {
    if (isEdit.value) {
      await axios.put(`/api/admin/properties/${route.params.id}`, form.value);
      successMsg.value = 'Property updated successfully!';
    } else {
      const res = await axios.post('/api/admin/properties', form.value);
      successMsg.value = 'Property created successfully!';
      setTimeout(() => router.push('/admin/properties'), 1000);
    }
  } catch (err) {
    alert(err.response?.data?.message || 'Error saving property.');
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  loadInitial();
});
</script>
