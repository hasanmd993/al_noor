<template>
  <div class="fixed bottom-6 right-6 z-50 font-sans">
    <!-- 1. Expandable Luxury Concierge Chat Window -->
    <transition
      enter-active-class="transition duration-300 ease-out transform"
      enter-from-class="opacity-0 translate-y-6 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition duration-200 ease-in transform"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-6 scale-95"
    >
      <div 
        v-if="isOpen" 
        class="mb-3 w-[340px] sm:w-[380px] rounded-3xl overflow-hidden shadow-2xl border border-amber-500/30 bg-[#0c1220]/95 backdrop-blur-xl text-slate-100 flex flex-col"
        style="box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(212, 167, 81, 0.15);"
      >
        <!-- Header -->
        <div class="p-4 bg-gradient-to-r from-[#0d1627] via-[#131d33] to-[#0a101d] border-b border-amber-500/20 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="relative">
              <img 
                src="/images/logo.jpeg" 
                alt="Al-Noor Concierge" 
                class="w-10 h-10 rounded-2xl object-cover ring-2 ring-amber-500/40 shadow-md"
              />
              <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 border-2 border-[#0c1220] animate-pulse"></span>
            </div>
            <div>
              <div class="flex items-center gap-1.5">
                <span class="font-bold text-sm tracking-wide text-white">Al-Noor Concierge</span>
                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">VIP</span>
              </div>
              <div class="flex items-center gap-1.5 text-[11px] text-emerald-400 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Active Relationship Desk</span>
              </div>
            </div>
          </div>

          <button 
            @click="isOpen = false"
            class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors cursor-pointer"
            aria-label="Close Concierge"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Body -->
        <div class="p-5 space-y-4 max-h-[380px] overflow-y-auto">
          <!-- Welcome Bubble -->
          <div class="flex items-start gap-2.5">
            <div class="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
              ✦
            </div>
            <div class="p-3.5 rounded-2xl rounded-tl-sm bg-slate-900/90 border border-slate-800 text-xs text-slate-300 leading-relaxed shadow-sm">
              <p class="font-medium text-white mb-1">Assalamu Alaikum.</p>
              <p>Welcome to Al-Noor Properties BD. How can our executive property advisors assist your luxury lifestyle journey today?</p>
            </div>
          </div>

          <!-- Active Page Context Badge -->
          <div v-if="pageContextTag" class="px-3.5 py-2 rounded-xl bg-amber-500/10 border border-amber-500/25 flex items-center gap-2 text-xs text-amber-300">
            <span class="text-amber-400">📍</span>
            <span class="truncate font-medium">{{ pageContextTag }}</span>
          </div>

          <!-- Quick Topic Pills -->
          <div class="space-y-1.5">
            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Quick Inquiries</span>
            <div class="flex flex-wrap gap-1.5">
              <button 
                v-for="(chip, idx) in quickChips" 
                :key="idx"
                @click="selectChip(chip.prompt)"
                class="px-2.5 py-1.5 rounded-lg text-[11px] font-medium bg-slate-800/80 hover:bg-amber-500/20 hover:text-amber-300 border border-slate-700/60 hover:border-amber-500/40 text-slate-300 transition-all cursor-pointer text-left"
              >
                {{ chip.label }}
              </button>
            </div>
          </div>

          <!-- Message Input / Preview -->
          <div class="space-y-1.5">
            <div class="flex items-center justify-between text-[10px] uppercase font-bold tracking-wider text-slate-400">
              <span>Your WhatsApp Message</span>
              <span class="text-slate-500 font-mono">{{ messageText.length }} chars</span>
            </div>
            <textarea 
              v-model="messageText" 
              rows="3" 
              placeholder="Type your inquiry or select a quick option above..."
              class="w-full px-3 py-2 text-xs rounded-xl bg-slate-950/80 border border-slate-800 focus:border-amber-500/60 outline-none text-slate-200 placeholder-slate-500 resize-none transition-colors"
            ></textarea>
          </div>
        </div>

        <!-- Footer / Start Chat Action -->
        <div class="p-4 bg-[#090e18] border-t border-slate-800/80 flex items-center gap-3">
          <button 
            @click="sendWhatsAppMessage"
            class="flex-1 py-3 px-4 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-[#25D366] to-[#128C7E] hover:from-[#20bd5a] hover:to-[#0f7a6e] shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5 cursor-pointer"
          >
            <!-- WhatsApp SVG Icon -->
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.543 1.93.832 2.8.832h.005c3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.585-5.767-5.776-5.767zm7.625 5.764c-.002 4.218-3.433 7.649-7.653 7.649-1.306 0-2.587-.333-3.719-.966l-4.148 1.088 1.107-4.043c-.702-1.22-1.072-2.61-1.073-4.032.002-4.218 3.433-7.65 7.653-7.65 4.22 0 7.635 3.432 7.635 7.654zm2.344 0c0-5.523-4.477-10-10-10s-10 4.477-10 10c0 1.767.459 3.428 1.261 4.873l-1.341 4.9 5.019-1.316c1.397.765 2.993 1.2 4.681 1.2h.006c5.523 0 10-4.477 10-10z"/>
            </svg>
            <span>Start WhatsApp Chat</span>
          </button>
        </div>
      </div>
    </transition>

    <!-- 2. Floating Trigger Button (Collapsed) -->
    <div class="relative group">
      <!-- Glow Pulse Effect -->
      <span class="absolute -inset-1 rounded-full bg-gradient-to-r from-emerald-500 to-amber-500 opacity-60 blur-md group-hover:opacity-90 group-hover:scale-110 transition duration-500 animate-pulse"></span>

      <button 
        @click="toggleOpen"
        :class="[
          'relative flex items-center gap-3 px-4 py-3 rounded-full shadow-2xl transition-all duration-300 cursor-pointer border',
          isOpen 
            ? 'bg-[#0c1220] border-amber-500/50 text-amber-300' 
            : 'bg-gradient-to-r from-[#0d1627] via-[#101c30] to-[#0c1220] border-amber-500/30 text-white hover:border-amber-400'
        ]"
        aria-label="Al-Noor WhatsApp Concierge"
      >
        <!-- WhatsApp Icon inside Glowing Emerald Circle -->
        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#25D366] to-[#128C7E] flex items-center justify-center text-white shadow-md flex-shrink-0">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.995.543 1.93.832 2.8.832h.005c3.179 0 5.766-2.587 5.767-5.766.001-3.181-2.585-5.767-5.776-5.767zm7.625 5.764c-.002 4.218-3.433 7.649-7.653 7.649-1.306 0-2.587-.333-3.719-.966l-4.148 1.088 1.107-4.043c-.702-1.22-1.072-2.61-1.073-4.032.002-4.218 3.433-7.65 7.653-7.65 4.22 0 7.635 3.432 7.635 7.654zm2.344 0c0-5.523-4.477-10-10-10s-10 4.477-10 10c0 1.767.459 3.428 1.261 4.873l-1.341 4.9 5.019-1.316c1.397.765 2.993 1.2 4.681 1.2h.006c5.523 0 10-4.477 10-10z"/>
          </svg>
        </div>

        <!-- Text Label -->
        <div class="hidden sm:flex flex-col text-left">
          <div class="flex items-center gap-1.5">
            <span class="text-xs font-bold tracking-wide text-white">Private Concierge</span>
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
          </div>
          <span class="text-[10px] text-amber-300/90 font-medium">Chat on WhatsApp</span>
        </div>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const props = defineProps({
  phoneNumber: {
    type: String,
    default: '8801700000000' // Al-Noor Concierge WhatsApp Number
  }
});

const route = useRoute();
const isOpen = ref(false);
const messageText = ref('');

const toggleOpen = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value && !messageText.value) {
    setDefaultMessageForCurrentRoute();
  }
};

// Derive contextual tag based on current page
const pageContextTag = computed(() => {
  if (route.name === 'PropertyDetail') {
    return 'Context: Property Inquiry';
  }
  if (route.name === 'Landowners') {
    return 'Context: Landowner Joint Venture';
  }
  if (route.name === 'Properties') {
    return 'Context: Browse Collection';
  }
  return null;
});

// Quick suggestion chips based on active route
const quickChips = computed(() => {
  if (route.name === 'PropertyDetail') {
    return [
      { label: '📅 Book Private Tour', prompt: 'I would like to book a private VIP viewing for this property.' },
      { label: '📑 Request Full Brochure', prompt: 'Please share the complete architectural brochure and unit pricing sheet.' },
      { label: '💳 Payment & EMI Schedule', prompt: 'Could you please share the installment plan and payment milestones?' }
    ];
  }
  if (route.name === 'Landowners') {
    return [
      { label: '🤝 Joint Venture Feasibility', prompt: 'I have a plot in Dhaka and would like a complimentary JV feasibility evaluation.' },
      { label: '📐 Sharing Ratio Guidance', prompt: 'What are the current landowner sharing ratios and signing benefits in my area?' },
      { label: '⚖️ RAJUK Approval Process', prompt: 'Could your legal team explain the RAJUK approval and timeline management?' }
    ];
  }
  return [
    { label: '🏛️ Dhaka Prime Developments', prompt: 'I am looking for luxury ready/ongoing residences in Gulshan or Banani.' },
    { label: '💎 Penthouse & Sky Duplex', prompt: 'Do you have exclusive top-floor penthouses available with private pools?' },
    { label: '🤝 Landowner Consultation', prompt: 'I would like to discuss a joint-venture property development with Al-Noor.' }
  ];
});

const setDefaultMessageForCurrentRoute = () => {
  if (route.name === 'PropertyDetail') {
    const title = document.title?.replace(' | Al-Noor Properties BD', '') || 'this property';
    messageText.value = `Assalamu Alaikum Al-Noor Concierge. I am interested in ${title}. Please connect me with a relationship manager for details.`;
  } else if (route.name === 'Landowners') {
    messageText.value = `Assalamu Alaikum. I am a Dhaka landowner interested in exploring a Joint Venture partnership with Al-Noor Properties BD.`;
  } else {
    messageText.value = `Assalamu Alaikum. I would like to schedule a private VIP consultation regarding Al-Noor luxury properties in Dhaka.`;
  }
};

const selectChip = (promptText) => {
  messageText.value = promptText;
};

// Update message text when route changes if user hasn't typed custom message
watch(() => route.path, () => {
  if (isOpen.value) {
    setDefaultMessageForCurrentRoute();
  }
});

const sendWhatsAppMessage = () => {
  const cleanNumber = props.phoneNumber.replace(/[^0-9]/g, '');
  const encodedMsg = encodeURIComponent(messageText.value || 'Assalamu Alaikum. I would like to inquire about Al-Noor luxury residences.');
  const url = `https://wa.me/${cleanNumber}?text=${encodedMsg}`;
  window.open(url, '_blank', 'noopener,noreferrer');
};

onMounted(() => {
  setDefaultMessageForCurrentRoute();
});
</script>

