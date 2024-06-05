import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";


import { createApp } from 'vue'
import Dash from './Dash.vue'
import router from './router'
import store from "./store";
import materialDashboard from "@/material-dashboard";

const app = createApp(Dash)
app.use(store);
app.use(router)
app.use(materialDashboard);

app.mount('#dash-app')
