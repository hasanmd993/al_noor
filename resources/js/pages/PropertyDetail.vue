<template>
  <div v-if="property" class="pt-24 pb-20 space-y-16">
    
    <!-- 1. HERO & MEDIA GALLERY -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Gallery Viewer (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
          <!-- Active Image Display -->
          <div class="relative h-[400px] sm:h-[500px] rounded-3xl overflow-hidden border border-amber-500/25 shadow-2xl bg-black">
            <img 
              :src="activeImage" 
              :alt="property.name" 
              class="w-full h-full object-cover transition-all duration-500"
            />
            
            <div class="absolute top-4 left-4 flex gap-2">
              <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider gold-gradient-bg text-slate-950 shadow-lg">
                {{ property.status === 'completed' ? 'Ready for Handover' : (property.status === 'upcoming' ? 'Upcoming Launch' : 'Ongoing Construction') }}
              </span>
            </div>

            <div class="absolute bottom-4 left-4 right-4 p-4 rounded-2xl bg-[#070a11]/90 backdrop-blur-md border border-slate-800 flex items-center justify-between text-xs text-slate-300">
              <span class="font-medium text-white">{{ activeImageCaption || property.name }}</span>
              <span class="text-amber-400 font-mono">{{ activeImageIndex + 1 }} / {{ allImages.length }}</span>
            </div>
          </div>

          <!-- Thumbnails Row -->
          <div class="flex items-center gap-3 overflow-x-auto pb-2">
            <button 
              v-for="(img, idx) in allImages" 
              :key="idx"
              @click="setActiveImage(img.image_path, img.caption, idx)"
              class="relative w-24 h-16 rounded-xl overflow-hidden flex-shrink-0 border-2 transition-all duration-300 cursor-pointer"
              :class="activeImageIndex === idx ? 'border-amber-400 scale-105 shadow-md shadow-amber-500/20' : 'border-slate-800 opacity-60 hover:opacity-100'"
            >
              <img :src="img.image_path" class="w-full h-full object-cover" />
            </button>
          </div>
        </div>

        <!-- Right: Primary Details & VIP Booking Card (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
          <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-amber-500/20 shadow-2xl space-y-6 sticky top-28">
            <div>
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs uppercase tracking-widest text-amber-400 font-semibold">{{ property.property_type }}</span>
                <span class="text-xs text-slate-400 flex items-center gap-1">
                  <i class="bx bx-map text-amber-400"></i> {{ property.location?.name || property.address }}
                </span>
              </div>
              <h1 class="font-cinzel text-2xl sm:text-3xl font-extrabold text-white leading-tight">{{ property.name }}</h1>
              <p class="text-xs text-slate-300 mt-2">{{ property.address }}, Dhaka</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-950/70 border border-slate-800/80 space-y-1">
              <span class="text-[11px] uppercase tracking-wider text-slate-400 font-semibold block">Pricing Portfolio</span>
              <div class="font-cinzel text-xl font-bold text-amber-400">
                {{ formatCurrency(property.price_from) }}
              </div>
            </div>

            <!-- Quick Key Metrics -->
            <div class="grid grid-cols-2 gap-3 text-xs">
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase">Apartment Size</span>
                <strong class="text-white">{{ property.sqft_from ? property.sqft_from.toLocaleString() + ' - ' + (property.sqft_to?.toLocaleString() || '') + ' SFT' : 'Luxury Layouts' }}</strong>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase">Bedrooms</span>
                <strong class="text-white">{{ property.bedrooms ? property.bedrooms + ' Suites' : '4-5 Bed' }}</strong>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase">Handover Date</span>
                <strong class="text-white">{{ property.completion_date || 'Q4 2027' }}</strong>
              </div>
              <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase">Land Area</span>
                <strong class="text-white">{{ property.land_area || '15 Katha' }}</strong>
              </div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-3 pt-2">
              <button 
                @click="$emit('open-vip-modal', property.name)"
                class="w-full py-3.5 rounded-2xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider hover:shadow-xl hover:shadow-amber-500/25 transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer"
              >
                <i class="bx bx-calendar-event text-base"></i> Book VIP Private Viewing
              </button>

              <!-- PDF Brochure Button (Only visible if brochure_pdf exists) -->
              <a 
                v-if="hasBrochure"
                :href="property.brochure_pdf"
                target="_blank"
                download
                class="w-full py-3 rounded-2xl bg-slate-900/90 hover:bg-slate-800 border border-amber-500/30 text-amber-300 font-semibold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all duration-300 cursor-pointer"
              >
                <i class="bx bxs-file-pdf text-base text-rose-400"></i>
                <span>Download PDF Brochure</span>
              </a>

              <a 
                :href="`https://wa.me/8801700000000?text=${encodeURIComponent('Hello Al-Noor Concierge, I am inquiring about ' + property.name + ' in ' + (property.location?.name || property.address))}`"
                target="_blank"
                class="w-full py-2.5 rounded-2xl bg-emerald-950/40 hover:bg-emerald-900/50 border border-emerald-500/30 text-emerald-400 font-semibold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all duration-300"
              >
                <i class="bx bxl-whatsapp text-lg"></i> Direct WhatsApp Concierge
              </a>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 2. ARCHITECTURAL OVERVIEW -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="glass-panel rounded-3xl p-8 sm:p-12 border border-slate-800 space-y-6">
        <h2 class="font-cinzel text-2xl font-bold text-white flex items-center gap-3">
          <span class="w-2 h-6 gold-gradient-bg rounded-full inline-block"></span>
          Architectural Philosophy & Vision
        </h2>
        <div class="prose prose-invert max-w-none text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line font-light">
          {{ property.description }}
        </div>
      </div>
    </section>

    <!-- 3. CURATED SPECIFICATIONS & AMENITIES -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
      <div class="space-y-2">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Refined Living</span>
        <h2 class="font-cinzel text-2xl sm:text-3xl font-bold text-white">Signature Amenities & Specifications</h2>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <div 
          v-for="(amenity, idx) in parsedAmenities" 
          :key="idx"
          class="glass-panel rounded-2xl p-4 border border-slate-800/80 text-center space-y-2 hover:border-amber-500/30 transition-all duration-300 group"
        >
          <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition-transform">
            <i :class="getAmenityIcon(amenity)"></i>
          </div>
          <span class="text-xs font-semibold text-slate-200 block">{{ amenity }}</span>
        </div>
      </div>
    </section>

    <!-- 4. AVAILABLE UNIT TYPOLOGIES / FLOOR PLANS -->
    <section v-if="property.units && property.units.length > 0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="space-y-2">
          <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Floorplans & Layouts</span>
          <h2 class="font-cinzel text-2xl sm:text-3xl font-bold text-white">Available Unit Typologies</h2>
        </div>
        <div class="flex gap-2">
          <button 
            v-for="(unit, idx) in property.units" 
            :key="idx"
            @click="selectedUnitIndex = idx"
            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all cursor-pointer"
            :class="selectedUnitIndex === idx ? 'gold-gradient-bg text-slate-950 font-bold' : 'bg-slate-900 text-slate-400 hover:text-white border border-slate-800'"
          >
            {{ unit.unit_type }}
          </button>
        </div>
      </div>

      <div v-if="currentUnit" class="glass-panel rounded-3xl p-6 sm:p-10 border border-slate-800">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
          <div class="lg:col-span-7 rounded-2xl overflow-hidden border border-slate-800 bg-black/40 p-4">
            <img 
              :src="currentUnit.floor_plan_image || activeImage" 
              :alt="currentUnit.unit_type" 
              class="w-full h-80 sm:h-96 object-contain rounded-xl"
            />
          </div>
          <div class="lg:col-span-5 space-y-6">
            <div>
              <span class="text-xs uppercase tracking-widest text-amber-400 font-bold">Typology Specifications</span>
              <h3 class="font-cinzel text-2xl font-bold text-white mt-1">{{ currentUnit.unit_type }}</h3>
            </div>

            <div class="space-y-3 text-xs">
              <div class="flex justify-between py-2 border-b border-slate-800">
                <span class="text-slate-400">Super Built-up Area</span>
                <strong class="text-white font-mono text-sm">{{ currentUnit.size_sqft?.toLocaleString() }} SFT</strong>
              </div>
              <div class="flex justify-between py-2 border-b border-slate-800">
                <span class="text-slate-400">Bedrooms Configuration</span>
                <strong class="text-white">{{ currentUnit.bedrooms }} Master Suites</strong>
              </div>
              <div class="flex justify-between py-2 border-b border-slate-800">
                <span class="text-slate-400">Bathrooms & Powder Room</span>
                <strong class="text-white">{{ currentUnit.bathrooms }} Designer Baths</strong>
              </div>
              <div class="flex justify-between py-2 border-b border-slate-800">
                <span class="text-slate-400">Balconies / Sky Terraces</span>
                <strong class="text-white">{{ currentUnit.balconies || 3 }} Verandas</strong>
              </div>
              <div class="flex justify-between py-2 border-b border-slate-800">
                <span class="text-slate-400">Estimated Unit Price</span>
                <strong class="text-amber-400 font-mono text-sm">{{ formatCurrency(currentUnit.price) }}</strong>
              </div>
            </div>

            <button 
              @click="$emit('open-vip-modal', property.name + ' (' + currentUnit.unit_type + ')')"
              class="w-full py-3 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-wider hover:shadow-lg hover:shadow-amber-500/20 transition-all cursor-pointer"
            >
              Request Floorplan Blueprint & Pricing
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. LOCATION & NEIGHBORHOOD MAP -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
      <div class="space-y-2">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Strategic Prime Location</span>
        <h2 class="font-cinzel text-2xl sm:text-3xl font-bold text-white">Neighborhood Context & Landmarks</h2>
      </div>

      <div class="h-96 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl">
        <InteractiveMap 
          :properties="[property]" 
          :selected-property-id="property.id" 
        />
      </div>

      <div v-if="parsedLandmarks.length > 0" class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
        <div 
          v-for="(lm, idx) in parsedLandmarks" 
          :key="idx"
          class="p-3.5 rounded-2xl bg-slate-900/60 border border-slate-800 flex items-center gap-3 text-xs"
        >
          <i class="bx bx-compass text-amber-400 text-lg"></i>
          <span class="text-slate-300">{{ lm.name }}</span>
        </div>
      </div>
    </section>

    <!-- HIDDEN CLEAN PRINTABLE BROCHURE TEMPLATE FOR HTML2PDF -->
    <div style="display: none;">
      <div id="pdf-brochure-sheet" style="font-family: Arial, sans-serif; background: #ffffff; color: #1e293b; padding: 40px; width: 800px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d97706; padding-bottom: 20px; margin-bottom: 25px;">
          <div>
            <h1 style="margin: 0; font-size: 28px; color: #0f172a; font-weight: bold; letter-spacing: 1px;">AL-NOOR PROPERTIES BD</h1>
            <p style="margin: 4px 0 0; font-size: 11px; color: #b45309; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;">Luxury Architectural Fact Sheet & Brochure</p>
          </div>
          <div style="text-align: right;">
            <span style="display: inline-block; background: #fef3c7; color: #92400e; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
              {{ property.status === 'completed' ? 'Ready for Handover' : 'Ongoing Construction' }}
            </span>
          </div>
        </div>

        <!-- Property Title & Image -->
        <div style="margin-bottom: 25px;">
          <h2 style="font-size: 24px; color: #0f172a; margin: 0 0 6px;">{{ property.name }}</h2>
          <p style="margin: 0 0 15px; font-size: 12px; color: #64748b;">{{ property.address }}, Dhaka, Bangladesh | Category: {{ property.property_type }}</p>
          <img :src="activeImage" style="width: 100%; height: 320px; object-fit: cover; border-radius: 12px; border: 1px solid #e2e8f0;" />
        </div>

        <!-- Specs Grid -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 25px;">
          <h3 style="margin: 0 0 12px; font-size: 14px; color: #0f172a; text-transform: uppercase; letter-spacing: 1px;">Key Technical Specifications</h3>
          <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
            <tr>
              <td style="padding: 6px 0; color: #64748b;">Pricing Portfolio:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #b45309;">{{ formatCurrency(property.price_from) }}</td>
              <td style="padding: 6px 0; color: #64748b;">Apartment Sizes:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #0f172a;">{{ property.sqft_from }} - {{ property.sqft_to }} SFT</td>
            </tr>
            <tr>
              <td style="padding: 6px 0; color: #64748b;">Bedrooms:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #0f172a;">{{ property.bedrooms }} Master Suites</td>
              <td style="padding: 6px 0; color: #64748b;">Target Handover:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #0f172a;">{{ property.completion_date || 'Q4 2027' }}</td>
            </tr>
            <tr>
              <td style="padding: 6px 0; color: #64748b;">Land Area:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #0f172a;">{{ property.land_area || '15 Katha' }}</td>
              <td style="padding: 6px 0; color: #64748b;">Location:</td>
              <td style="padding: 6px 0; font-weight: bold; color: #0f172a;">{{ property.location?.name || property.address }}</td>
            </tr>
          </table>
        </div>

        <!-- Description -->
        <div style="margin-bottom: 25px;">
          <h3 style="margin: 0 0 8px; font-size: 14px; color: #0f172a; text-transform: uppercase; letter-spacing: 1px;">Architectural Overview</h3>
          <p style="font-size: 11px; line-height: 1.6; color: #334155; margin: 0;">{{ property.description }}</p>
        </div>

        <!-- Amenities -->
        <div style="margin-bottom: 25px;" v-if="parsedAmenities.length > 0">
          <h3 style="margin: 0 0 10px; font-size: 14px; color: #0f172a; text-transform: uppercase; letter-spacing: 1px;">Signature Amenities</h3>
          <div style="display: flex; flex-wrap: wrap; gap: 8px;">
            <span v-for="(am, i) in parsedAmenities" :key="i" style="background: #e2e8f0; color: #1e293b; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: bold;">
              • {{ am }}
            </span>
          </div>
        </div>

        <!-- Concierge Footer -->
        <div style="border-top: 1px solid #cbd5e1; padding-top: 15px; display: flex; justify-content: space-between; align-items: center; font-size: 10px; color: #64748b;">
          <div>
            <strong>Al-Noor Properties BD Concierge</strong><br>
            Hotline: +880 1700-000000 | Email: concierge@alnoorbd.com<br>
            Level 12, Gulshan Avenue Tower, Gulshan-2, Dhaka 1212
          </div>
          <div style="text-align: right;">
            <span>www.alnoorbd.com</span><br>
            <span>Verified Architectural Document</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div v-else class="min-h-screen flex items-center justify-center text-center p-8">
    <div class="space-y-4">
      <div class="w-12 h-12 rounded-full border-2 border-amber-400 border-t-transparent animate-spin mx-auto"></div>
      <p class="text-slate-300 text-sm">Loading architectural details...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useSeoMeta } from '@unhead/vue';
import axios from 'axios';
import html2pdf from 'html2pdf.js';
import InteractiveMap from '../components/InteractiveMap.vue';

const route = useRoute();
defineEmits(['open-vip-modal']);

const property = ref(null);
const hasBrochure = computed(() => {
  return property.value?.brochure_pdf && 
         property.value.brochure_pdf !== '#' && 
         property.value.brochure_pdf.trim() !== '';
});
const activeImage = ref('');
const activeImageCaption = ref('');
const activeImageIndex = ref(0);
const selectedUnitIndex = ref(0);
const generatingPdf = ref(false);
const shareMenuOpen = ref(false);
const linkCopied = ref(false);

// Dynamic Reactive SEO Metadata with @unhead/vue
useSeoMeta({
  title: () => property.value ? `${property.value.name} | Luxury Real Estate Dhaka | Al-Noor Properties` : 'Luxury Property | Al-Noor Properties BD',
  description: () => property.value ? property.value.description?.slice(0, 160) : 'Explore ultra-luxury residential towers and penthouses in Dhaka with Al-Noor Properties BD.',
  ogTitle: () => property.value ? property.value.name : 'Al-Noor Luxury Real Estate',
  ogDescription: () => property.value ? property.value.description?.slice(0, 160) : 'Luxury Real Estate in Dhaka',
  ogImage: () => activeImage.value || '/images/logo.jpeg',
  twitterCard: 'summary_large_image',
});

// Social Share URLs
const currentUrl = computed(() => window.location.href);
const whatsappShareUrl = computed(() => {
  if (!property.value) return '#';
  const text = `Check out ${property.value.name} by Al-Noor Properties BD: ${currentUrl.value}`;
  return `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
});
const facebookShareUrl = computed(() => {
  return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl.value)}`;
});
const linkedinShareUrl = computed(() => {
  return `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(currentUrl.value)}`;
});

const copyShareLink = async () => {
  try {
    await navigator.clipboard.writeText(currentUrl.value);
    linkCopied.value = true;
    setTimeout(() => {
      linkCopied.value = false;
      shareMenuOpen.value = false;
    }, 1800);
  } catch (err) {
    console.error('Failed to copy link', err);
  }
};

// PDF Fact Sheet Generation via html2pdf.js
const downloadBrochure = async () => {
  const element = document.getElementById('pdf-brochure-sheet');
  if (!element || !property.value) return;

  generatingPdf.value = true;
  const opt = {
    margin: 10,
    filename: `Al-Noor-${property.value.name.replace(/\s+/g, '-')}-Brochure.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2, useCORS: true },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  };

  try {
    await html2pdf().set(opt).from(element).save();
  } catch (err) {
    console.error('PDF generation error:', err);
  } finally {
    generatingPdf.value = false;
  }
};

const allImages = computed(() => {
  if (!property.value) return [];
  const list = [];
  if (property.value.featured_image) {
    list.push({ image_path: property.value.featured_image, caption: property.value.name + ' (Signature Facade)' });
  }
  if (property.value.gallery && Array.isArray(property.value.gallery)) {
    property.value.gallery.forEach(img => list.push(img));
  }
  return list;
});

const currentUnit = computed(() => {
  if (!property.value?.units || property.value.units.length === 0) return null;
  return property.value.units[selectedUnitIndex.value] || property.value.units[0];
});

const parsedAmenities = computed(() => {
  if (!property.value?.amenities) return ['24/7 Security Concierge', 'Double Height Lobby', 'Infinity Pool', 'Private Elevator Access', 'Solar Energy Backup', 'EV Charging Bays'];
  if (Array.isArray(property.value.amenities)) return property.value.amenities;
  try {
    return JSON.parse(property.value.amenities);
  } catch {
    return property.value.amenities.split(',').map(s => s.trim());
  }
});

const parsedLandmarks = computed(() => {
  if (!property.value?.nearby_landmarks) return [];
  if (Array.isArray(property.value.nearby_landmarks)) return property.value.nearby_landmarks;
  try {
    return JSON.parse(property.value.nearby_landmarks);
  } catch {
    return [];
  }
});

const setActiveImage = (path, caption, index) => {
  activeImage.value = path;
  activeImageCaption.value = caption;
  activeImageIndex.value = index;
};

const formatCurrency = (val) => {
  if (!val || isNaN(val)) return 'Price on Confidential Request';
  const num = Number(val);
  if (num >= 10000000) {
    return `BDT ${(num / 10000000).toFixed(2)} Crore`;
  } else if (num >= 100000) {
    return `BDT ${(num / 100000).toFixed(2)} Lakh`;
  }
  return `BDT ${num.toLocaleString()}`;
};

const getAmenityIcon = (name) => {
  const n = (name || '').toLowerCase();
  if (n.includes('pool')) return 'bx bx-water';
  if (n.includes('gym') || n.includes('fitness')) return 'bx bx-dumbbell';
  if (n.includes('garden') || n.includes('park') || n.includes('landscape')) return 'bx bx-leaf';
  if (n.includes('security') || n.includes('cctv') || n.includes('guard')) return 'bx bx-shield-quarter';
  if (n.includes('lift') || n.includes('elevator')) return 'bx bx-up-arrow-circle';
  if (n.includes('parking') || n.includes('car') || n.includes('ev')) return 'bx bx-car';
  if (n.includes('generator') || n.includes('solar') || n.includes('power')) return 'bx bx-bolt-circle';
  if (n.includes('lounge') || n.includes('lobby') || n.includes('concierge')) return 'bx bx-building';
  return 'bx bx-check-shield';
};

const fetchProperty = async () => {
  try {
    const id = route.params.id;
    const res = await axios.get(`/api/properties/${id}`);
    if (res.data?.data) {
      property.value = res.data.data;
      if (allImages.value.length > 0) {
        activeImage.value = allImages.value[0].image_path;
        activeImageCaption.value = allImages.value[0].caption;
        activeImageIndex.value = 0;
      }
    }
  } catch (err) {
    console.error('Failed to load property:', err);
  }
};

onMounted(() => {
  fetchProperty();
});
</script>
