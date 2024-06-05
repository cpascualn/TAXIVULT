import HomeView from '@/views/index/HomeView.vue'
import LoginView from '@/views/index/LoginView.vue'
import RegisterView from '@/views/index/RegisterView.vue'
import ViajarView from '@/views/index/ViajarView.vue'
import ConduceView from '@/views/index/ConduceView.vue'


const mainRoutes = [
  {
    path: '',
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

]


export default mainRoutes