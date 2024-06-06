import { createRouter, createWebHistory } from 'vue-router'

import Billing from "@/views/dashboard/Billing.vue"
import Dashboard from "@/views/dashboard/Dashboard.vue"
import UserProfile from "@/views/dashboard/examples-api/profile/UserProfile.vue"
import UsersList from "@/views/dashboard/examples-api/users/UsersList.vue"
import Notifications from "@/views/dashboard/Notifications.vue"
import Profile from "@/views/dashboard/Profile.vue"
import Tables from "@/views/dashboard/Tables.vue"


const dashboardRouter = createRouter({
    history: createWebHistory('/dashboard'),
    routes: [
        {
            path: '',
            name: 'Dashboard',
            component: Dashboard,
        },
        {
            path: "/tables",
            name: "Tables",
            component: Tables,
        },
        {
            path: "/billing",
            name: "Billing",
            component: Billing,
        },
        {
            path: "/notifications",
            name: "Notifications",
            component: Notifications,
        },
        {
            path: "/profile",
            name: "Profile",
            component: Profile,
        },
        {
            path: "/user-profile",
            name: "User Profile",
            component: UserProfile
        },
        {
            path: '/users',
            name: "Users",
            component: UsersList
        },
        {
            path: "/sign-in",
            name: "SignIn",
            component: UsersList,
        },
        {
            path: "/sign-up",
            name: "SignUp",
            component: UsersList,
        },
        {
            path: "/login",
            name: "Login",
            component: UsersList
        },
        {
            path: "/signup",
            name: "Signup",
            component: UsersList
        },
        {
            path: "/password-forgot",
            name: "Password Forgot",
            component: UsersList
        },
        {
            path: "/password-reset",
            name: "Password Reset",
            component: UsersList
        },
    ]
})








export default dashboardRouter