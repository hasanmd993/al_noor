<template>
  <!-- Admin Pages (Sneat Layout / Login) -->
  <div v-if="isAdminRoute" class="min-h-screen bg-[#f5f5f9] text-[#566a7f]">
    <router-view />
  </div>

  <!-- Public Client Website -->
  <div v-else class="min-h-screen flex flex-col bg-[#070a11] text-slate-100 selection:bg-amber-500 selection:text-slate-950">
    <!-- Luxury Sticky Navbar -->
    <Navbar @open-vip-modal="openVipModal" />

    <!-- Main Content Area -->
    <main class="flex-1">
      <router-view @open-vip-modal="openVipModal" />
    </main>

    <!-- Luxury Footer -->
    <Footer />

    <!-- Global VIP Tour / Consultation Modal -->
    <VipModal 
      :is-open="vipModalOpen" 
      :property-name="selectedPropertyName"
      @close="vipModalOpen = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import VipModal from './components/VipModal.vue';

const route = useRoute();
const isAdminRoute = computed(() => route.path.startsWith('/admin'));

const vipModalOpen = ref(false);
const selectedPropertyName = ref('');

const openVipModal = (propertyName = '') => {
  selectedPropertyName.value = typeof propertyName === 'string' ? propertyName : '';
  vipModalOpen.value = true;
};
</script>
