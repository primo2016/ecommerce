import { RouteRecordRaw } from 'vue-router';

// Define las rutas
const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'MainLayout',
    component: () => import('../layouts/MainLayout.vue'), // Lazy load del componente
  },
];

export default routes;
