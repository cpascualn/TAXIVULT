import { createRouter, createWebHistory } from 'vue-router'

import NotFound from '@/views/index/NotFound.vue'
import HomeView from '@/views/index/HomeView.vue'
import LoginView from '@/views/index/LoginView.vue'
import RegisterView from '@/views/index/RegisterView.vue'
import ViajarView from '@/views/index/ViajarView.vue'
import ConduceView from '@/views/index/ConduceView.vue'
const APP_URL = 'http://localhost:5173';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
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
    {
      path: '/viaja',
      name: 'viaja',
      component: ViajarView
    },
    {
      path: '/conduce',
      name: 'conduce',
      component: ConduceView
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

export default router
