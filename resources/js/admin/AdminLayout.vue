<template>
  <div class="sneat-layout min-h-screen bg-[#f5f5f9] text-[#566a7f] font-['Public_Sans',sans-serif] flex">
    <!-- Sidebar -->
    <aside 
      :class="[
        'sneat-sidebar bg-white border-r border-[#e7e7e8] transition-all duration-300 z-30 flex flex-col',
        sidebarCollapsed ? 'w-20' : 'w-64',
        mobileSidebarOpen ? 'translate-x-0 fixed inset-y-0 left-0 shadow-2xl' : 'max-md:-translate-x-full max-md:fixed max-md:inset-y-0 max-md:left-0'
      ]"
    >
      <!-- Sidebar Header -->
      <div class="h-16 flex items-center justify-between px-5 border-b border-[#e7e7e8]">
        <router-link to="/admin/dashboard" class="flex items-center gap-3 overflow-hidden">
          <img src="/images/logo.jpeg" alt="Al-Noor" class="w-9 h-9 rounded-lg object-cover shadow-sm ring-1 ring-amber-500/30 flex-shrink-0" />
          <div v-if="!sidebarCollapsed" class="flex flex-col truncate">
            <span class="font-bold text-slate-800 text-sm tracking-wide leading-tight">AL-NOOR</span>
            <span class="text-[10px] text-[#696cff] font-bold uppercase tracking-wider">ADMIN PORTAL</span>
          </div>
        </router-link>
        <button 
          @click="sidebarCollapsed = !sidebarCollapsed" 
          class="hidden md:flex items-center justify-center w-7 h-7 rounded-full text-slate-400 hover:text-[#696cff] hover:bg-[#696cff]/10 transition-colors"
        >
          <i :class="sidebarCollapsed ? 'bx bx-chevron-right text-lg' : 'bx bx-chevron-left text-lg'"></i>
        </button>
      </div>

      <!-- Navigation Menu -->
      <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        <div v-if="!sidebarCollapsed" class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
          Core Dashboards
        </div>

        <router-link 
          to="/admin/dashboard" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-home-circle text-lg text-[#696cff] group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Analytics Dashboard</span>
        </router-link>

        <div v-if="!sidebarCollapsed" class="px-3 pt-4 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
          Real Estate & Inventory
        </div>

        <router-link 
          to="/admin/properties" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-building-house text-lg text-indigo-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Projects & Units</span>
        </router-link>

        <router-link 
          to="/admin/locations" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-map-pin text-lg text-rose-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Dhaka Locations</span>
        </router-link>

        <router-link 
          to="/admin/categories" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-category text-lg text-emerald-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Categories</span>
        </router-link>

        <div v-if="!sidebarCollapsed" class="px-3 pt-4 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
          CRM & Leads
        </div>

        <router-link 
          to="/admin/inquiries" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <div class="flex items-center gap-3 truncate">
            <i class="bx bx-envelope text-lg text-amber-500 group-hover:scale-110 transition-transform"></i>
            <span v-if="!sidebarCollapsed" class="truncate">Inquiries & VIP</span>
          </div>
          <span v-if="!sidebarCollapsed && newInquiriesCount > 0" class="px-2 py-0.5 text-[10px] font-bold bg-rose-500 text-white rounded-full">
            {{ newInquiriesCount }}
          </span>
        </router-link>

        <router-link 
          to="/admin/testimonials" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-star text-lg text-yellow-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Testimonials</span>
        </router-link>

        <div v-if="!sidebarCollapsed" class="px-3 pt-4 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
          Content & Settings
        </div>

        <router-link 
          to="/admin/sliders" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-slideshow text-lg text-cyan-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Hero Sliders</span>
        </router-link>

        <router-link 
          to="/admin/blogs" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-news text-lg text-purple-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Journal / Articles</span>
        </router-link>

        <router-link 
          to="/admin/settings" 
          active-class="bg-[#696cff]/10 text-[#696cff] font-semibold"
          class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-[#566a7f] hover:bg-slate-100 hover:text-slate-900 transition-colors group"
        >
          <i class="bx bx-cog text-lg text-slate-500 group-hover:scale-110 transition-transform"></i>
          <span v-if="!sidebarCollapsed" class="truncate">Site Settings</span>
        </router-link>
      </div>

      <!-- Sidebar Footer -->
      <div class="p-3 border-t border-[#e7e7e8]">
        <a 
          href="/" 
          target="_blank" 
          class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-amber-500 hover:text-white transition-colors"
        >
          <i class="bx bx-globe text-base"></i>
          <span v-if="!sidebarCollapsed">View Live Website</span>
        </a>
      </div>
    </aside>

    <!-- Mobile Backdrop -->
    <div 
      v-if="mobileSidebarOpen" 
      @click="mobileSidebarOpen = false" 
      class="fixed inset-0 bg-slate-900/50 z-20 md:hidden"
    ></div>

    <!-- Main Container -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Top Navbar -->
      <header class="h-16 bg-white/95 backdrop-blur border-b border-[#e7e7e8] sticky top-0 z-40 px-6 flex items-center justify-between shadow-sm" @click.stop>
        <div class="flex items-center gap-4">
          <button 
            @click="mobileSidebarOpen = !mobileSidebarOpen" 
            class="md:hidden flex items-center justify-center w-9 h-9 rounded-lg text-slate-600 hover:bg-slate-100"
          >
            <i class="bx bx-menu text-2xl"></i>
          </button>
          
          <div class="hidden sm:flex items-center gap-2 text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">
            <i class="bx bx-search text-lg text-slate-400"></i>
            <input 
              type="text" 
              placeholder="Quick search projects, leads..." 
              class="bg-transparent border-none outline-none text-xs text-slate-700 w-48 lg:w-72"
            />
          </div>
        </div>

        <!-- Right User Actions -->
        <div class="flex items-center gap-4">
          <router-link 
            to="/admin/inquiries" 
            class="relative p-2 text-slate-500 hover:text-[#696cff] hover:bg-[#696cff]/10 rounded-full transition-colors"
          >
            <i class="bx bx-bell text-xl"></i>
            <span v-if="newInquiriesCount > 0" class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
          </router-link>

          <!-- User Menu Dropdown -->
          <div class="relative" ref="dropdownRef">
            <button 
              @click="userMenuOpen = !userMenuOpen" 
              class="flex items-center gap-2.5 p-1 rounded-lg hover:bg-slate-100 transition-colors"
            >
              <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#696cff] to-indigo-400 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                AN
              </div>
              <div class="hidden md:flex flex-col text-left">
                <span class="text-xs font-bold text-slate-800 leading-tight">Al-Noor Admin</span>
                <span class="text-[10px] text-emerald-600 font-medium">Online (Super Admin)</span>
              </div>
              <i class="bx bx-chevron-down text-slate-400 text-sm hidden md:block"></i>
            </button>

            <!-- Dropdown Menu -->
            <div 
              v-if="userMenuOpen" 
              class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150"
            >
              <div class="px-4 py-2 border-b border-slate-100">
                <p class="text-xs font-bold text-slate-800">Al-Noor Properties BD</p>
                <p class="text-[11px] text-slate-400">admin@alnoorbd.com</p>
              </div>
              <router-link 
                to="/admin/settings" 
                @click="userMenuOpen = false"
                class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff]"
              >
                <i class="bx bx-cog text-base"></i> Portal Settings
              </router-link>
              <a 
                href="/" 
                target="_blank" 
                class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff]"
              >
                <i class="bx bx-link-external text-base"></i> Public Website
              </a>
              <div class="border-t border-slate-100 my-1"></div>
              <button 
                @click="handleLogout" 
                class="flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full text-left font-semibold"
              >
                <i class="bx bx-log-out text-base"></i> Sign Out
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Body Outlet -->
      <main class="flex-1 p-6 md:p-8 w-full">
        <router-view />
      </main>

      <!-- Footer -->
      <footer class="py-4 px-8 bg-white border-t border-[#e7e7e8] text-center text-xs text-slate-400 flex flex-col sm:flex-row justify-between items-center gap-2">
        <span>© 2026 <strong>Al-Noor Properties BD</strong>. Sneat Admin v1.0.0.</span>
        <span>Crafted for Luxury Real Estate Management</span>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const sidebarCollapsed = ref(false);
const mobileSidebarOpen = ref(false);
const userMenuOpen = ref(false);
const newInquiriesCount = ref(0);

const fetchCounts = async () => {
  try {
    const res = await axios.get('/api/admin/dashboard-stats');
    if (res.data && res.data.stats) {
      newInquiriesCount.value = res.data.stats.new_inquiries || 0;
    }
  } catch (err) {
    console.error('Failed to fetch admin stats:', err);
  }
};

const handleLogout = async () => {
  try {
    await axios.post('/api/admin/logout');
  } catch (e) {}
  localStorage.removeItem('alnoor_admin_token');
  localStorage.removeItem('alnoor_admin_user');
  router.push('/admin/login');
};

const closeDropdowns = (e) => {
  if (userMenuOpen.value) {
    userMenuOpen.value = false;
  }
};

onMounted(() => {
  fetchCounts();
  window.addEventListener('click', closeDropdowns);
});

onBeforeUnmount(() => {
  window.removeEventListener('click', closeDropdowns);
});
</script>
