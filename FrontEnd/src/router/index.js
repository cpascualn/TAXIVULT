import { createRouter, createWebHistory } from 'vue-router'
import { jwtDecode } from 'jwt-decode'
import { Roles } from './Roles'
import NotFound from '@/views/index/NotFound.vue'
import HomeView from '@/views/index/HomeView.vue'
import LoginView from '@/views/index/LoginView.vue'
import RegisterView from '@/views/index/RegisterView.vue'
import ViajarView from '@/views/index/ViajarView.vue'
import ConduceMain from '@/views/index/components/ConduceMain.vue'
import HomeMain from "@/views/index/components/HomeMain.vue";
const APP_URL = 'http://localhost:5173';
import authService from '@/services/auth.service';



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
        },

      ]
    },
    {
      path: '/viaja',
      name: 'viaja',
      component: ViajarView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { authorize: [Roles.Visitante] },

    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
      meta: { authorize: [Roles.Visitante] },
      children: [
        {
          path: 'user',
          name: 'user',
          component: () => import('@/components/index/RegisterUserForm.vue'),
        },
        {
          path: 'driver',
          name: 'driver',
          component: () => import('@/components/index/RegisterDriverForm.vue'),
        },
      ]
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound
    },
  ],

})

const token = localStorage.getItem('authToken');


router.beforeEach((to, from, next) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const { authorize } = to.meta;
  let decoded;
  let userRol = 0;
  if (token) {
    decoded = jwtDecode(token);
    userRol = decoded.data.rol;
    if (authService.isTokenExpired(token)) {
      alert('tu tiempo de sesion ha expirado, Inicia Sesion de nuevo');
      authService.logout();
      location.reload();

    }

  }

  // check if route is restricted by role
  if (authorize) {
    if (authorize.length && !authorize.includes(userRol)) {
      // si el rol no tiene acceso y es un visitante redirigir al login,si no al home
      if (userRol == Roles.Visitante) {
        return next({ name: 'login' });
      }

      // role not authorised so redirect to home page
      return next({ name: 'home' });
    }
  }

  next();
})






export default router
