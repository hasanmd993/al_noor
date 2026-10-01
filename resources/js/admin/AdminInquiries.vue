<template>
  <div class="space-y-6" @click="closeDropdowns">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Inquiries & VIP Leads Inbox</h1>
        <p class="text-xs text-slate-400">Manage Landowner JVs, private tour bookings, and client contacts</p>
      </div>
      <div class="flex items-center gap-2">
        <button 
          v-for="f in ['all', 'landowner', 'property_inquiry', 'contact_form']" 
          :key="f"
          @click="activeFilter = f"
          :class="[
            'px-3 py-1.5 rounded-xl text-xs font-bold capitalize transition-colors',
            activeFilter === f ? 'bg-[#696cff] text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'
          ]"
        >
          {{ f === 'landowner' ? 'Landowner JV' : f === 'property_inquiry' ? 'VIP Tours' : f === 'contact_form' ? 'Contact' : 'All Leads' }}
        </button>
      </div>
    </div>

    <!-- Inquiries List -->
    <div class="bg-white rounded-2xl border border-[#e7e7e8] shadow-sm">
      <div class="overflow-x-auto min-h-[300px]">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-[#e7e7e8]">
            <tr>
              <th class="px-6 py-3.5">Client Contact</th>
              <th class="px-4 py-3.5">Channel / Type</th>
              <th class="px-4 py-3.5">Interest / Message</th>
              <th class="px-4 py-3.5">Received Date</th>
              <th class="px-4 py-3.5">Status</th>
              <th class="px-6 py-3.5 text-right">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-600">
            <tr v-for="inq in filteredInquiries" :key="inq.id" class="hover:bg-slate-50/80 transition-colors">
              <td class="px-6 py-3.5">
                <div class="font-bold text-slate-800 text-sm">{{ inq.name }}</div>
                <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                  <i class="bx bx-envelope"></i> {{ inq.email }}
                </div>
                <div v-if="inq.phone" class="text-[11px] text-slate-500 flex items-center gap-1.5">
                  <i class="bx bx-phone"></i> {{ inq.phone }}
                </div>
              </td>
              <td class="px-4 py-3.5">
                <span 
                  :class="[
                    'px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider',
                    inq.source === 'landowner' ? 'bg-amber-100 text-amber-800' :
                    inq.source === 'property_inquiry' ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-700'
                  ]"
                >
                  {{ inq.source === 'landowner' ? 'Landowner JV' : inq.source === 'property_inquiry' ? 'VIP Tour' : 'General' }}
                </span>
              </td>
              <td class="px-4 py-3.5">
                <div class="font-semibold text-slate-700 truncate max-w-xs">{{ inq.property_interest || inq.subject }}</div>
                <div class="text-[11px] text-slate-400 truncate max-w-xs mt-0.5">{{ inq.message }}</div>
              </td>
              <td class="px-4 py-3.5 text-slate-500">
                {{ new Date(inq.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }}
              </td>
              <td class="px-4 py-3.5">
                <select 
                  v-model="inq.status" 
                  @change="updateStatus(inq)" 
                  class="px-2.5 py-1 text-[11px] font-bold rounded-lg border border-slate-200 outline-none bg-slate-50 text-slate-700"
                >
                  <option value="new">New</option>
                  <option value="contacted">Contacted</option>
                  <option value="meeting_scheduled">Meeting Scheduled</option>
                  <option value="closed">Closed / Won</option>
                </select>
              </td>
              <td class="px-6 py-3.5 text-right relative">
                <div class="inline-block text-left">
                  <button 
                    @click.stop="toggleDropdown(inq.id)" 
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                  >
                    <i class="bx bx-dots-vertical-rounded text-lg"></i>
                  </button>

                  <div 
                    v-if="activeDropdown === inq.id" 
                    class="absolute right-6 mt-1 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in duration-100 text-left"
                  >
                    <button 
                      @click="openModal(inq)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-[#696cff] w-full"
                    >
                      <i class="bx bx-show text-sm"></i> View Details
                    </button>
                    <div class="border-t border-slate-100 my-1"></div>
                    <button 
                      @click="deleteInquiry(inq.id)" 
                      class="flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 w-full font-medium"
                    >
                      <i class="bx bx-trash text-sm"></i> Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="filteredInquiries.length === 0">
              <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                No inquiries found in this category.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal for Detailed Inquiry -->
    <div v-if="selectedInquiry" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
          <h3 class="text-base font-bold text-slate-800">Inquiry Details</h3>
          <button @click="selectedInquiry = null" class="text-slate-400 hover:text-slate-600">
            <i class="bx bx-x text-2xl"></i>
          </button>
        </div>

        <div class="space-y-3 text-xs">
          <div>
            <span class="text-slate-400 uppercase font-bold text-[10px]">Client Name:</span>
            <p class="font-bold text-slate-800 text-sm">{{ selectedInquiry.name }}</p>
          </div>
          <div class="grid grid-cols-2 gap-2">
            <div>
              <span class="text-slate-400 uppercase font-bold text-[10px]">Email:</span>
              <p class="font-medium text-slate-700">{{ selectedInquiry.email }}</p>
            </div>
            <div>
              <span class="text-slate-400 uppercase font-bold text-[10px]">Phone:</span>
              <p class="font-medium text-slate-700">{{ selectedInquiry.phone || 'N/A' }}</p>
            </div>
          </div>
          <div>
            <span class="text-slate-400 uppercase font-bold text-[10px]">Subject / Interested Project:</span>
            <p class="font-semibold text-slate-800">{{ selectedInquiry.property_interest || selectedInquiry.subject }}</p>
          </div>
          <div>
            <span class="text-slate-400 uppercase font-bold text-[10px]">Message:</span>
            <div class="p-3 bg-slate-50 rounded-xl text-slate-700 whitespace-pre-wrap leading-relaxed border border-slate-200 mt-1">
              {{ selectedInquiry.message }}
            </div>
          </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
          <button @click="selectedInquiry = null" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const inquiries = ref([]);
const activeFilter = ref('all');
const selectedInquiry = ref(null);
const activeDropdown = ref(null);

const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const loadInquiries = async () => {
  try {
    const res = await axios.get('/api/admin/inquiries');
    inquiries.value = res.data.data || [];
  } catch (err) {
    console.error('Failed to load inquiries:', err);
  }
};

const filteredInquiries = computed(() => {
  if (activeFilter.value === 'all') return inquiries.value;
  return inquiries.value.filter(i => i.source === activeFilter.value);
});

const openModal = (inq) => {
  selectedInquiry.value = inq;
  activeDropdown.value = null;
  if (!inq.is_read) {
    inq.is_read = true;
    axios.put(`/api/admin/inquiries/${inq.id}`, { is_read: true });
  }
};

const updateStatus = async (inq) => {
  try {
    await axios.put(`/api/admin/inquiries/${inq.id}`, { status: inq.status });
  } catch (err) {
    alert('Failed to update status.');
  }
};

const deleteInquiry = async (id) => {
  if (!confirm('Are you sure you want to delete this inquiry?')) return;
  try {
    await axios.delete(`/api/admin/inquiries/${id}`);
    inquiries.value = inquiries.value.filter(i => i.id !== id);
  } catch (err) {
    alert('Failed to delete inquiry.');
  }
};

onMounted(() => {
  loadInquiries();
});
</script>
