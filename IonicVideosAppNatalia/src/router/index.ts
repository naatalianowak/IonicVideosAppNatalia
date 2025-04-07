import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import TabsPage from '../pages/TabsPage.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/create',
    redirect: '/tabs/manage-videos',
  },
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    component: () => import('../pages/Login.vue'),
  },
  {
    path: '/register',
    component: () => import('../pages/Register.vue'),
  },
  {
    path: '/tabs/',
    component: TabsPage,
    children: [
      {
        path: '',
        redirect: '/tabs/home',
      },
      {
        path: 'home',
        component: () => import('../pages/Tab1Page.vue'),
      },
      {
        path: 'videos',
        component: () => import('../pages/Tab2Page.vue'),
      },
      {
        path: 'my-videos',
        component: () => import('../pages/Tab4Page.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'manage-videos',
        component: () => import('../pages/Tab3Page.vue'),
        meta: { requiresAuth: true, requiresRole: ['Video Manager', 'Super Admin'] },
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// Guard de navegació per protegir rutes
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token');

  // Si la ruta requereix autenticació i no hi ha token, redirigeix a login
  if (to.meta.requiresAuth && !token) {
    return next('/login');
  }

  // Si la ruta requereix un rol específic
  if (to.meta.requiresRole && token) {
    try {
      const response = await fetch('http://localhost:8000/api/user', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      if (!response.ok) {
        throw new Error('Failed to fetch user data');
      }

      const user = await response.json();
      const userRoles = user.roles || [];
      const requiredRoles = to.meta.requiresRole as string[];

      const hasRequiredRole = requiredRoles.some(role => userRoles.includes(role));
      if (!hasRequiredRole) {
        return next('/tabs/videos'); // Redirigeix a la pestanya de vídeos si no té accés
      }
    } catch (error) {
      console.error('Error fetching user data:', error);
      localStorage.removeItem('token'); // Elimina el token si hi ha un error
      return next('/login');
    }

  }

  next();
});

export default router;