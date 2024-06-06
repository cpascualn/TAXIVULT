import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";


import { createApp } from 'vue'
import Dashboard from '@/Dash.vue'
import dashboardRouter from '@/router/dashboardRouter'
import store from "@/store";
import materialDashboard from "@/material-dashboard";

const appD = createApp(Dashboard)
appD.use(store);
appD.use(dashboardRouter)
appD.use(materialDashboard);

appD.mount('#dash-app')
