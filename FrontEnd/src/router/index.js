import { createRouter, createWebHistory } from 'vue-router'

import NotFound from '@/views/index/NotFound.vue'
import HomeView from '@/views/index/HomeView.vue'
import LoginView from '@/views/index/LoginView.vue'
import RegisterView from '@/views/index/RegisterView.vue'
import ViajarView from '@/views/index/ViajarView.vue'
import ConduceMain from '@/views/index/components/ConduceMain.vue'
import HomeMain from "@/views/index/components/HomeMain.vue";
const APP_URL = 'http://localhost:5173';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      redirect: 'home', // Redirige / a /homeComp por defecto
      children: [
        {
          path: 'home',
          name: 'homeComp',
          component: HomeMain,
        },

        {
          path: 'conduce',
          name: 'conduce',
          component: ConduceMain,
          meta: { requiresAuth: true }
        },

      ]
    },
    {
      path: '/viaja',
      name: 'viaja',
      component: ViajarView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
      children: [
        {
          path: 'user',
          name: 'user',
          component: () => import('@/components/index/RegisterUserForm.vue')
        },
        {
          path: 'driver',
          name: 'driver',
          component: () => import('@/components/index/RegisterDriverForm.vue')
        },
      ]
    },

    // {
    //   path: '/dashboard/',
    //   redirect: `${window.location.origin}/dashboard`,
    // },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    },

  ]
})


router.beforeEach((to,from,next) => {

  const token = localStorage.getItem('authToken');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (token) {
      // Si el token existe, permitir el acceso
      next();
    } else {
      // Si no hay token, redirigir a login
      next({ name: 'login' });
    }
  } else {
    // Si la ruta no requiere autenticación, continuar normalmente
    next();
  }

});

export default router
