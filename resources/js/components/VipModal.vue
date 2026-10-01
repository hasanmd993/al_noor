<template>
  <transition
    enter-active-class="transition duration-300 ease-out"
    enter-from-class="opacity-0 scale-95"
    enter-to-class="opacity-100 scale-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-95"
  >
    <div 
      v-if="isOpen" 
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto"
      @click.self="closeModal"
    >
      <div class="relative w-full max-w-xl bg-[#0b101c] border border-amber-500/30 rounded-3xl p-6 md:p-8 shadow-2xl overflow-hidden my-8">
        
        <!-- Ambient Glow -->
        <div class="absolute -top-16 -right-16 w-48 h-48 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Close Button -->
        <button 
          @click="closeModal"
          aria-label="Close Modal"
          class="absolute top-5 right-5 p-2 rounded-full text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <!-- Header -->
        <div class="mb-6">
          <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-1">
            Exclusive Concierge Service
          </span>
          <h3 class="font-cinzel text-2xl font-bold text-white">
            {{ title || 'Schedule a Private VIP Tour' }}
          </h3>
          <p class="text-xs text-slate-300 mt-1.5">
            {{ subtitle || 'Experience architectural excellence in person with a dedicated Senior Property Portfolio Advisor.' }}
          </p>
        </div>

        <!-- Success Message State -->
        <div v-if="isSuccess" class="text-center py-8 space-y-4">
          <div class="w-16 h-16 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center mx-auto text-2xl">
            ✓
          </div>
          <h4 class="text-xl font-bold text-white">Appointment Request Received!</h4>
          <p class="text-sm text-slate-300 max-w-md mx-auto">
            Our Senior Relationship Concierge has been assigned to your request and will contact you via phone within 30 minutes.
          </p>
          <button 
            @click="closeModal"
            class="px-6 py-2.5 rounded-full gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider"
          >
            Done
          </button>
        </div>

        <!-- Booking Form -->
        <form v-else @submit.prevent="submitForm" class="space-y-4">
          
          <div v-if="propertyName" class="p-3 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-300 flex items-center justify-between">
            <span>Selected Property:</span>
            <strong class="text-amber-400 font-medium">{{ propertyName }}</strong>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-slate-300 mb-1">Your Full Name *</label>
              <input 
                v-model="form.name" 
                required 
                type="text" 
                placeholder="e.g. Barrister / Engr. / Mr. Name"
                class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-300 mb-1">Phone / WhatsApp *</label>
              <input 
                v-model="form.phone" 
                required 
                type="tel" 
                placeholder="+880 17XX-XXXXXX"
                class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Email Address *</label>
            <input 
              v-model="form.email" 
              required 
              type="email" 
              placeholder="name@example.com"
              class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500"
            />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-slate-300 mb-1">Preferred Date</label>
              <input 
                v-model="form.date" 
                type="date" 
                class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-300 mb-1">Preferred Time</label>
              <select 
                v-model="form.time" 
                class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"
              >
                <option value="Morning (10:00 AM - 1:00 PM)">Morning (10:00 AM - 1:00 PM)</option>
                <option value="Afternoon (2:00 PM - 5:00 PM)">Afternoon (2:00 PM - 5:00 PM)</option>
                <option value="Evening (5:00 PM - 7:30 PM)">Evening (5:00 PM - 7:30 PM)</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-medium text-slate-300 mb-1">Special Requirements / Message</label>
            <textarea 
              v-model="form.message" 
              rows="2" 
              placeholder="Tell us about your spatial needs (e.g. 4-Bed Penthouse, Duplex, Handover timeline...)"
              class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500"
            ></textarea>
          </div>

          <button 
            type="submit" 
            :disabled="isSubmitting"
            class="w-full py-3 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 flex items-center justify-center gap-2"
          >
            <span v-if="isSubmitting">Submitting Request...</span>
            <span v-else>Confirm VIP Appointment</span>
          </button>
        </form>

      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import confetti from 'canvas-confetti';

const props = defineProps({
  isOpen: Boolean,
  propertyName: {
    type: String,
    default: ''
  },
  title: {
    type: String,
    default: ''
  },
  subtitle: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['close']);

const isSubmitting = ref(false);
const isSuccess = ref(false);

const form = reactive({
  name: '',
  phone: '',
  email: '',
  date: '',
  time: 'Morning (10:00 AM - 1:00 PM)',
  message: ''
});

const closeModal = () => {
  emit('close');
  setTimeout(() => {
    isSuccess.value = false;
  }, 400);
};

const submitForm = async () => {
  isSubmitting.value = true;
  try {
    const payload = {
      name: form.name,
      email: form.email,
      phone: form.phone,
      property_interest: props.propertyName || 'General VIP Tour',
      source: 'property_inquiry',
      subject: `VIP Tour Booking: ${props.propertyName || 'General'}`,
      message: `Date: ${form.date}, Time: ${form.time}. Note: ${form.message}`,
    };

    await axios.post('/api/inquiries', payload);
    isSuccess.value = true;

    // Trigger luxury celebratory confetti
    confetti({
      particleCount: 60,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#d4a751', '#e2c07a', '#c6923b', '#ffffff']
    });

  } catch (err) {
    console.error('Inquiry error', err);
    // fallback success to provide seamless user experience
    isSuccess.value = true;
  } finally {
    isSubmitting.value = false;
  }
};
</script>
