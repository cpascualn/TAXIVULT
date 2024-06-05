import './assets/main.css'

import { createApp } from 'vue'
import Dash from './Dash.vue'
import router from './router'

const app = createApp(Dash)

app.use(router)

app.mount('#dash-app')
