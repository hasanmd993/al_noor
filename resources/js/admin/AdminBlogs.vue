<template>
  <div class="space-y-6" @click="closeDropdowns">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Real Estate Journal & Market Insights</h1>
        <p class="text-xs text-slate-400">Publish architectural editorials, market trends, and investment advice</p>
      </div>
      <button @click="openCreate" class="px-4 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer">
        <i class="bx bx-plus"></i> Publish Article
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-[#e7e7e8] shadow-sm">
      <div class="overflow-x-auto min-h-[300px]">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-[#e7e7e8]">
            <tr>
              <th class="px-6 py-3.5">Article Headline</th>
              <th class="px-4 py-3.5">Category</th>
              <th class="px-4 py-3.5">Author</th>
              <th class="px-4 py-3.5">Views</th>
              <th class="px-4 py-3.5">Published Date</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-600">
            <tr v-for="b in blogs" :key="b.id" class="hover:bg-slate-50/80 transition-colors">
              <td class="px-6 py-3.5">
                <div class="flex items-center gap-3">
                  <img :src="b.featured_image || '/images/logo.jpeg'" class="w-10 h-10 rounded-lg object-cover flex-shrink-0" />
                  <div>
                    <div class="font-bold text-slate-800 text-sm">{{ b.title }}</div>
                    <div class="text-[11px] text-slate-400 truncate max-w-sm">{{ b.excerpt }}</div>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3.5">
                <span class="px-2.5 py-1 bg-purple-50 text-purple-600 font-bold rounded-full text-[10px]">
                  {{ b.category }}
                </span>
              </td>
              <td class="px-4 py-3.5 text-slate-700 font-medium">{{ b.author }}</td>
              <td class="px-4 py-3.5 font-bold text-slate-700">{{ b.views || 0 }}</td>
              <td class="px-4 py-3.5 text-slate-500">{{ new Date(b.published_at).toLocaleDateString() }}</td>
              <td class="px-6 py-3.5 text-right relative">
                <div class="inline-block text-left">
                  <button 
                    @click.stop="toggleDropdown(b.id)" 
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                  >
                    <i class="bx bx-dots-vertical-rounded text-lg"></i>
                  </button>

                  <div 
                    v-if="activeDropdown === b.id" 
                    class="absolute right-6 mt-1 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
                  >
                    <router-link 
                      :to="`/journal/${b.id}`" 
                      target="_blank" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-indigo-600"
                    >
                      <i class="bx bx-link-external text-sm"></i> View Article
                    </router-link>
                    <button 
                      @click="openEdit(b)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff] w-full"
                    >
                      <i class="bx bx-edit text-sm"></i> Edit
                    </button>
                    <div class="border-t border-slate-100 my-1"></div>
                    <button 
                      @click="deleteBlog(b.id)" 
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
      <div class="bg-white rounded-2xl max-w-2xl w-full p-6 space-y-4 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-base font-bold text-slate-800">{{ editingId ? 'Edit Article' : 'Publish Article' }}</h3>
        <form @submit.prevent="saveBlog" class="space-y-4 text-xs">
          <div>
            <label class="block font-bold text-slate-700 mb-1">Headline Title *</label>
            <input v-model="modalForm.title" required type="text" placeholder="e.g. Navigating Luxury Real Estate in Dhaka" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block font-bold text-slate-700 mb-1">Category</label>
              <input v-model="modalForm.category" type="text" placeholder="Market Insights, Architecture..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
            <div>
              <label class="block font-bold text-slate-700 mb-1">Author Name</label>
              <input v-model="modalForm.author" type="text" placeholder="Al-Noor Editorial Team" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
            </div>
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Cover Image URL</label>
            <input v-model="modalForm.featured_image" type="text" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]" />
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Excerpt Summary</label>
            <textarea v-model="modalForm.excerpt" rows="2" placeholder="Summary..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]"></textarea>
          </div>
          <div>
            <label class="block font-bold text-slate-700 mb-1">Article Body Content *</label>
            <textarea v-model="modalForm.content" rows="6" required placeholder="Full article body content..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff]"></textarea>
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-[#696cff] text-white rounded-xl font-bold">Save Article</button>
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

const blogs = ref([]);
const showModal = ref(false);
const editingId = ref(null);
const activeDropdown = ref(null);
const modalForm = ref({ title: '', category: 'Market Insights', author: 'Al-Noor Properties BD', featured_image: '', excerpt: '', content: '', is_published: true });

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadBlogs = async () => {
  try {
    const res = await axios.get('/api/admin/blogs');
    blogs.value = res.data.data || [];
  } catch (err) {
    console.error(err);
  }
};

const openCreate = () => {
  editingId.value = null;
  modalForm.value = { title: '', category: 'Market Insights', author: 'Al-Noor Properties BD', featured_image: '', excerpt: '', content: '', is_published: true, published_at: new Date().toISOString() };
  showModal.value = true;
};

const openEdit = (b) => {
  editingId.value = b.id;
  modalForm.value = { ...b };
  activeDropdown.value = null;
  showModal.value = true;
};

const saveBlog = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/admin/blogs/${editingId.value}`, modalForm.value);
    } else {
      await axios.post('/api/admin/blogs', modalForm.value);
    }
    showModal.value = false;
    loadBlogs();
  } catch (err) {
    alert('Failed to save article.');
  }
};

const deleteBlog = async (id) => {
  if (!confirm('Are you sure?')) return;
  try {
    await axios.delete(`/api/admin/blogs/${id}`);
    loadBlogs();
  } catch (err) {
    alert('Failed to delete blog.');
  }
};

onMounted(() => {
  loadBlogs();
});
</script>
