import { createRouter, createWebHistory } from 'vue-router'

import NotFound from '@/views/index/NotFound.vue'
import Dash from '@/Dash.vue'
import App from '@/App.vue'

import dashboardRoutes from './dashboardRoutes'
import mainRoutes from './mainRoutes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: App,
      children: mainRoutes
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dash,
      children: dashboardRoutes
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    }
  ]
})

export default router
