<template>
  <footer class="bg-[#05080e] border-t border-amber-500/15 pt-16 pb-12 text-slate-400 relative overflow-hidden">
    <!-- Subtle Ambient Glow -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
        
        <!-- Column 1: Brand & Bio -->
        <div class="lg:col-span-2 space-y-5">
          <div class="flex items-center gap-3">
            <div class="p-0.5 rounded-lg bg-gradient-to-r from-amber-400 to-amber-600">
              <img src="/images/logo.jpeg" alt="Al-Noor Properties BD" class="h-10 w-10 object-cover rounded-md" />
            </div>
            <div>
              <span class="font-cinzel text-lg font-bold tracking-wider text-white">AL-NOOR</span>
              <p class="text-[10px] tracking-[0.2em] text-amber-400 uppercase font-medium">PROPERTIES BD</p>
            </div>
          </div>

          <p class="text-sm text-slate-300 leading-relaxed pr-6">
            Crafting Dhaka’s finest luxury residences, visionary commercial landmarks, and high-yield joint venture partnerships in Gulshan, Banani, Dhanmondi, Bashundhara, and beyond.
          </p>

          <div class="pt-2 flex items-center gap-3">
            <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://linkedin.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
            </a>
            <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-500/40 transition-colors">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="space-y-4">
          <h4 class="text-white text-sm font-semibold tracking-wider uppercase font-cinzel">Quick Links</h4>
          <ul class="space-y-2.5 text-sm">
            <li><router-link to="/properties" class="hover:text-amber-400 transition-colors">All Properties</router-link></li>
            <li><router-link to="/properties?status=ongoing" class="hover:text-amber-400 transition-colors">Ongoing Projects</router-link></li>
            <li><router-link to="/properties?status=ready" class="hover:text-amber-400 transition-colors">Ready Apartments</router-link></li>
            <li><router-link to="/landowners" class="hover:text-amber-400 transition-colors">Landowners Portal</router-link></li>
            <li><router-link to="/construction-updates" class="hover:text-amber-400 transition-colors">Live Progress Tracker</router-link></li>
          </ul>
        </div>

        <!-- Column 3: Prime Locations -->
        <div class="space-y-4">
          <h4 class="text-white text-sm font-semibold tracking-wider uppercase font-cinzel">Prime Locations</h4>
          <ul class="space-y-2.5 text-sm">
            <li><router-link to="/properties?search=Gulshan" class="hover:text-amber-400 transition-colors">Gulshan Diplomatic Zone</router-link></li>
            <li><router-link to="/properties?search=Banani" class="hover:text-amber-400 transition-colors">Banani Lakefront</router-link></li>
            <li><router-link to="/properties?search=Dhanmondi" class="hover:text-amber-400 transition-colors">Dhanmondi Lake Enclave</router-link></li>
            <li><router-link to="/properties?search=Bashundhara" class="hover:text-amber-400 transition-colors">Bashundhara R/A</router-link></li>
            <li><router-link to="/properties?search=Uttara" class="hover:text-amber-400 transition-colors">Uttara Model Town</router-link></li>
          </ul>
        </div>

        <!-- Column 4: Contact & Concierge -->
        <div class="space-y-4">
          <h4 class="text-white text-sm font-semibold tracking-wider uppercase font-cinzel">Headquarters</h4>
          <p class="text-xs leading-relaxed text-slate-300">
            Al-Noor Tower, Level 12-14, Plot 88, Road 11, Block D, Banani, Dhaka-1213
          </p>
          <div class="space-y-1.5 text-xs text-slate-300">
            <p><span class="text-amber-400 font-medium">Hotline:</span> 16688</p>
            <p><span class="text-amber-400 font-medium">Direct:</span> +880 1894-916600</p>
            <p><span class="text-amber-400 font-medium">Email:</span> sales@alnoorpropertiesbd.com</p>
            <p><span class="text-amber-400 font-medium">Hours:</span> Sat - Thu: 9:00 AM - 7:00 PM</p>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-300">
        <p>© {{ new Date().getFullYear() }} Al-Noor Properties BD. All rights reserved. Crafted with architectural precision.</p>
        <div class="flex items-center gap-6">
          <a href="/admin" target="_blank" class="text-amber-400 hover:underline">Admin Portal</a>
          <router-link to="/about" class="hover:text-white transition-colors">Privacy Policy</router-link>
          <router-link to="/about" class="hover:text-white transition-colors">Terms of Service</router-link>
        </div>
      </div>
    </div>
  </footer>
</template>
