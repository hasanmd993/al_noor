import { createRouter, createWebHistory } from 'vue-router';

// Public Pages
import Home from '../pages/Home.vue';
import Properties from '../pages/Properties.vue';
import PropertyDetail from '../pages/PropertyDetail.vue';
import Landowners from '../pages/Landowners.vue';
import About from '../pages/About.vue';
import ConstructionUpdates from '../pages/ConstructionUpdates.vue';
import Journal from '../pages/Journal.vue';
import JournalDetail from '../pages/JournalDetail.vue';
import Contact from '../pages/Contact.vue';

// Sneat Admin Components
import AdminLayout from '../admin/AdminLayout.vue';
import AdminLogin from '../admin/AdminLogin.vue';
import AdminDashboard from '../admin/AdminDashboard.vue';
import AdminProperties from '../admin/AdminProperties.vue';
import AdminPropertyForm from '../admin/AdminPropertyForm.vue';
import AdminInquiries from '../admin/AdminInquiries.vue';
import AdminLocations from '../admin/AdminLocations.vue';
import AdminCategories from '../admin/AdminCategories.vue';
import AdminBlogs from '../admin/AdminBlogs.vue';
import AdminTestimonials from '../admin/AdminTestimonials.vue';
import AdminSliders from '../admin/AdminSliders.vue';
import AdminSettings from '../admin/AdminSettings.vue';

const routes = [
  // --- Public Website Routes ---
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { title: 'Al-Noor Properties BD | Luxury Real Estate Dhaka' }
  },
  {
    path: '/properties',
    name: 'Properties',
    component: Properties,
    meta: { title: 'Signature Properties | Al-Noor Properties BD' }
  },
  {
    path: '/properties/:id',
    name: 'PropertyDetail',
    component: PropertyDetail,
    meta: { title: 'Property Details | Al-Noor Properties BD' }
  },
  {
    path: '/landowners',
    name: 'Landowners',
    component: Landowners,
    meta: { title: 'Landowner Joint Venture | Al-Noor Properties BD' }
  },
  {
    path: '/about',
    name: 'About',
    component: About,
    meta: { title: 'Heritage & Leadership | Al-Noor Properties BD' }
  },
  {
    path: '/construction-updates',
    name: 'ConstructionUpdates',
    component: ConstructionUpdates,
    meta: { title: 'Live Construction Updates | Al-Noor Properties BD' }
  },
  {
    path: '/journal',
    name: 'Journal',
    component: Journal,
    meta: { title: 'Real Estate Journal & Market Insights | Al-Noor Properties BD' }
  },
  {
    path: '/journal/:id',
    name: 'JournalDetail',
    component: JournalDetail,
    meta: { title: 'Article | Al-Noor Properties BD' }
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact,
    meta: { title: 'Concierge & Contact | Al-Noor Properties BD' }
  },

  // --- Sneat Vue Admin Portal ---
  {
    path: '/admin/login',
    name: 'AdminLogin',
    component: AdminLogin,
    meta: { title: 'Admin Login | Al-Noor Properties BD' }
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/admin/dashboard'
      },
      {
        path: 'dashboard',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: { title: 'Analytics Dashboard | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'properties',
        name: 'AdminProperties',
        component: AdminProperties,
        meta: { title: 'Projects & Units | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'properties/create',
        name: 'AdminPropertyCreate',
        component: AdminPropertyForm,
        meta: { title: 'Add New Project | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'properties/:id/edit',
        name: 'AdminPropertyEdit',
        component: AdminPropertyForm,
        meta: { title: 'Edit Project | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'inquiries',
        name: 'AdminInquiries',
        component: AdminInquiries,
        meta: { title: 'Inquiries & VIP Leads | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'locations',
        name: 'AdminLocations',
        component: AdminLocations,
        meta: { title: 'Dhaka Locations | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'categories',
        name: 'AdminCategories',
        component: AdminCategories,
        meta: { title: 'Property Categories | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'blogs',
        name: 'AdminBlogs',
        component: AdminBlogs,
        meta: { title: 'Journal & Articles | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'testimonials',
        name: 'AdminTestimonials',
        component: AdminTestimonials,
        meta: { title: 'Testimonials | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'sliders',
        name: 'AdminSliders',
        component: AdminSliders,
        meta: { title: 'Hero Banners | Sneat Admin', requiresAuth: true }
      },
      {
        path: 'settings',
        name: 'AdminSettings',
        component: AdminSettings,
        meta: { title: 'Site Settings | Sneat Admin', requiresAuth: true }
      },
    ]
  },

  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    }
    return { top: 0, behavior: 'smooth' };
  }
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title || 'Al-Noor Properties BD | Luxury Real Estate';

  const token = localStorage.getItem('alnoor_admin_token');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      return next('/admin/login');
    }
  }

  if (to.path === '/admin/login' && token) {
    return next('/admin/dashboard');
  }

  next();
});

export default router;
