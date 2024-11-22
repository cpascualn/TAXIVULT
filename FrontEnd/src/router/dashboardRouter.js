import { createRouter, createWebHistory } from 'vue-router'
import { jwtDecode } from 'jwt-decode'
import { Roles } from './Roles'

import Billing from "@/views/dashboard/Billing.vue"
import Dashboard from "@/views/dashboard/Dashboard.vue"
import UserProfile from "@/views/dashboard/examples-api/profile/UserProfile.vue"
import Profile from "@/views/dashboard/Profile.vue"
import authService from '@/services/auth.service';
import Horarios from '@/views/dashboard/Horarios.vue'
import Usuarios from '@/views/dashboard/Usuarios.vue'
import Ciudades from '@/views/dashboard/Ciudades.vue'
import Conductores from '@/views/dashboard/Conductores.vue'
import Vehiculos from '@/views/dashboard/Vehiculos.vue'
import Viajes from '@/views/dashboard/Viajes.vue'

const dashboardRouter = createRouter({
    history: createWebHistory('/dashboard'),
    routes: [
        {
            path: '',
            name: 'Dashboard',
            component: Dashboard,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: "/billing",
            name: "Billing",
            component: Billing,
            meta: { authorize: [Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/profile",
            name: "Profile",
            component: Profile,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/user-profile",
            name: "User Profile",
            component: UserProfile,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: '/usuarios',
            name: "Usuarios",
            component: Usuarios,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: '/horarios',
            name: "Horarios",
            component: Horarios,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: '/ciudades',
            name: "Ciudades",
            component: Ciudades,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: '/conductores',
            name: "Conductores",
            component: Conductores,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: '/vehiculos',
            name: "Vehiculos",
            component: Vehiculos,
            meta: { authorize: [Roles.Admin] },
        },
        {
            path: '/viajes',
            name: "Viajes",
            component: Viajes,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
    ]
});

const token = localStorage.getItem('authToken');


dashboardRouter.beforeEach((to, from, next) => {
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


    if (authorize) {
        if (authorize.length && !authorize.includes(userRol)) {
            // si el rol no tiene acceso y es un visitante redirigir al login,si no al home
            if (userRol == Roles.Visitante) {
                return window.location.replace('/login');
            }
            // role not authorised so redirect to home page
            return window.location.replace('/home');
        }
    }

    next();
})







export default dashboardRouter