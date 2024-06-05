import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ViajarView from '@/views/ViajarView.vue'
import ConduceView from '@/views/ConduceView.vue'
import NotFound from '@/views/NotFound.vue'
import Dash from '@/Dash.vue'
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
      path: '/dashboard',
      name: 'dashboard',
      component: Dash,
      // children: [
      //   {
      //     path: "/tables",
      //     name: "Tables",
      //     component: Tables,
      //   },
      //   {
      //     path: "/billing",
      //     name: "Billing",
      //     component: Billing,
      //   },
      //   {
      //     path: "/notifications",
      //     name: "Notifications",
      //     component: Notifications,
      //   },
      //   {
      //     path: "/profile",
      //     name: "Profile",
      //     component: Profile,
      //   },
      //   {
      //     path: "/sign-in",
      //     name: "SignIn",
      //     component: SignIn,
      //   },
      //   {
      //     path: "/sign-up",
      //     name: "SignUp",
      //     component: SignUp,
      //   },
      //   {
      //     path: "/login",
      //     name: "Login",
      //     component: Login
      //   },
      //   {
      //     path: "/signup",
      //     name: "Signup",
      //     component: Signup
      //   },
      //   {
      //     path: "/password-forgot",
      //     name: "Password Forgot",
      //     component: PasswordForgot
      //   },
      //   {
      //     path: "/password-reset",
      //     name: "Password Reset",
      //     component: PasswordReset
      //   },
      //   {
      //     path: "/user-profile",
      //     name: "User Profile",
      //     component: UserProfile
      //   },
      //   {
      //     path: '/users',
      //     name: "Users",
      //     component: Users
      //   }
      // ]
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    }
  ]
})

export default router
