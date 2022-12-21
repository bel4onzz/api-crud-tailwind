import './bootstrap';
import '../css/app.css';
import router from './router'
import store from './store'
import apiRoutes from './api.js'

import { createApp } from 'vue'

import App from './views/App.vue'

createApp(App)
    .use(router)
    .use(store)
    .provide('$apiroutes', apiRoutes)
    .provide('$router', router)
    .mount("#app")
