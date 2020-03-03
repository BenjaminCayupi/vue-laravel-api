import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Arriendos from '../views/Arriendos.vue'
import Clientes from '../views/Clientes.vue'
import Productos from '../views/Productos.vue'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: Dashboard
  },
  {
    path: '/arriendos',
    name: 'arriendos',
    component: Arriendos
  },
  {
    path: '/clientes',
    name: 'clientes',
    component: Clientes
  },
  {
    path: '/productos',
    name: 'productos',
    component: Productos
  },
  
  
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
