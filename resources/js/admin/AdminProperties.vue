<template>
  <div class="space-y-6" @click="closeDropdowns">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Projects & Inventory</h1>
        <p class="text-xs text-slate-400">Manage Dhaka real estate developments, progress, pricing, and units</p>
      </div>
      <router-link 
        to="/admin/properties/create" 
        class="px-4 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-md shadow-[#696cff]/20 flex items-center gap-2 transition-all self-start sm:self-auto cursor-pointer"
      >
        <i class="bx bx-plus"></i> Add New Landmark
      </router-link>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl p-4 border border-[#e7e7e8] shadow-sm flex flex-wrap gap-4 items-center justify-between">
      <div class="flex flex-wrap items-center gap-3 flex-1 min-w-[280px]">
        <div class="relative flex-1 sm:max-w-xs">
          <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input 
            v-model="searchQuery" 
            type="text" 
            placeholder="Search by title, address..." 
            class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-700"
          />
        </div>

        <select v-model="statusFilter" class="px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none text-slate-700">
          <option value="">All Statuses</option>
          <option value="ongoing">Ongoing</option>
          <option value="completed">Completed / Ready</option>
          <option value="upcoming">Upcoming</option>
        </select>

        <select v-model="categoryFilter" class="px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl outline-none text-slate-700">
          <option value="">All Categories</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
        </select>
      </div>

      <div class="text-xs font-semibold text-slate-400">
        Showing {{ filteredProperties.length }} of {{ properties.length }} projects
      </div>
    </div>

    <!-- Projects Table -->
    <div class="bg-white rounded-2xl border border-[#e7e7e8] shadow-sm">
      <div class="overflow-x-auto min-h-[300px]">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-[#e7e7e8]">
            <tr>
              <th class="px-6 py-3.5">Project</th>
              <th class="px-4 py-3.5">Category / Location</th>
              <th class="px-4 py-3.5">Status</th>
              <th class="px-4 py-3.5">Progress</th>
              <th class="px-4 py-3.5">Price Guide</th>
              <th class="px-4 py-3.5 text-center">Featured</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-600">
            <tr v-for="prop in filteredProperties" :key="prop.id" class="hover:bg-slate-50/80 transition-colors">
              <td class="px-6 py-3.5">
                <div class="flex items-center gap-3">
                  <img :src="prop.featured_image || '/images/logo.jpeg'" class="w-11 h-11 rounded-xl object-cover flex-shrink-0 shadow-sm border border-slate-100" />
                  <div>
                    <div class="font-bold text-slate-800 text-sm">{{ prop.name }}</div>
                    <div class="text-[11px] text-slate-400 truncate max-w-[200px]">{{ prop.address }}</div>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3.5">
                <div class="font-medium text-slate-700">{{ prop.category ? prop.category.name : 'N/A' }}</div>
                <div class="text-[11px] text-indigo-500 flex items-center gap-1 mt-0.5">
                  <i class="bx bx-map-pin"></i> {{ prop.location ? prop.location.name : 'Dhaka' }}
                </div>
              </td>
              <td class="px-4 py-3.5">
                <span 
                  :class="[
                    'px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider',
                    prop.status === 'completed' ? 'bg-emerald-100 text-emerald-800' :
                    prop.status === 'ongoing' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800'
                  ]"
                >
                  {{ prop.status }}
                </span>
              </td>
              <td class="px-4 py-3.5">
                <div class="w-28">
                  <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                    <span>{{ prop.progress_percentage || 0 }}%</span>
                  </div>
                  <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-full rounded-full" :style="{ width: (prop.progress_percentage || 0) + '%' }"></div>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3.5 font-bold text-slate-800">
                {{ prop.price_label || 'Price on request' }}
              </td>
              <td class="px-4 py-3.5 text-center">
                <i :class="[prop.is_featured ? 'bx bxs-star text-amber-500' : 'bx bx-star text-slate-300', 'text-lg']"></i>
              </td>
              <td class="px-6 py-3.5 text-right relative">
                <div class="inline-block text-left">
                  <button 
                    @click.stop="toggleDropdown(prop.id)" 
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                  >
                    <i class="bx bx-dots-vertical-rounded text-lg"></i>
                  </button>

                  <div 
                    v-if="activeDropdown === prop.id" 
                    class="absolute right-6 mt-1 w-40 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
                  >
                    <router-link 
                      :to="`/properties/${prop.id}`" 
                      target="_blank" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-indigo-600"
                    >
                      <i class="bx bx-link-external text-sm"></i> View Public
                    </router-link>
                    <router-link 
                      :to="`/admin/properties/${prop.id}/edit`" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff]"
                    >
                      <i class="bx bx-edit text-sm"></i> Edit Project
                    </router-link>
                    <div class="border-t border-slate-100 my-1"></div>
                    <button 
                      @click="deleteProperty(prop.id)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full font-medium"
                    >
                      <i class="bx bx-trash text-sm"></i> Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="filteredProperties.length === 0">
              <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                No projects found matching the criteria.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const properties = ref([]);
const categories = ref([]);
const searchQuery = ref('');
const statusFilter = ref('');
const categoryFilter = ref('');
const activeDropdown = ref(null);

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadData = async () => {
  try {
    const [pRes, cRes] = await Promise.all([
      axios.get('/api/admin/properties'),
      axios.get('/api/admin/categories')
    ]);
    properties.value = pRes.data.data || [];
    categories.value = cRes.data.data || [];
  } catch (err) {
    console.error('Error loading properties:', err);
  }
};

const filteredProperties = computed(() => {
  return properties.value.filter(p => {
    const matchQuery = !searchQuery.value || 
      p.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      p.address.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchStatus = !statusFilter.value || p.status === statusFilter.value;
    const matchCat = !categoryFilter.value || p.category_id === Number(categoryFilter.value);
    return matchQuery && matchStatus && matchCat;
  });
});

const deleteProperty = async (id) => {
  if (!confirm('Are you sure you want to delete this property?')) return;
  try {
    await axios.delete(`/api/admin/properties/${id}`);
    properties.value = properties.value.filter(p => p.id !== id);
  } catch (err) {
    alert('Failed to delete property.');
  }
};

onMounted(() => {
  loadData();
});
</script>
