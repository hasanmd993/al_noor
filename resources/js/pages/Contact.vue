<template>
  <div class="pt-28 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
    
    <div class="text-center max-w-3xl mx-auto space-y-3">
      <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
        Client Concierge & Direct Inquiries
      </span>
      <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white">
        Connect with Al-Noor
      </h1>
      <p class="text-sm text-slate-300">
        Our executive relationship directors are available 6 days a week to schedule private viewings, discuss landowner partnerships, and provide tailored portfolio guidance.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
      
      <!-- Contact Cards & Info (5 cols) -->
      <div class="lg:col-span-5 space-y-6">
        
        <div class="glass-panel p-6 rounded-3xl border border-amber-500/20 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
              🏢
            </div>
            <div>
              <h3 class="font-cinzel text-base font-bold text-white">Corporate Headquarters</h3>
              <p class="text-xs text-slate-300">Al-Noor Tower, Banani</p>
            </div>
          </div>
          <p class="text-xs text-slate-300 leading-relaxed pl-13">
            Level 12-14, Plot 88, Road 11, Block D, Banani, Dhaka-1213, Bangladesh
          </p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-amber-500/20 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
              📞
            </div>
            <div>
              <h3 class="font-cinzel text-base font-bold text-white">Direct Hotlines</h3>
              <p class="text-xs text-slate-300">Instant Concierge Assistance</p>
            </div>
          </div>
          <div class="space-y-1.5 text-xs text-slate-300 pl-13">
            <p>Hotline: <strong class="text-amber-400 font-mono text-sm">16688</strong></p>
            <p>Mobile: <strong class="text-white font-mono">+880 1894-916600</strong></p>
            <p>WhatsApp: <strong class="text-emerald-400 font-mono">+880 1894-916600</strong></p>
          </div>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-amber-500/20 space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
              ✉️
            </div>
            <div>
              <h3 class="font-cinzel text-base font-bold text-white">Email Inquiries</h3>
              <p class="text-xs text-slate-300">Sales & Land Partnerships</p>
            </div>
          </div>
          <div class="space-y-1.5 text-xs text-slate-300 pl-13">
            <p>Sales: <strong class="text-white">sales@alnoorpropertiesbd.com</strong></p>
            <p>Landowners: <strong class="text-white">land@alnoorpropertiesbd.com</strong></p>
            <p>Executive Office: <strong class="text-white">info@alnoorpropertiesbd.com</strong></p>
          </div>
        </div>

      </div>

      <!-- Message Form (7 cols) -->
      <div class="lg:col-span-7 glass-panel p-8 rounded-3xl border border-amber-500/30 shadow-2xl">
        <div v-if="sent" class="text-center py-12 space-y-4">
          <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center mx-auto text-2xl">
            ✓
          </div>
          <h3 class="font-cinzel text-2xl font-bold text-white">Message Delivered</h3>
          <p class="text-sm text-slate-300 max-w-md mx-auto">
            Thank you for reaching out to Al-Noor Properties BD. Our executive relationship manager will respond to you promptly.
          </p>
          <button @click="sent = false" class="px-6 py-2.5 rounded-full gold-gradient-bg text-slate-950 font-bold text-xs uppercase">
            Send Another Message
          </button>
        </div>

        <form v-else @submit.prevent="submitMessage" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Your Full Name *</label>
              <input v-model="form.name" required type="text" placeholder="e.g. Barrister / Engr. Name" class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Phone Number *</label>
              <input v-model="form.phone" required type="tel" placeholder="+880 17XX-XXXXXX" class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500" />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Email Address *</label>
              <input v-model="form.email" required type="email" placeholder="name@example.com" class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Inquiry Category *</label>
              <select v-model="form.subject" class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500">
                <option value="Apartment Purchase Inquiry">Apartment Purchase Inquiry</option>
                <option value="Commercial Space Inquiry">Commercial Space Inquiry</option>
                <option value="Landowner Joint Venture">Landowner Joint Venture</option>
                <option value="Home Loan Financing Assistance">Home Loan Financing Assistance</option>
                <option value="General Concierge Inquiry">General Concierge Inquiry</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300 mb-1">Your Message *</label>
            <textarea v-model="form.message" required rows="4" placeholder="How may our senior relationship director assist you today?" class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500"></textarea>
          </div>

          <button 
            type="submit" 
            :disabled="loading"
            class="w-full py-3.5 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-widest hover:shadow-xl hover:shadow-amber-500/25 transition-all"
          >
            <span v-if="loading">Transmitting Message...</span>
            <span v-else>Send Message to Concierge</span>
          </button>
        </form>
      </div>

    </div>

  </div>
</template>

<script setup>
import { useSeoMeta } from '@unhead/vue';

useSeoMeta({
  "title": "Private Concierge & VIP Consultations | Al-Noor Properties BD",
  "description": "Connect with our private client concierge for confidential viewings, home acquisition, and partnership inquiries.",
  "ogTitle": "Contact Al-Noor Concierge",
  "ogDescription": "Schedule private viewings and personal consultations with our advisory team.",
  "ogImage": "/images/logo.jpeg"
});

import { reactive, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import confetti from 'canvas-confetti';

const route = useRoute();
const loading = ref(false);
const sent = ref(false);

const form = reactive({
  name: '',
  phone: '',
  email: '',
  subject: 'Apartment Purchase Inquiry',
  message: ''
});

onMounted(() => {
  if (route.query.subject) {
    form.subject = route.query.subject;
  }
});

const submitMessage = async () => {
  loading.value = true;
  try {
    await axios.post('/api/inquiries', {
      name: form.name,
      email: form.email,
      phone: form.phone,
      subject: form.subject,
      source: 'contact_form',
      message: form.message
    });

    sent.value = true;
    confetti({
      particleCount: 50,
      spread: 60,
      origin: { y: 0.6 },
      colors: ['#d4a751', '#e2c07a', '#c6923b']
    });
  } catch (err) {
    console.error('Error submitting contact form', err);
    sent.value = true;
  } finally {
    loading.value = false;
  }
};
</script>
