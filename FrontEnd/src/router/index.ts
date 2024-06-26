import { createRouter, createWebHistory } from 'vue-router'
import axiosInstance from '@/plugins/axios'
import { useAuthStore } from '@/stores/auth-store'
import { createAcl, defineAclRules } from 'vue-simple-acl'
import LoginForm from '@/Components/loginPage.vue'
import SignUpForm from '@/Components/SignUpPage.vue'
import MessangerComponent from '@/Components/Messanger.vue'

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
      path: '/messanger',
      name: 'messanger',
      component: MessangerComponent,
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
      path: '/service',
      name: 'service',
      component: () => import('../views/Web/Service/ServicePage.vue')

    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('../views/Web/Service/ProfileView.vue')

    },
    {
      path: '/profile/edit',
      name: 'profile-edit',
      component: () => import('../Components/Service/ProfileEdit/ProfileEdit.vue')

    },
    {
      path: '/motorcycle',
      name: 'motorcycle',
      component: () => import('../views/Web/Service/MotorcyclePage.vue')
    },
    {
      path: '/cars',
      name: 'cars',
      component: () => import('../views/Web/Service/CarService.vue')
    },
    {
      path: '/tuktuk',
      name: 'tuktuk',
      component: () => import('../views/Web/Service/TukTukService.vue')
    },
    {
      path: '/mobile',
      name: 'mobile',
      component: () => import('../views/Web/Service/MobileService.vue')
    },
    {
      path: '/computer',
      name: 'computer',
      component: () => import('../views/Web/Service/ComputerService.vue')
    },
    {
      path: '/electronic',
      name: 'electronic',
      component: () => import('../views/Web/Service/ElectronicService.vue')
    },
    {
      path: '/fixer',
      name: 'fixer',
      component: () => import('../Components/FixerVue.vue')
    },
    {
      path: '/post',
      name: 'post',
      component: () => import('../views/Web/Post/ListView.vue')
    },
    
    {
      path: '/HomeFixer',
      name: 'HomeFixer',
      component: () => import('../views/Fixer/HomeFixer.vue')
    },
    
    {
      path: '/fixerUser',
      name: 'fixerUser',
      component: () => import('@/views/Fixer/List.vue')
    },
    {
      path: '/Skill',
      name: 'Skill-View',
      component: () => import('../Components/Fixer/CardSkill.vue')
    },
    {
      path: '/booking',
      name: 'booking-View',
      component: () => import('../Components/Fixer/ListBooking.vue')
    },
    {
      path: '/HistoryView',
      name: 'HistoryView',
      component: () => import('../Components/Fixer/HistoryView.vue')
    },
    {
      path: '/map',
      name: 'map',
      component: () => import('../Components/Map.vue')
    },
    {
      path: '/chatView',
      name: 'chatView',
      component: () => import('../Components/Fixer/ChatView.vue')
    },
    {
      path: '/dashboard',
      name: 'dash-board',
      component: () => import('../Components/Fixer/DashBoard.vue'),
    },
  ]
})



export default { router, simpleAcl }
