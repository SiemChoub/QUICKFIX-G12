import { createRouter, createWebHistory } from 'vue-router'
import axiosInstance from '@/plugins/axios'
import { useAuthStore } from '@/stores/auth-store'
import { createAcl, defineAclRules } from 'vue-simple-acl'
import LoginForm from '@/Components/loginPage.vue'
import SignUpForm from '@/Components/SignUpPage.vue'

const simpleAcl = createAcl({})

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin/dashboard',
      name: 'dashboard',
      component: () => import('../views/Admin/DashboardView.vue'),
      meta: {
        requiresAuth: true,
        role: 'admin'
      }
    },
    {
      path: '/login',
      name: 'login',
      component: LoginForm,
      meta: {
        requiresAuth: false // Public page, no authentication required
      }
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignUpForm,
      meta: {
        requiresAuth: false // Public page, no authentication required
      }
    },
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Web/HomeView.vue'),
      meta: {
        requiresAuth: false // Public page, no authentication required
      }
    },
    {
      path: '/post',
      name: 'post',
      component: () => import('../views/Web/Post/ListView.vue'),
      meta: {
        requiresAuth: true, // Example of a protected route
        role: 'user' // Example role required to access this route
      }
    }
  ]
})



export default { router, simpleAcl }
