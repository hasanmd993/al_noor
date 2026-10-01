<template>
  <header 
    :class="[
      'fixed top-0 left-0 right-0 z-50 transition-all duration-500',
      isScrolled ? 'bg-[#070a11]/90 backdrop-blur-md py-3 shadow-2xl border-b border-amber-500/15' : 'bg-gradient-to-b from-[#070a11]/80 via-[#070a11]/40 to-transparent py-5'
    ]"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">
        
        <!-- Brand Logo -->
        <router-link to="/" class="flex items-center gap-3 group">
          <div class="relative overflow-hidden rounded-lg p-0.5 bg-gradient-to-r from-amber-400 via-amber-200 to-amber-600 shadow-md group-hover:scale-105 transition-transform duration-300">
            <img 
              src="/images/logo.jpeg" 
              alt="Al-Noor Properties BD Logo" 
              class="h-11 w-11 md:h-12 md:w-12 object-cover rounded-md bg-[#070a11]"
            />
          </div>
          <div class="flex flex-col">
            <span class="font-cinzel text-lg md:text-xl font-bold tracking-wider text-white group-hover:text-amber-400 transition-colors">
              AL-NOOR
            </span>
            <span class="text-[10px] md:text-xs tracking-[0.25em] text-amber-400/90 uppercase font-medium -mt-1">
              PROPERTIES BD
            </span>
          </div>
        </router-link>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex items-center gap-8">
          <router-link 
            to="/" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path === '/' ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            Home
            <span v-if="$route.path === '/'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-400 rounded-full"></span>
          </router-link>

          <router-link 
            to="/properties" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path.startsWith('/properties') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            Properties
            <span v-if="$route.path.startsWith('/properties')" class="absolute bottom-0 left-0 right-0 h-0.5 bg-amber-400 rounded-full"></span>
          </router-link>

          <router-link 
            to="/landowners" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1 flex items-center gap-1.5"
            :class="$route.path === '/landowners' ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            <span>Landowners</span>
            <span class="px-1.5 py-0.5 text-[9px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40 rounded-full">
              JV
            </span>
          </router-link>

          <router-link 
            to="/construction-updates" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path === '/construction-updates' ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            Live Progress
          </router-link>

          <router-link 
            to="/about" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path === '/about' ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            About Us
          </router-link>

          <router-link 
            to="/journal" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path.startsWith('/journal') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            Journal
          </router-link>

          <router-link 
            to="/contact" 
            class="text-sm font-medium tracking-wide transition-colors relative py-1"
            :class="$route.path === '/contact' ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-white'"
          >
            Contact
          </router-link>
        </nav>

        <!-- Right Action CTAs -->
        <div class="hidden lg:flex items-center gap-4">
          <!-- Hotline Phone -->
          <a 
            href="tel:16688" 
            class="flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-amber-400 transition-colors px-3 py-1.5 rounded-full border border-slate-700 bg-slate-900/40"
          >
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span>Hotline: 16688</span>
          </a>

          <!-- VIP Tour Booking Button -->
          <button 
            @click="$emit('open-vip-modal')"
            class="px-5 py-2.5 rounded-full text-xs uppercase tracking-wider font-bold gold-gradient-bg text-slate-950 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2"
          >
            <span>Book VIP Tour</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
          </button>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <button 
          @click="mobileMenuOpen = !mobileMenuOpen"
          aria-label="Toggle Navigation Menu"
          class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800/60 focus:outline-none"
        >
          <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

      </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0 -translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-4"
    >
      <div 
        v-if="mobileMenuOpen" 
        class="lg:hidden bg-[#0a0e18]/95 backdrop-blur-xl border-b border-amber-500/20 px-6 py-6 space-y-4 shadow-2xl"
      >
        <div class="flex flex-col space-y-3">
          <router-link 
            to="/" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path === '/' ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            Home
          </router-link>

          <router-link 
            to="/properties" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path.startsWith('/properties') ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            Properties & Explorer
          </router-link>

          <router-link 
            to="/landowners" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium flex items-center justify-between transition-colors"
            :class="$route.path === '/landowners' ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            <span>Landowners Joint Venture</span>
            <span class="px-2 py-0.5 text-xs font-bold bg-amber-500/20 text-amber-400 rounded-full border border-amber-500/40">
              High Yield
            </span>
          </router-link>

          <router-link 
            to="/construction-updates" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path === '/construction-updates' ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            Live Construction Progress
          </router-link>

          <router-link 
            to="/about" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path === '/about' ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            About Al-Noor
          </router-link>

          <router-link 
            to="/journal" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path.startsWith('/journal') ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            Journal & Insights
          </router-link>

          <router-link 
            to="/contact" 
            @click="mobileMenuOpen = false"
            class="px-3 py-2 rounded-md text-base font-medium transition-colors"
            :class="$route.path === '/contact' ? 'text-amber-400 bg-amber-500/10' : 'text-slate-200 hover:text-white hover:bg-slate-800/40'"
          >
            Contact & Concierge
          </router-link>
        </div>

        <div class="pt-4 border-t border-slate-800 space-y-3">
          <a 
            href="tel:16688"
            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-slate-700 bg-slate-900/60 text-sm font-semibold text-slate-200"
          >
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Direct Hotline: 16688</span>
          </a>

          <button 
            @click="mobileMenuOpen = false; $emit('open-vip-modal')"
            class="w-full py-3 rounded-xl text-center text-xs uppercase tracking-widest font-bold gold-gradient-bg text-slate-950 shadow-lg"
          >
            Schedule Private Tour
          </button>
        </div>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

defineEmits(['open-vip-modal']);

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 40;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
