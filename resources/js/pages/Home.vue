<template>
  <div class="space-y-24 pb-20">
    
    <!-- 1. LUXURY HERO SLIDER SECTION -->
    <section class="relative min-h-[90vh] lg:min-h-screen flex items-center justify-center overflow-hidden pt-20">
      <!-- Background Slider Images with Crossfade -->
      <div 
        v-for="(slide, idx) in heroSlides" 
        :key="idx"
        :class="[
          'absolute inset-0 bg-cover bg-center transition-opacity duration-1000 transform scale-105 transition-transform duration-[10000ms] ease-out',
          currentSlide === idx ? 'opacity-100 scale-100' : 'opacity-0 pointer-events-none'
        ]"
        :style="{ backgroundImage: `url('${slide.image}')` }"
      >
        <!-- Dark Luxury Overlay Gradients -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#070a11]/95 via-[#070a11]/70 to-[#070a11]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#070a11] via-transparent to-transparent"></div>
      </div>

      <!-- Hero Content Container -->
      <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
        <div class="max-w-3xl space-y-6">
          
          <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs font-semibold tracking-wider uppercase backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            <span>{{ heroSlides[currentSlide]?.tag || 'Al-Noor Signature Collection 2026' }}</span>
          </div>

          <h1 class="font-cinzel text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] tracking-tight">
            {{ heroSlides[currentSlide]?.title || 'Architectural Landmarks Redefining Dhaka’s Skyline' }}
          </h1>

          <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-light">
            {{ heroSlides[currentSlide]?.subtitle || 'Pioneering ultra-luxury residences, sky duplexes, and prime joint venture estates with uncompromising craftsmanship.' }}
          </p>

          <!-- CTAs -->
          <div class="pt-4 flex flex-wrap items-center gap-4">
            <router-link 
              to="/properties" 
              class="px-8 py-3.5 rounded-full text-xs sm:text-sm uppercase tracking-widest font-bold gold-gradient-bg text-slate-950 hover:shadow-xl hover:shadow-amber-500/25 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2"
            >
              <span>Explore Collection</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </router-link>

            <button 
              @click="$emit('open-vip-modal')"
              class="px-7 py-3.5 rounded-full text-xs sm:text-sm uppercase tracking-widest font-semibold text-white bg-slate-900/80 hover:bg-slate-800 border border-slate-700/80 hover:border-amber-500/40 backdrop-blur-md transition-all duration-300 flex items-center gap-2"
            >
              <span>Book VIP Viewing</span>
            </button>

            <router-link 
              to="/landowners" 
              class="text-xs sm:text-sm font-medium text-amber-400 hover:text-amber-300 underline underline-offset-8 transition-colors flex items-center gap-1.5"
            >
              <span>Landowner Joint Venture</span>
              <span>→</span>
            </router-link>
          </div>

        </div>
      </div>

      <!-- Slider Indicators / Controls -->
      <div class="absolute bottom-8 right-8 z-30 flex items-center gap-2 bg-[#070a11]/80 backdrop-blur-md px-4 py-2 rounded-full border border-slate-800">
        <button 
          v-for="(_, sIdx) in heroSlides" 
          :key="sIdx"
          @click="currentSlide = sIdx"
          aria-label="Go to Slide"
          :class="[
            'h-2 rounded-full transition-all duration-300',
            currentSlide === sIdx ? 'w-8 bg-amber-400' : 'w-2 bg-slate-600 hover:bg-slate-400'
          ]"
        ></button>
      </div>
    </section>

    <!-- 2. QUICK SEARCH / PROPERTY FILTER BAR -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-30">
      <div class="glass-panel p-6 md:p-8 rounded-3xl border border-amber-500/25 shadow-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          
          <!-- Location Filter -->
          <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Prime Location</label>
            <select 
              v-model="searchFilter.location" 
              class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition-colors"
            >
              <option value="">All Dhaka Locations</option>
              <option value="Gulshan 2">Gulshan 2 (Diplomatic)</option>
              <option value="Banani">Banani Lakefront</option>
              <option value="Dhanmondi">Dhanmondi Lake Enclave</option>
              <option value="Bashundhara R/A">Bashundhara R/A</option>
              <option value="Uttara">Uttara Model Town</option>
              <option value="Purbachal">Purbachal Smart City</option>
            </select>
          </div>

          <!-- Status Filter -->
          <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Project Status</label>
            <select 
              v-model="searchFilter.status" 
              class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition-colors"
            >
              <option value="">All Project Statuses</option>
              <option value="ongoing">Under Construction / Ongoing</option>
              <option value="ready">Ready to Handover</option>
              <option value="upcoming">Upcoming Signature Launches</option>
            </select>
          </div>

          <!-- Type Filter -->
          <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Property Type</label>
            <select 
              v-model="searchFilter.type" 
              class="w-full bg-[#070a11] border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition-colors"
            >
              <option value="">All Types</option>
              <option value="residential">Luxury Residential Suite</option>
              <option value="commercial">Commercial Landmark</option>
              <option value="duplex">Sky Penthouse & Duplex</option>
            </select>
          </div>

          <!-- Search Button -->
          <div class="flex items-end">
            <button 
              @click="applySearch"
              class="w-full py-3.5 rounded-xl gold-gradient-bg text-slate-950 font-bold text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 flex items-center justify-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <span>Find Residences</span>
            </button>
          </div>

        </div>
      </div>
    </section>

    <!-- 3. BRAND PILLARS & STATS (Like BTI / Rakeen) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2">
          <div class="font-cinzel text-3xl sm:text-4xl font-extrabold gold-gradient-text">25+</div>
          <p class="text-xs uppercase tracking-wider font-semibold text-slate-300">Years of Trust & Legacy</p>
          <p class="text-[11px] text-slate-300">Pioneering excellence since 2001</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2">
          <div class="font-cinzel text-3xl sm:text-4xl font-extrabold gold-gradient-text">3.5M+</div>
          <p class="text-xs uppercase tracking-wider font-semibold text-slate-300">Sq. Ft. Handed Over</p>
          <p class="text-[11px] text-slate-300">Dhaka's prime quadrants</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2">
          <div class="font-cinzel text-3xl sm:text-4xl font-extrabold gold-gradient-text">99.4%</div>
          <p class="text-xs uppercase tracking-wider font-semibold text-slate-300">On-Time Handover</p>
          <p class="text-[11px] text-slate-300">Zero compromise on milestones</p>
        </div>

        <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2">
          <div class="font-cinzel text-3xl sm:text-4xl font-extrabold gold-gradient-text">1,200+</div>
          <p class="text-xs uppercase tracking-wider font-semibold text-slate-300">Discerning Families</p>
          <p class="text-[11px] text-slate-300">Calling Al-Noor home</p>
        </div>
      </div>
    </section>

    <!-- 4. FEATURED SIGNATURE COLLECTION SHOWCASE -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
          <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-1">
            Handcrafted Masterpieces
          </span>
          <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
            Signature Collection
          </h2>
          <p class="text-sm text-slate-300 mt-2 max-w-xl">
            Explore our flagship architectural developments in Dhaka’s most coveted residential and commercial districts.
          </p>
        </div>

        <router-link 
          to="/properties" 
          class="inline-flex items-center gap-2 text-xs uppercase tracking-wider font-bold text-amber-400 hover:text-amber-300 transition-colors"
        >
          <span>View All Properties ({{ properties.length }})</span>
          <span>→</span>
        </router-link>
      </div>

      <!-- Properties Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="property in featuredProperties" 
          :key="property.id"
          class="glass-panel-hover rounded-3xl overflow-hidden border border-slate-800 bg-[#0d1322] flex flex-col group"
        >
          <!-- Image Container -->
          <div class="relative h-64 overflow-hidden">
            <img 
              :src="property.featured_image || 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80'" 
              :alt="property.name" 
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
            />
            
            <!-- Badges -->
            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
              <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider gold-gradient-bg text-slate-950 shadow-md">
                {{ property.status === 'completed' ? 'Ready' : (property.status === 'upcoming' ? 'Upcoming' : 'Ongoing') }}
              </span>
              <span v-if="property.is_featured" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/70 text-amber-300 border border-amber-500/40 backdrop-blur-md">
                ★ Signature
              </span>
            </div>

            <!-- Price Label Overlay -->
            <div class="absolute bottom-3 right-3 px-3 py-1.5 rounded-xl bg-[#070a11]/90 backdrop-blur-md border border-amber-500/30 text-xs font-bold text-amber-400">
              {{ property.price_label || 'Price on Inquiry' }}
            </div>
          </div>

          <!-- Card Body -->
          <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
            <div>
              <div class="flex items-center gap-2 text-xs text-amber-400/90 font-medium mb-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ property.location?.name || property.address }}</span>
              </div>

              <h3 class="font-cinzel text-xl font-bold text-white group-hover:text-amber-400 transition-colors">
                {{ property.name }}
              </h3>

              <p class="text-xs text-slate-300 line-clamp-2 mt-2 leading-relaxed">
                {{ property.short_description || property.description }}
              </p>
            </div>

            <!-- Specs Grid -->
            <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-800/80 text-center text-xs">
              <div>
                <span class="text-[10px] text-slate-300 block uppercase">Land Area</span>
                <strong class="text-white font-medium">{{ property.land_area }} Katha</strong>
              </div>
              <div>
                <span class="text-[10px] text-slate-300 block uppercase">Floors</span>
                <strong class="text-white font-medium">G+{{ property.total_floors }}</strong>
              </div>
              <div>
                <span class="text-[10px] text-slate-300 block uppercase">Progress</span>
                <strong class="text-amber-400 font-medium">{{ property.progress_percentage }}%</strong>
              </div>
            </div>

            <!-- Card Actions -->
            <div class="pt-2 flex items-center justify-between gap-3">
              <router-link 
                :to="`/properties/${property.id}`" 
                class="flex-1 py-2.5 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white font-semibold text-xs uppercase tracking-wider text-center transition-all duration-300"
              >
                View Details
              </router-link>

              <button 
                @click="$emit('open-vip-modal', property.name)"
                aria-label="Schedule Tour"
                class="p-2.5 rounded-xl border border-slate-700 hover:border-amber-400 text-slate-300 hover:text-amber-400 transition-colors"
                title="Book VIP Tour"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </button>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- 5. INTERACTIVE LEAFLET DHAKA PRIME LOCATIONS MAP -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
          Interactive Geospatial Explorer
        </span>
        <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
          Explore Projects Across Dhaka
        </h2>
        <p class="text-xs sm:text-sm text-slate-300">
          Navigate our active, upcoming, and ready architectural milestones in Gulshan, Banani, Dhanmondi, Bashundhara, and Uttara.
        </p>
      </div>

      <InteractiveMap :properties="properties" />
    </section>

    <!-- 6. SIGNATURE LANDOWNER JOINT VENTURE PROPOSITION (Like BTI / Rakeen) -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#0c1322] via-[#090e1a] to-[#060910] border-y border-amber-500/20 py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          
          <div class="lg:col-span-7 space-y-6">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 border border-amber-500/30 text-amber-400 inline-block">
              Landowner Partnership Programme
            </span>

            <h2 class="font-cinzel text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
              Transform Your Ancestral Land Into a Timeless Architectural Landmark
            </h2>

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-light">
              Are you a landowner in Gulshan, Banani, Dhanmondi, Uttara, or Bashundhara? Partner with Al-Noor Properties BD to maximize your capital appreciation, enjoy transparent joint-venture ratios, and secure on-time construction handover.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
              <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                  1
                </div>
                <div>
                  <h4 class="text-sm font-bold text-white">Highest Ratio & Signing Bonus</h4>
                  <p class="text-xs text-slate-300 mt-0.5">Transparent valuation models tailored to maximize landowner wealth.</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                  2
                </div>
                <div>
                  <h4 class="text-sm font-bold text-white">World-Class Architects</h4>
                  <p class="text-xs text-slate-300 mt-0.5">Singapore & Dhaka top-tier architects designing iconic façades.</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                  3
                </div>
                <div>
                  <h4 class="text-sm font-bold text-white">Guaranteed On-Time Delivery</h4>
                  <p class="text-xs text-slate-300 mt-0.5">Strict milestone commitments backed by bank guarantees.</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                  4
                </div>
                <div>
                  <h4 class="text-sm font-bold text-white">100% Legal & RAJUK Compliance</h4>
                  <p class="text-xs text-slate-300 mt-0.5">Zero hassle documentation, complete title due diligence.</p>
                </div>
              </div>
            </div>

            <div class="pt-4 flex items-center gap-4">
              <router-link 
                to="/landowners" 
                class="px-8 py-3.5 rounded-full text-xs uppercase tracking-widest font-bold gold-gradient-bg text-slate-950 hover:shadow-xl hover:shadow-amber-500/25 transition-all"
              >
                Submit Land for Free Valuation
              </router-link>
            </div>
          </div>

          <!-- Visual Landowner Showcase -->
          <div class="lg:col-span-5 relative">
            <div class="relative rounded-3xl overflow-hidden border border-amber-500/30 shadow-2xl">
              <img 
                src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80" 
                alt="Al-Noor Landowner Joint Venture" 
                class="w-full h-[460px] object-cover"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-[#070a11] via-transparent to-transparent"></div>
              
              <div class="absolute bottom-6 left-6 right-6 p-5 rounded-2xl bg-[#070a11]/90 backdrop-blur-md border border-slate-800">
                <span class="text-amber-400 text-xs font-bold uppercase tracking-wider block mb-1">Recent Joint Venture Success</span>
                <p class="text-sm font-bold text-white">Banani Road 11 Lakefront Mirage</p>
                <p class="text-xs text-slate-300 mt-1">"Partnered with Al-Noor on 14.5 Katha ancestral plot with 100% satisfaction." — Syed Nazmul Hasan</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 8. CLIENT & HOMEOWNER TESTIMONIALS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">
          Voices of Distinction
        </span>
        <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
          Client & Resident Testimonials
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div 
          v-for="t in testimonials" 
          :key="t.id"
          class="glass-panel p-8 rounded-3xl border border-slate-800 space-y-6 flex flex-col justify-between"
        >
          <div class="space-y-4">
            <div class="flex items-center gap-1 text-amber-400">
              <span v-for="i in t.rating" :key="i">★</span>
            </div>
            <p class="text-sm text-slate-300 leading-relaxed italic">
              "{{ t.quote }}"
            </p>
          </div>

          <div class="flex items-center gap-3 pt-4 border-t border-slate-800/80">
            <img :src="t.client_photo" :alt="t.client_name" class="w-11 h-11 rounded-full object-cover border border-amber-500/40" />
            <div>
              <h4 class="text-sm font-bold text-white">{{ t.client_name }}</h4>
              <p class="text-xs text-slate-300">{{ t.client_designation }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 9. JOURNAL & MARKET INSIGHTS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-800 pb-6">
        <div>
          <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-1">
            Industry Perspectives
          </span>
          <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
            Journal & Market Insights
          </h2>
        </div>

        <router-link to="/journal" class="text-xs uppercase tracking-wider font-bold text-amber-400 hover:text-amber-300 transition-colors">
          Read All Articles →
        </router-link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <article 
          v-for="blog in blogs" 
          :key="blog.id"
          class="glass-panel-hover rounded-3xl overflow-hidden border border-slate-800 bg-[#0d1322] flex flex-col"
        >
          <div class="h-48 overflow-hidden relative">
            <img :src="blog.featured_image" :alt="blog.title" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/80 text-amber-400 border border-amber-500/30">
              {{ blog.category }}
            </span>
          </div>

          <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
            <div>
              <span class="text-[11px] text-slate-300">{{ blog.author }} • {{ new Date(blog.published_at).toLocaleDateString() }}</span>
              <h3 class="font-cinzel text-lg font-bold text-white hover:text-amber-400 transition-colors mt-2">
                <router-link :to="`/journal/${blog.id}`">{{ blog.title }}</router-link>
              </h3>
              <p class="text-xs text-slate-300 line-clamp-2 mt-2 leading-relaxed">
                {{ blog.excerpt }}
              </p>
            </div>

            <router-link :to="`/journal/${blog.id}`" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition-colors flex items-center gap-1.5">
              <span>Read Full Article</span>
              <span>→</span>
            </router-link>
          </div>
        </article>
      </div>
    </section>

  </div>
</template>

<script setup>
import { useSeoMeta } from '@unhead/vue';

useSeoMeta({
  "title": "Al-Noor Properties BD | Dhaka's Premier Luxury Real Estate & Architectural Landmarks",
  "description": "Experience ultra-luxury residences, penthouses, and landmark architectural developments in Gulshan, Banani, and Dhanmondi.",
  "ogTitle": "Al-Noor Properties BD | Premier Real Estate Developers Dhaka",
  "ogDescription": "Crafting architectural legacy and timeless luxury living spaces in prime Dhaka locations.",
  "ogImage": "/images/logo.jpeg"
});

import { ref, reactive, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import InteractiveMap from '../components/InteractiveMap.vue';

const router = useRouter();
defineEmits(['open-vip-modal']);

const currentSlide = ref(0);
let slideInterval = null;

const heroSlides = ref([
  {
    title: 'Architectural Landmarks Redefining Dhaka’s Skyline',
    subtitle: 'Pioneering ultra-luxury residences, sky duplexes, and prime joint venture estates with uncompromising craftsmanship.',
    tag: 'Al-Noor Signature Collection 2026',
    image: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1920&q=90',
  },
  {
    title: 'Banani Lakefront Horizons: Tranquility Reimagined',
    subtitle: 'Unobstructed water vistas, cantilevered sky gardens, and double-height infinity living in Dhaka’s premier neighborhood.',
    tag: 'New Launch: Lakefront Mirage',
    image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=90',
  },
  {
    title: 'Empowering Landowners Through High-Yield Joint Ventures',
    subtitle: 'Unlock maximum property valuation, world-class architectural design, and guaranteed on-time handover with Al-Noor.',
    tag: 'Landowner Partnership',
    image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=90',
  }
]);

const properties = ref([]);
const featuredProperties = ref([]);
const testimonials = ref([]);
const blogs = ref([]);

const searchFilter = reactive({
  location: '',
  status: '',
  type: ''
});

const applySearch = () => {
  router.push({
    path: '/properties',
    query: {
      search: searchFilter.location,
      status: searchFilter.status,
      type: searchFilter.type
    }
  });
};

const fetchData = async () => {
  try {
    const [propRes, testRes, blogRes] = await Promise.all([
      axios.get('/api/properties'),
      axios.get('/api/testimonials'),
      axios.get('/api/blogs')
    ]);

    if (propRes.data?.data) {
      properties.value = propRes.data.data;
      featuredProperties.value = propRes.data.data.slice(0, 6);
    }
    if (testRes.data?.data) {
      testimonials.value = testRes.data.data;
    }
    if (blogRes.data?.data) {
      blogs.value = blogRes.data.data.slice(0, 3);
    }
  } catch (err) {
    console.error('Error fetching homepage data', err);
  }
};

onMounted(() => {
  fetchData();
  slideInterval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % heroSlides.value.length;
  }, 6000);
});

onBeforeUnmount(() => {
  if (slideInterval) clearInterval(slideInterval);
});
</script>
