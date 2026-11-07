import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Attach Sanctum Bearer token for admin API calls
axios.interceptors.request.use((config) => {
    const adminToken = localStorage.getItem('alnoor_admin_token');
    if (adminToken) {
        config.headers.Authorization = `Bearer ${adminToken}`;
    }
    return config;
}, (error) => Promise.reject(error));

// Global response interceptor to handle expired sessions
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            if (window.location.pathname.startsWith('/admin') && window.location.pathname !== '/admin/login') {
                localStorage.removeItem('alnoor_admin_token');
                localStorage.removeItem('alnoor_admin_user');
                window.location.href = '/admin/login';
            }
        }
        return Promise.reject(error);
    }
);

