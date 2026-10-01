<template>
  <div class="space-y-6 w-full">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Corporate & Contact Settings</h1>
      <p class="text-xs text-slate-400">Configure phone lines, official emails, head office location, and concierge contacts</p>
    </div>

    <div v-if="saved" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
      <i class="bx bx-check-circle text-lg"></i> Settings saved successfully!
    </div>

    <form @submit.prevent="saveSettings" class="bg-white rounded-2xl p-6 md:p-8 border border-[#e7e7e8] shadow-sm space-y-6 text-xs w-full">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block font-bold text-slate-700 mb-1.5">Company Name</label>
          <input v-model="settings.company_name" type="text" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
        </div>

        <div>
          <label class="block font-bold text-slate-700 mb-1.5">Primary Hotline</label>
          <input v-model="settings.phone" type="text" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
        </div>

        <div>
          <label class="block font-bold text-slate-700 mb-1.5">VIP Concierge / WhatsApp</label>
          <input v-model="settings.whatsapp" type="text" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
        </div>

        <div>
          <label class="block font-bold text-slate-700 mb-1.5">Official Inquiry Email</label>
          <input v-model="settings.email" type="email" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
        </div>
      </div>

      <div>
        <label class="block font-bold text-slate-700 mb-1.5">Corporate Brochure PDF Download Link</label>
        <input v-model="settings.brochure_url" type="text" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800" />
      </div>

      <div>
        <label class="block font-bold text-slate-700 mb-1.5">Corporate Head Office Address</label>
        <textarea v-model="settings.address" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-[#696cff] text-slate-800"></textarea>
      </div>

      <div class="pt-4 border-t border-slate-100 flex justify-end">
        <button type="submit" class="px-6 py-2.5 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-xs rounded-xl shadow-lg shadow-[#696cff]/20 cursor-pointer">
          Save Settings
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const saved = ref(false);
const settings = ref({
  company_name: 'Al-Noor Properties BD',
  phone: '+880 1711-000000',
  whatsapp: '+880 1811-000000',
  email: 'info@alnoorbd.com',
  address: 'Level 14, Al-Noor Signature Tower, Road 71, Gulshan-2, Dhaka 1212, Bangladesh',
  brochure_url: '/assets/alnoor_brochure.pdf'
});

const saveSettings = () => {
  saved.value = true;
  setTimeout(() => saved.value = false, 3000);
};
</script>
