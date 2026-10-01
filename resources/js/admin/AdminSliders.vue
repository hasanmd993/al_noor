<template>
  <div class="space-y-6 w-full" @click="closeDropdowns">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Hero Banners & Sliders</h1>
        <p class="text-xs text-slate-400">Manage high-impact hero slides displayed on the homepage</p>
      </div>
      <button @click="openCreate" class="px-4 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer self-start sm:self-auto">
        <i class="bx bx-plus"></i> Add Slide
      </button>
    </div>

    <!-- Full Width List -->
    <div class="space-y-4 w-full">
      <div v-for="s in sliders" :key="s.id" class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm flex flex-col md:flex-row items-center gap-5 justify-between w-full">
        <div class="flex items-center gap-4 w-full md:w-auto flex-1 min-w-0">
          <img :src="s.image" class="w-28 h-18 rounded-xl object-cover shadow-sm flex-shrink-0 border border-slate-100" />
          <div class="space-y-1 min-w-0 flex-1">
            <h4 class="font-bold text-slate-800 text-sm truncate">{{ s.title }}</h4>
            <p class="text-xs text-slate-500 truncate max-w-2xl">{{ s.subtitle }}</p>
            <div class="flex items-center gap-2 text-[11px] text-[#696cff]">
              <i class="bx bx-link"></i> CTA: {{ s.cta_text }} ({{ s.cta_link }})
            </div>
          </div>
        </div>
        <div class="flex items-center gap-3 self-end md:self-auto relative flex-shrink-0">
          <span :class="[s.is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400', 'px-3 py-1 rounded-full text-[10px] font-bold']">
            {{ s.is_active ? 'Active' : 'Hidden' }}
          </span>

          <div class="inline-block text-left">
            <button 
              @click.stop="toggleDropdown(s.id)" 
              class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100"
            >
              <i class="bx bx-dots-vertical-rounded text-lg"></i>
            </button>

            <div 
              v-if="activeDropdown === s.id" 
              class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
            >
              <button 
                @click="openEdit(s)" 
                class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff] w-full"
              >
                <i class="bx bx-edit text-sm"></i> Edit
              </button>
              <div class="border-t border-slate-100 my-1"></div>
              <button 
                @click="deleteSlider(s.id)" 
                class="flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full font-medium"
              >
                <i class="bx bx-trash text-sm"></i> Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-800">{{ editingId ? 'Edit Slide' : 'Add Slide' }}</h3>
        <form @submit.prevent="saveSlider" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 mb-1">Headline Title *</label>
            <input v-model="modalForm.title" required type="text" placeholder="e.g. Sculpting Dhaka's Most Prestigious Skyline" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Subtitle</label>
            <input v-model="modalForm.subtitle" type="text" placeholder="e.g. Ultra-luxury residential & commercial sanctuaries" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <AdminMediaUploader v-model="modalForm.image" label="Hero Banner Image *" />
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block font-bold text-slate-700 mb-1">CTA Button Text</label>
              <input v-model="modalForm.cta_text" type="text" placeholder="Explore Projects" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
            <div>
              <label class="block font-bold text-slate-700 mb-1">CTA Link</label>
              <input v-model="modalForm.cta_link" type="text" placeholder="/properties" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
          </div>
          <div class="flex items-center gap-2">
            <input type="checkbox" v-model="modalForm.is_active" id="sliderActiveToggle" class="w-4 h-4 text-[#696cff] rounded" />
            <label for="sliderActiveToggle" class="font-bold text-slate-700 cursor-pointer">Active on Homepage</label>
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-[#696cff] text-white rounded-xl font-bold">Save Banner</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminMediaUploader from './AdminMediaUploader.vue';
import axios from 'axios';

const sliders = ref([]);
const showModal = ref(false);
const editingId = ref(null);
const activeDropdown = ref(null);
const modalForm = ref({ title: '', subtitle: '', image: '', cta_text: 'Explore Portfolio', cta_link: '/properties', is_active: true, sort_order: 0 });

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadSliders = async () => {
  try {
    const res = await axios.get('/api/admin/sliders');
    sliders.value = res.data.data || [];
  } catch (err) {
    console.error(err);
  }
};

const openCreate = () => {
  editingId.value = null;
  modalForm.value = { title: '', subtitle: '', image: '', cta_text: 'Explore Portfolio', cta_link: '/properties', is_active: true, sort_order: 0 };
  showModal.value = true;
};

const openEdit = (s) => {
  editingId.value = s.id;
  modalForm.value = { ...s };
  activeDropdown.value = null;
  showModal.value = true;
};

const saveSlider = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/admin/sliders/${editingId.value}`, modalForm.value);
    } else {
      await axios.post('/api/admin/sliders', modalForm.value);
    }
    showModal.value = false;
    loadSliders();
  } catch (err) {
    alert('Failed to save slide.');
  }
};

const deleteSlider = async (id) => {
  if (!confirm('Are you sure?')) return;
  try {
    await axios.delete(`/api/admin/sliders/${id}`);
    loadSliders();
  } catch (err) {
    alert('Failed to delete slider.');
  }
};

onMounted(() => {
  loadSliders();
});
</script>
