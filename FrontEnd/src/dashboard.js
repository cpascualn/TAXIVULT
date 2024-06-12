import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";


import { createApp } from 'vue'
import Dashboard from './Dash.vue'
import dashboardRouter from './router/dashboardRouter'
import store from "./store";
import materialDashboard from "@/material-dashboard";
import PrimeVue from 'primevue/config';

const appD = createApp(Dashboard)
appD.use(store);
appD.use(dashboardRouter)
appD.use(materialDashboard).use(PrimeVue);

appD.mount('#dash-app')
