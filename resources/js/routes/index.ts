import { createRouter, createWebHistory } from 'vue-router';

import routes from './routes';

// Crear el router
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
