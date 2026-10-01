<template>
  <div class="space-y-6 w-full" @click="closeDropdowns">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Client Testimonials</h1>
        <p class="text-xs text-slate-400">Manage landowner & homeowner reviews displayed on the website</p>
      </div>
      <button @click="openCreate" class="px-4 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer">
        <i class="bx bx-plus"></i> Add Testimonial
      </button>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div v-for="t in testimonials" :key="t.id" class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm flex flex-col justify-between space-y-4">
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <img :src="t.client_photo || '/images/logo.jpeg'" class="w-10 h-10 rounded-full object-cover border border-amber-500/30" />
              <div>
                <h4 class="font-bold text-slate-800 text-sm">{{ t.client_name }}</h4>
                <p class="text-[11px] text-slate-400">{{ t.client_designation }}</p>
              </div>
            </div>
            <div class="text-amber-400 text-sm">
              <span v-for="star in (t.rating || 5)" :key="star">★</span>
            </div>
          </div>
          <p class="text-xs text-slate-600 italic bg-slate-50 p-3 rounded-xl border border-slate-100">
            "{{ t.quote }}"
          </p>
        </div>

        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs text-slate-400 relative">
          <span>Project: <strong class="text-slate-700">{{ t.project_name || 'Al-Noor Development' }}</strong></span>
          <div class="inline-block text-left">
            <button 
              @click.stop="toggleDropdown(t.id)" 
              class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100"
            >
              <i class="bx bx-dots-vertical-rounded text-lg"></i>
            </button>

            <div 
              v-if="activeDropdown === t.id" 
              class="absolute right-0 bottom-8 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
            >
              <button 
                @click="openEdit(t)" 
                class="flex items-center gap-2 px-3.5 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff] w-full"
              >
                <i class="bx bx-edit text-sm"></i> Edit
              </button>
              <div class="border-t border-slate-100 my-1"></div>
              <button 
                @click="deleteTestimonial(t.id)" 
                class="flex items-center gap-2 px-3.5 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full font-medium"
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
        <h3 class="text-base font-bold text-slate-800">{{ editingId ? 'Edit Testimonial' : 'Add Testimonial' }}</h3>
        <form @submit.prevent="saveTestimonial" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 mb-1">Client Name *</label>
            <input v-model="modalForm.client_name" required type="text" placeholder="e.g. Dr. Kazi Shafiul Alam" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Designation / Role</label>
            <input v-model="modalForm.client_designation" type="text" placeholder="e.g. Resident, Crown Palace Gulshan" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Project Name</label>
            <input v-model="modalForm.project_name" type="text" placeholder="e.g. Al-Noor Crown Palace" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Quote / Review *</label>
            <textarea v-model="modalForm.quote" rows="3" required placeholder="Client feedback..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]"></textarea>
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Client Photo URL</label>
            <input v-model="modalForm.client_photo" type="text" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-[#696cff] text-white rounded-xl font-bold">Save Testimonial</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const testimonials = ref([]);
const showModal = ref(false);
const editingId = ref(null);
const activeDropdown = ref(null);
const modalForm = ref({ client_name: '', client_designation: '', project_name: '', quote: '', client_photo: '', rating: 5, is_active: true });

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadTestimonials = async () => {
  try {
    const res = await axios.get('/api/admin/testimonials');
    testimonials.value = res.data.data || [];
  } catch (err) {
    console.error(err);
  }
};

const openCreate = () => {
  editingId.value = null;
  modalForm.value = { client_name: '', client_designation: '', project_name: '', quote: '', client_photo: '', rating: 5, is_active: true };
  showModal.value = true;
};

const openEdit = (t) => {
  editingId.value = t.id;
  modalForm.value = { ...t };
  activeDropdown.value = null;
  showModal.value = true;
};

const saveTestimonial = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/admin/testimonials/${editingId.value}`, modalForm.value);
    } else {
      await axios.post('/api/admin/testimonials', modalForm.value);
    }
    showModal.value = false;
    loadTestimonials();
  } catch (err) {
    alert('Failed to save testimonial.');
  }
};

const deleteTestimonial = async (id) => {
  if (!confirm('Are you sure?')) return;
  try {
    await axios.delete(`/api/admin/testimonials/${id}`);
    loadTestimonials();
  } catch (err) {
    alert('Failed to delete testimonial.');
  }
};

onMounted(() => {
  loadTestimonials();
});
</script>
