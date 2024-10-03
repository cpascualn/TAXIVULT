import { createRouter, createWebHistory } from 'vue-router'
import { jwtDecode } from 'jwt-decode'
import { Roles } from './Roles'

import Billing from "@/views/dashboard/Billing.vue"
import Dashboard from "@/views/dashboard/Dashboard.vue"
import UserProfile from "@/views/dashboard/examples-api/profile/UserProfile.vue"
import UsersList from "@/views/dashboard/examples-api/users/UsersList.vue"
import Notifications from "@/views/dashboard/Notifications.vue"
import Profile from "@/views/dashboard/Profile.vue"
import Tables from "@/views/dashboard/Tables.vue"
import LoginView from '@/views/index/LoginView.vue'


const dashboardRouter = createRouter({
    history: createWebHistory('/dashboard'),
    routes: [
        {
            path: '',
            name: 'Dashboard',
            component: Dashboard,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: '/',
            name: 'Dashboard2',
            component: Dashboard,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: '/dashboard',
            name: 'Dashboard3',
            component: Dashboard,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/tables",
            name: "Tables",
            component: Tables,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/billing",
            name: "Billing",
            component: Billing,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/notifications",
            name: "Notifications",
            component: Notifications,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
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
            path: '/users',
            name: "Users",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/sign-in",
            name: "SignIn",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/sign-up",
            name: "SignUp",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/login",
            name: "Login",
            component: LoginView,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/signup",
            name: "Signup",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/password-forgot",
            name: "Password Forgot",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
        {
            path: "/password-reset",
            name: "Password Reset",
            component: UsersList,
            meta: { authorize: [Roles.Admin, Roles.Conductor, Roles.Pasajero] },
        },
    ]
});

const token = localStorage.getItem('authToken');


// dashboardRouter.beforeEach((to, from, next) => {
//     const { authorize } = to.meta;
//     let decoded;
//     let userRol = 0;
//     if (token) {
//         decoded = jwtDecode(token);
//         userRol = decoded.data.rol;
//     }


//     if (authorize) {
//         if (userRol == Roles.Visitante) {
//             return window.location.replace('/login');
//         }
//         // check if route is restricted by role
//         if (authorize.length && !authorize.includes(userRol)) {
//             // role not authorised so redirect to home page
//             return window.location.replace('/home');
//         }
//     }

//     next();
// })







export default dashboardRouter