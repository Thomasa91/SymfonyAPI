import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Notifications from '@kyvg/vue3-notification'
// import axios from 'axios'
// axios.defaults.baseURL="https://localhost:8000/api"

require('@/store/subscriber')

store.dispatch('auth/attempt', {token:localStorage.getItem('token'), roles:localStorage.getItem('roles')}).then(() => {
    createApp(App).use(store).use(router).use(Notifications).mount('#app')
})
