<template>
  <div class="min-h-screen bg-[#f5f5f9] flex items-center justify-center p-4 font-['Public_Sans',sans-serif]">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200/80 p-8">
      <!-- Brand Crest -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 mb-3 shadow-inner">
          <img src="/images/logo.jpeg" alt="Al-Noor Logo" class="w-12 h-12 object-cover rounded-xl" />
        </div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Al-Noor Executive Portal</h2>
        <p class="text-xs text-slate-400 mt-1">Sneat v1.0.0 Admin Management System</p>
      </div>

      <!-- Error Alert -->
      <div v-if="errorMsg" class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-xs flex items-center gap-2.5">
        <i class="bx bx-error-circle text-lg flex-shrink-0"></i>
        <span>{{ errorMsg }}</span>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <i class="bx bx-envelope text-lg"></i>
            </span>
            <input 
              v-model="form.email" 
              type="email" 
              required 
              placeholder="admin@alnoorbd.com"
              class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-[#696cff] focus:ring-4 focus:ring-[#696cff]/10 outline-none transition-all text-slate-800"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
            <span class="text-[11px] text-[#696cff] font-medium">Default: password</span>
          </div>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <i class="bx bx-lock-alt text-lg"></i>
            </span>
            <input 
              v-model="form.password" 
              :type="showPassword ? 'text' : 'password'" 
              required 
              placeholder="••••••••"
              class="w-full pl-10 pr-10 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-[#696cff] focus:ring-4 focus:ring-[#696cff]/10 outline-none transition-all text-slate-800"
            />
            <button 
              type="button" 
              @click="showPassword = !showPassword" 
              class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600"
            >
              <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between pt-1 text-xs">
          <label class="flex items-center gap-2 cursor-pointer text-slate-600 select-none">
            <input type="checkbox" v-model="form.remember" class="w-4 h-4 rounded text-[#696cff] focus:ring-[#696cff]" />
            <span>Remember this device</span>
          </label>
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="w-full py-3 px-4 bg-[#696cff] hover:bg-[#5f61e6] text-white font-bold text-sm rounded-xl shadow-lg shadow-[#696cff]/30 transition-all flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
        >
          <i v-if="loading" class="bx bx-loader-alt animate-spin text-lg"></i>
          <span>{{ loading ? 'Signing in...' : 'Sign in to Dashboard' }}</span>
        </button>
      </form>

      <!-- Quick helper -->
      <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <button 
          @click="fillDefault" 
          class="text-xs text-slate-500 hover:text-[#696cff] font-medium flex items-center justify-center gap-1.5 mx-auto"
        >
          <i class="bx bx-key"></i> Auto-fill Admin Credentials
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const showPassword = ref(false);
const loading = ref(false);
const errorMsg = ref('');

const form = ref({
  email: 'admin@alnoorbd.com',
  password: 'password',
  remember: true,
});

const fillDefault = () => {
  form.value.email = 'admin@alnoorbd.com';
  form.value.password = 'password';
};

const handleSubmit = async () => {
  loading.value = true;
  errorMsg.value = '';
  try {
    const res = await axios.post('/api/admin/login', {
      email: form.value.email,
      password: form.value.password,
    });
    if (res.data && res.data.success) {
      localStorage.setItem('alnoor_admin_token', res.data.token);
      localStorage.setItem('alnoor_admin_user', JSON.stringify(res.data.user));
      router.push('/admin/dashboard');
    } else {
      errorMsg.value = res.data.message || 'Login failed.';
    }
  } catch (err) {
    errorMsg.value = err.response?.data?.message || 'Invalid credentials. Please try again.';
  } finally {
    loading.value = false;
  }
};
</script>
