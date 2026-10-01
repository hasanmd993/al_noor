<template>
  <div class="space-y-6 font-['Public_Sans',sans-serif]">
    <!-- Top Welcome Banner -->
    <div class="bg-gradient-to-r from-[#696cff] to-[#8592a3] text-white rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="space-y-2 text-center md:text-left">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider">
          <i class="bx bx-award"></i> Executive Overview
        </span>
        <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Welcome Admin!</h1>
        <p class="text-white/80 text-sm max-w-xl">
          Track high-yield luxury real estate projects across Dhaka, manage landowner joint venture leads, and oversee client inquiries in real-time.
        </p>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0 flex-wrap">
        <router-link 
          to="/admin/properties/create" 
          class="px-5 py-2.5 bg-white text-[#696cff] hover:bg-slate-50 font-bold text-xs rounded-xl shadow-md transition-transform hover:scale-105 flex items-center gap-2"
        >
          <i class="bx bx-plus-circle text-base"></i> Add New Project
        </router-link>
        <router-link 
          to="/admin/inquiries" 
          class="px-5 py-2.5 bg-slate-900/30 hover:bg-slate-900/40 text-white font-bold text-xs rounded-xl backdrop-blur transition-all flex items-center gap-2"
        >
          <i class="bx bx-envelope text-base"></i> View Inquiries
        </router-link>
      </div>
    </div>

    <!-- Sneat 4 Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <!-- Card 1 -->
      <div class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
          <div class="w-11 h-11 rounded-xl bg-indigo-50 text-[#696cff] flex items-center justify-center text-2xl">
            <i class="bx bx-building-house"></i>
          </div>
          <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+100% Active</span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Projects</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ stats.total_properties || 0 }}</h3>
        <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
          <span class="text-[#696cff] font-semibold">{{ stats.ongoing_properties || 0 }} Ongoing</span> · {{ stats.completed_properties || 0 }} Ready
        </p>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
          <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl">
            <i class="bx bx-envelope"></i>
          </div>
          <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
            {{ stats.new_inquiries || 0 }} New
          </span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Leads & Inquiries</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ stats.total_inquiries || 0 }}</h3>
        <p class="text-[11px] text-slate-500 mt-1">From VIP tours, Landowners & Contact forms</p>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
          <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
            <i class="bx bx-map-pin"></i>
          </div>
          <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Dhaka Prime</span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Prime Locations</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ stats.locations_count || 0 }}</h3>
        <p class="text-[11px] text-slate-500 mt-1">Gulshan, Banani, Dhanmondi, Bashundhara...</p>
      </div>

      <!-- Card 4 -->
      <div class="bg-white rounded-2xl p-5 border border-[#e7e7e8] shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
          <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl">
            <i class="bx bx-news"></i>
          </div>
          <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-full">Published</span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Journal & Insights</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ stats.blogs_count || 0 }}</h3>
        <p class="text-[11px] text-slate-500 mt-1">{{ stats.testimonials_count || 0 }} Client Testimonials</p>
      </div>
    </div>

    <!-- 2 Column Analytics & Data -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Recent Inquiries (2 Columns) -->
      <div class="lg:col-span-2 bg-white rounded-2xl border border-[#e7e7e8] shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#e7e7e8] flex items-center justify-between">
          <div>
            <h3 class="text-base font-bold text-slate-800">Recent Inquiries & VIP Bookings</h3>
            <p class="text-xs text-slate-400">Latest potential clients requesting tours or joint venture proposals</p>
          </div>
          <router-link to="/admin/inquiries" class="text-xs font-bold text-[#696cff] hover:underline flex items-center gap-1">
            View All <i class="bx bx-chevron-right"></i>
          </router-link>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider">
              <tr>
                <th class="px-6 py-3">Client</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Interest / Subject</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-6 py-3 text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
              <tr v-for="inq in recentInquiries" :key="inq.id" class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-3.5">
                  <div class="font-bold text-slate-800">{{ inq.name }}</div>
                  <div class="text-[11px] text-slate-400">{{ inq.email }}</div>
                </td>
                <td class="px-4 py-3.5">
                  <span 
                    :class="[
                      'px-2.5 py-1 rounded-full text-[10px] font-bold',
                      inq.source === 'landowner' ? 'bg-amber-100 text-amber-800' :
                      inq.source === 'property_inquiry' ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-700'
                    ]"
                  >
                    {{ inq.source === 'landowner' ? 'Landowner JV' : inq.source === 'property_inquiry' ? 'VIP Tour' : 'General' }}
                  </span>
                </td>
                <td class="px-4 py-3.5">
                  <div class="font-medium text-slate-700 truncate max-w-[180px]">{{ inq.property_interest || inq.subject }}</div>
                  <div class="text-[10px] text-slate-400 truncate max-w-[180px]">{{ inq.message }}</div>
                </td>
                <td class="px-4 py-3.5">
                  <span 
                    :class="[
                      'px-2 py-0.5 rounded-full text-[10px] font-bold',
                      inq.status === 'new' ? 'bg-rose-100 text-rose-700' :
                      inq.status === 'contacted' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700'
                    ]"
                  >
                    {{ inq.status ? inq.status.toUpperCase() : 'NEW' }}
                  </span>
                </td>
                <td class="px-6 py-3.5 text-right">
                  <router-link to="/admin/inquiries" class="p-1 text-slate-400 hover:text-[#696cff]">
                    <i class="bx bx-show text-base"></i>
                  </router-link>
                </td>
              </tr>
              <tr v-if="recentInquiries.length === 0">
                <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                  No inquiries received yet.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick Project Inventory Status (1 Column) -->
      <div class="bg-white rounded-2xl border border-[#e7e7e8] shadow-sm p-6 space-y-5">
        <div>
          <h3 class="text-base font-bold text-slate-800">Featured Landmarks</h3>
          <p class="text-xs text-slate-400">Signature projects live on website</p>
        </div>

        <div class="space-y-4">
          <div v-for="prop in recentProperties" :key="prop.id" class="flex items-center gap-3.5 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
            <img :src="prop.featured_image || '/images/logo.jpeg'" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 shadow-sm" />
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-bold text-slate-800 truncate">{{ prop.name }}</h4>
              <p class="text-[11px] text-slate-400 truncate">{{ prop.location ? prop.location.name : 'Dhaka' }} · {{ prop.price_label }}</p>
              <div class="w-full bg-slate-100 h-1.5 rounded-full mt-1.5 overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" :style="{ width: (prop.progress_percentage || 0) + '%' }"></div>
              </div>
            </div>
            <router-link :to="`/admin/properties/${prop.id}/edit`" class="p-2 text-slate-400 hover:text-[#696cff]">
              <i class="bx bx-edit text-base"></i>
            </router-link>
          </div>
        </div>

        <router-link 
          to="/admin/properties" 
          class="block text-center w-full py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl transition-colors border border-slate-200"
        >
          Manage All Projects
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref({});
const recentInquiries = ref([]);
const recentProperties = ref([]);

const loadData = async () => {
  try {
    const res = await axios.get('/api/admin/dashboard-stats');
    if (res.data && res.data.success) {
      stats.value = res.data.stats || {};
      recentInquiries.value = res.data.recent_inquiries || [];
      recentProperties.value = res.data.recent_properties || [];
    }
  } catch (err) {
    console.error('Failed to load dashboard stats:', err);
  }
};

onMounted(() => {
  loadData();
});
</script>
