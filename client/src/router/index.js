import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import SignIn from '../views/SignIn.vue'
import Dashboard from '../views/Dashboard.vue'
import Admin from '../views/Admin.vue'
import SignUp from '../views/SignUp.vue'
import store from '@/store'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/signin',
    name: 'signin',
    component: SignIn,
    beforeEnter: (to, from, next) => {
      if(store.getters['auth/authenticated']) {
        return next({
          name :'home'
        })    
      }
      next()
    } 
  },
  {
    path: '/signup',
    name: 'signup',
    component: SignUp,
    beforeEnter: (to, from, next) => {
      if(store.getters['auth/authenticated']) {
        return next({
          name :'home'
        })    
      }
      next()
    }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    beforeEnter: (to, from, next) => {
      store.dispatch('auth/attempt', {token:localStorage.getItem('token'), roles:localStorage.getItem('roles')})
      if(!store.getters['auth/authenticated']) {
        return next({
          name :'signin'
        })    
      }
      next()
    }
  },
  {
    path: '/admin',
    name: 'admin',
    component: Admin,
    beforeEnter: (to, from, next) => {
      store.dispatch('auth/attempt', {token:localStorage.getItem('token'), roles:localStorage.getItem('roles')})// 
      if(!store.getters['auth/authenticated']) {
        return next({
          name :'signin'
        })    
      }     
      if(!store.getters['auth/isAdmin']) {
        return next({
          name :'home'
        })    
      }
      next()
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
