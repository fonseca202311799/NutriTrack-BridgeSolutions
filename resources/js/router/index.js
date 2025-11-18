import { createRouter, createWebHistory } from 'vue-router'

// Core pages
import Dashboard from '@/components/Dashboard.vue'
import UserTable from '@/components/UserTable.vue'
import Goals from '@/components/Goals.vue'
import Reports from '@/components/Reports.vue'
import Tips from '@/components/Tips.vue'
import Settings from '@/components/Settings.vue'

const routes = [
  { path: '/', name: 'Dashboard', component: Dashboard },
  { path: '/users', name: 'Users', component: UserTable },
  { path: '/goals', name: 'Goals', component: Goals },
  // Backward-compatibility: old menu item used '/active-plans'
  { path: '/active-plans', redirect: { name: 'Goals' } },
  { path: '/reports', name: 'Reports', component: Reports },
  { path: '/tips', name: 'Tips', component: Tips },
  { path: '/settings', name: 'Settings', component: Settings },
]

const router = createRouter({
  history: createWebHistory('/admin'),
  routes,
})

export default router
