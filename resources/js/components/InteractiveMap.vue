<template>
  <div class="relative w-full rounded-2xl overflow-hidden border border-amber-500/20 shadow-2xl bg-[#080d1a]">
    <!-- Map Container -->
    <div :id="mapId" class="w-full h-[450px] md:h-[550px] z-10"></div>

    <!-- Map Top Floating Bar -->
    <div class="absolute top-4 left-4 right-4 z-20 flex flex-wrap items-center justify-between gap-3 pointer-events-none">
      <div class="px-4 py-2 rounded-xl bg-[#070a11]/90 backdrop-blur-md border border-amber-500/30 text-xs font-semibold text-white pointer-events-auto flex items-center gap-2 shadow-lg">
        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
        <span>Dhaka Prime Real Estate Map ({{ properties.length }} Projects)</span>
      </div>

      <div class="hidden sm:flex items-center gap-2 pointer-events-auto">
        <button 
          v-for="zone in ['All', 'Gulshan', 'Banani', 'Dhanmondi', 'Bashundhara', 'Uttara']" 
          :key="zone"
          @click="filterByZone(zone)"
          :class="[
            'px-3 py-1.5 rounded-lg text-xs font-medium backdrop-blur-md transition-all',
            selectedZone === zone 
              ? 'gold-gradient-bg text-slate-950 font-bold shadow-md' 
              : 'bg-[#070a11]/80 text-slate-300 hover:text-white border border-slate-700/60'
          ]"
        >
          {{ zone }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import L from 'leaflet';

const props = defineProps({
  properties: {
    type: Array,
    default: () => []
  },
  selectedProperty: {
    type: Object,
    default: null
  },
  mapId: {
    type: String,
    default: 'leaflet-map'
  },
  center: {
    type: Array,
    default: () => [23.7925, 90.4078] // Default Dhaka Center (Banani / Gulshan)
  },
  zoom: {
    type: Number,
    default: 12
  }
});

const emit = defineEmits(['select-property']);
const selectedZone = ref('All');
let map = null;
let markersLayer = null;

const initMap = () => {
  if (map) return;

  const container = document.getElementById(props.mapId);
  if (!container) return;

  // Initialize map
  map = L.map(props.mapId, {
    center: props.center,
    zoom: props.zoom,
    zoomControl: true,
    scrollWheelZoom: false
  });

  // Dark Luxury CartoDB Map Tiles
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://carto.com/">CARTO</a> | &copy; OpenStreetMap contributors',
    subdomains: 'abcd',
    maxZoom: 19
  }).addTo(map);

  markersLayer = L.layerGroup().addTo(map);
  renderMarkers();
};

const renderMarkers = () => {
  if (!map || !markersLayer) return;
  markersLayer.clearLayers();

  const filtered = selectedZone.value === 'All' 
    ? props.properties 
    : props.properties.filter(p => {
        const addr = (p.address || '') + ' ' + (p.name || '');
        return addr.toLowerCase().includes(selectedZone.value.toLowerCase());
      });

  const bounds = [];

  filtered.forEach(prop => {
    if (!prop.latitude || !prop.longitude) return;

    const lat = parseFloat(prop.latitude);
    const lng = parseFloat(prop.longitude);
    bounds.push([lat, lng]);

    // Custom Gold Luxury Icon
    const customIcon = L.divIcon({
      className: 'custom-map-icon',
      html: `
        <div style="
          background: linear-gradient(135deg, #d4a751 0%, #a77728 100%);
          color: #070a11;
          font-weight: 800;
          font-size: 11px;
          padding: 6px 10px;
          border-radius: 20px;
          border: 2px solid #ffffff;
          box-shadow: 0 4px 15px rgba(0,0,0,0.5), 0 0 12px rgba(212, 167, 81, 0.7);
          white-space: nowrap;
          cursor: pointer;
          display: flex;
          align-items: center;
          gap: 5px;
        ">
          <span style="display:inline-block;width:6px;height:6px;background:#070a11;border-radius:50%;"></span>
          <span>${prop.name.replace('Al-Noor ', '')}</span>
        </div>
      `,
      iconSize: [120, 30],
      iconAnchor: [60, 15]
    });

    const marker = L.marker([lat, lng], { icon: customIcon });

    // Luxury Popup Card
    const popupContent = `
      <div style="width: 260px; font-family: 'Plus Jakarta Sans', sans-serif; background: #0c1220; color: #f8fafc; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.8);">
        <div style="position: relative; height: 130px; overflow: hidden;">
          <img src="${prop.featured_image || 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=600&q=80'}" style="width: 100%; height: 100%; object-fit: cover;" />
          <span style="position: absolute; top: 8px; right: 8px; background: #c6923b; color: #000; font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 2px 8px; border-radius: 10px;">
            ${prop.status || 'Ongoing'}
          </span>
        </div>
        <div style="padding: 12px;">
          <h4 style="font-size: 14px; font-weight: 700; color: #ffffff; margin: 0 0 4px 0;">${prop.name}</h4>
          <p style="font-size: 11px; color: #94a3b8; margin: 0 0 8px 0;">📍 ${prop.address || 'Dhaka, Bangladesh'}</p>
          <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #1e293b; padding-top: 8px;">
            <div>
              <span style="font-size: 9px; text-transform: uppercase; color: #64748b; display: block;">Price</span>
              <strong style="font-size: 12px; color: #f59e0b;">${prop.price_label || 'Inquire Price'}</strong>
            </div>
            <a href="/properties/${prop.id}" style="background: #d4a751; color: #070a11; text-decoration: none; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px;">
              View Details →
            </a>
          </div>
        </div>
      </div>
    `;

    marker.bindPopup(popupContent, { maxWidth: 300, minWidth: 260 });
    marker.on('click', () => {
      emit('select-property', prop);
    });

    markersLayer.addLayer(marker);
  });

  if (bounds.length > 0 && selectedZone.value === 'All') {
    map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
  }
};

const filterByZone = (zone) => {
  selectedZone.value = zone;
  renderMarkers();

  const zoneCoords = {
    'Gulshan': [23.7925, 90.4152],
    'Banani': [23.7937, 90.4066],
    'Dhanmondi': [23.7461, 90.3742],
    'Bashundhara': [23.8191, 90.4357],
    'Uttara': [23.8759, 90.3795],
  };

  if (zoneCoords[zone] && map) {
    map.flyTo(zoneCoords[zone], 14, { duration: 1.2 });
  } else if (zone === 'All' && map) {
    map.flyTo(props.center, props.zoom, { duration: 1.2 });
  }
};

watch(() => props.properties, () => {
  renderMarkers();
}, { deep: true });

watch(() => props.selectedProperty, (newVal) => {
  if (newVal && newVal.latitude && newVal.longitude && map) {
    map.flyTo([newVal.latitude, newVal.longitude], 15, { duration: 1.2 });
  }
});

onMounted(() => {
  setTimeout(() => {
    initMap();
  }, 100);
});

onBeforeUnmount(() => {
  if (map) {
    map.remove();
    map = null;
  }
});
</script>
