<template>
  <div class="space-y-2">
    <label v-if="label" class="block font-bold text-slate-700 text-xs">{{ label }}</label>
    
    <div class="flex flex-col sm:flex-row gap-3 items-start">
      <!-- Image Preview Thumbnail -->
      <div 
        class="w-28 h-24 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden flex-shrink-0 relative group shadow-sm"
      >
        <img 
          v-if="modelValue" 
          :src="modelValue" 
          class="w-full h-full object-cover" 
          alt="Preview"
        />
        <div v-else class="text-center p-2 text-slate-400">
          <i class="bx bx-image text-2xl"></i>
          <span class="block text-[9px]">No image</span>
        </div>

        <button 
          v-if="modelValue" 
          @click="$emit('update:modelValue', '')"
          type="button" 
          title="Remove image"
          class="absolute top-1 right-1 w-5 h-5 rounded-full bg-rose-500 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer shadow"
        >
          <i class="bx bx-x"></i>
        </button>
      </div>

      <!-- Controls & Drag Zone -->
      <div class="flex-1 w-full space-y-2">
        <!-- Direct File Upload Button / Dropzone -->
        <div 
          @dragover.prevent="isDragging = true"
          @dragleave.prevent="isDragging = false"
          @drop.prevent="handleDrop"
          class="border-2 border-dashed rounded-xl p-3 text-center transition-all cursor-pointer relative"
          :class="isDragging ? 'border-[#696cff] bg-[#696cff]/5' : 'border-slate-200 hover:border-slate-300 bg-white'"
          @click="$refs.fileInput.click()"
        >
          <input 
            type="file" 
            ref="fileInput" 
            @change="handleFileSelect" 
            accept="image/*" 
            class="hidden" 
          />

          <div v-if="!uploading" class="flex items-center justify-center gap-2 text-xs text-slate-600">
            <i class="bx bx-cloud-upload text-xl text-[#696cff]"></i>
            <span><strong>Click to browse</strong> or drag & drop (JPG, PNG, WebP)</span>
          </div>

          <div v-else class="flex items-center justify-center gap-2 text-xs text-[#696cff] font-medium">
            <i class="bx bx-loader-alt animate-spin text-lg"></i>
            <span>Optimizing & Uploading to WebP...</span>
          </div>
        </div>

        <!-- Or Paste URL fallback -->
        <div class="flex items-center gap-2">
          <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">or URL:</span>
          <input 
            :value="modelValue" 
            @input="$emit('update:modelValue', $event.target.value)"
            type="text" 
            placeholder="https://images.unsplash.com/... or /images/..." 
            class="flex-1 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs outline-none focus:border-[#696cff] text-slate-700"
          />
        </div>
      </div>
    </div>

    <!-- Error message -->
    <p v-if="errorMessage" class="text-[11px] text-rose-500 font-medium">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:modelValue']);

const fileInput = ref(null);
const isDragging = ref(false);
const uploading = ref(false);
const errorMessage = ref('');

const uploadFile = async (file) => {
  if (!file) return;
  if (!file.type.startsWith('image/')) {
    errorMessage.value = 'Please select a valid image file.';
    return;
  }

  errorMessage.value = '';
  uploading.value = true;

  const formData = new FormData();
  formData.append('file', file);

  try {
    const res = await axios.post('/api/admin/media/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    if (res.data?.url) {
      emit('update:modelValue', res.data.url);
    }
  } catch (err) {
    console.error('Upload failed:', err);
    errorMessage.value = err.response?.data?.message || 'Failed to upload image. Please check file size.';
  } finally {
    uploading.value = false;
  }
};

const handleFileSelect = (e) => {
  const files = e.target.files;
  if (files && files.length > 0) {
    uploadFile(files[0]);
  }
};

const handleDrop = (e) => {
  isDragging.value = false;
  const files = e.dataTransfer.files;
  if (files && files.length > 0) {
    uploadFile(files[0]);
  }
};
</script>
