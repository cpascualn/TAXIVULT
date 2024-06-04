import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ViajarView from '@/views/ViajarView.vue'
import ConduceView from '@/views/ConduceView.vue'
import NotFound from '@/views/NotFound.vue'
// import RegisterForm from '@/components/RegisterDriverForm.vue'
// import RegisterUserForm from '@/components/RegisterUserForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
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
          component: () => import('@/components/RegisterUserForm.vue')
        },
        {
          path: 'driver',
          name: 'driver',
          component: () => import('@/components/RegisterDriverForm.vue')
        }
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
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    }
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue')
    // }
  ]
})

export default router
