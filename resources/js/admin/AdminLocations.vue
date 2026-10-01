<template>
  <div class="space-y-6 w-full" @click="closeDropdowns">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Dhaka Prime Locations</h1>
        <p class="text-xs text-slate-400">Manage high-growth strategic hubs across Dhaka (Gulshan, Banani, Dhanmondi, etc.)</p>
      </div>
      <button @click="openCreate" class="px-4 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer self-start sm:self-auto">
        <i class="bx bx-plus"></i> Add Location
      </button>
    </div>

    <!-- Table Card Full Width -->
    <div class="bg-white rounded-2xl border border-[#e7e7e8] shadow-sm w-full overflow-hidden">
      <div class="overflow-x-auto w-full min-h-[300px]">
        <table class="w-full text-left text-xs min-w-full">
          <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-[#e7e7e8]">
            <tr>
              <th class="px-6 py-3.5">Location Name</th>
              <th class="px-6 py-3.5">City</th>
              <th class="px-6 py-3.5">Coordinates (Lat, Lng)</th>
              <th class="px-6 py-3.5 text-center">Projects</th>
              <th class="px-6 py-3.5">Status</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-600">
            <tr v-for="loc in locations" :key="loc.id" class="hover:bg-slate-50/80 transition-colors">
              <td class="px-6 py-4 font-bold text-slate-800 text-sm whitespace-nowrap">{{ loc.name }}</td>
              <td class="px-6 py-4 text-slate-600 font-medium whitespace-nowrap">{{ loc.city || 'Dhaka' }}</td>
              <td class="px-6 py-4 text-slate-400 font-mono whitespace-nowrap">{{ loc.latitude }}, {{ loc.longitude }}</td>
              <td class="px-6 py-4 text-center whitespace-nowrap">
                <span class="px-3 py-1 bg-indigo-50 text-[#696cff] font-bold rounded-full text-[10px]">
                  {{ loc.properties_count || 0 }} Projects
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[loc.is_active ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 bg-slate-100', 'px-2.5 py-1 rounded-full font-bold text-[10px]']">
                  {{ loc.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 text-right relative whitespace-nowrap">
                <div class="inline-block text-left">
                  <button 
                    @click.stop="toggleDropdown(loc.id)" 
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                  >
                    <i class="bx bx-dots-vertical-rounded text-lg"></i>
                  </button>

                  <div 
                    v-if="activeDropdown === loc.id" 
                    class="absolute right-6 mt-1 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
                  >
                    <button 
                      @click="openEdit(loc)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff] w-full"
                    >
                      <i class="bx bx-edit text-sm"></i> Edit
                    </button>
                    <div class="border-t border-slate-100 my-1"></div>
                    <button 
                      @click="deleteLoc(loc.id)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full font-medium"
                    >
                      <i class="bx bx-trash text-sm"></i> Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-800">{{ editingId ? 'Edit Location' : 'Add New Location' }}</h3>
        <form @submit.prevent="saveLocation" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 mb-1">Location Name *</label>
            <input v-model="modalForm.name" required type="text" placeholder="e.g. Gulshan-2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block font-bold text-slate-700 mb-1">Latitude</label>
              <input v-model="modalForm.latitude" type="number" step="0.0001" placeholder="23.7925" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
            <div>
              <label class="block font-bold text-slate-700 mb-1">Longitude</label>
              <input v-model="modalForm.longitude" type="number" step="0.0001" placeholder="90.4078" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
          </div>
          <div class="flex items-center gap-2">
            <input type="checkbox" v-model="modalForm.is_active" id="activeToggle" class="w-4 h-4 text-[#696cff] rounded" />
            <label for="activeToggle" class="font-bold text-slate-700 cursor-pointer">Active on Maps & Website</label>
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-[#696cff] text-white rounded-xl font-bold">Save Location</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const locations = ref([]);
const showModal = ref(false);
const editingId = ref(null);
const activeDropdown = ref(null);
const modalForm = ref({ name: '', city: 'Dhaka', latitude: 23.7925, longitude: 90.4078, is_active: true });

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadLocations = async () => {
  try {
    const res = await axios.get('/api/admin/locations');
    locations.value = res.data.data || [];
  } catch (err) {
    console.error(err);
  }
};

const openCreate = () => {
  editingId.value = null;
  modalForm.value = { name: '', city: 'Dhaka', latitude: 23.7925, longitude: 90.4078, is_active: true };
  showModal.value = true;
};

const openEdit = (loc) => {
  editingId.value = loc.id;
  modalForm.value = { ...loc };
  activeDropdown.value = null;
  showModal.value = true;
};

const saveLocation = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/admin/locations/${editingId.value}`, modalForm.value);
    } else {
      await axios.post('/api/admin/locations', modalForm.value);
    }
    showModal.value = false;
    loadLocations();
  } catch (err) {
    alert('Failed to save location.');
  }
};

const deleteLoc = async (id) => {
  if (!confirm('Are you sure?')) return;
  try {
    await axios.delete(`/api/admin/locations/${id}`);
    loadLocations();
  } catch (err) {
    alert('Failed to delete location.');
  }
};

onMounted(() => {
  loadLocations();
});
</script>
