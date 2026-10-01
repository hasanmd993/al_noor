import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createUnhead, headSymbol } from '@unhead/vue';
import App from './App.vue';
import router from './router';

const app = createApp(App);
const pinia = createPinia();
const head = createUnhead();

app.provide(headSymbol, head);
app.use(pinia);
app.use(router);

app.mount('#app');
