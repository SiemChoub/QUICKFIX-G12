import { createRouter, createWebHistory } from 'vue-router'
import axiosInstance from '@/plugins/axios'
import { useAuthStore } from '@/stores/auth-store'
import { createAcl, defineAclRules } from 'vue-simple-acl'
// import fixerUser from '@/views/Fixer/List.vue'

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
      component: () => import('../views/Admin/Auth/LoginView.vue')
    },
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Web/Service/ServicePage.vue')
    },
    {
      path: '/service',
      name: 'service',
      component: () => import('../views/Web/Service/ServicePage.vue')
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
      path: '/chatView',
      name: 'chatView',
      component: () => import('../Components/Fixer/ChatView.vue')
    },
    {
      path: '/dashboard',
      name: 'dash-board',
      component: () => import('../Components/Fixer/DashBoard.vue'),
    }
  ]
})

router.beforeEach(async (to, from, next) => {
  const publicPages = ['/login']
  const authRequired = !publicPages.includes(to.path)
  const store = useAuthStore()

  try {
    const { data } = await axiosInstance.get('/me')

    store.isAuthenticated = true
    store.user = data.data

    store.permissions = data.data.permissions.map((item: any) => item.name)
    store.roles = data.data.roles.map((item: any) => item.name)

    const rules = () =>
      defineAclRules((setRule) => {
        store.permissions.forEach((permission: string) => {
          setRule(permission, () => true)
        })
      })

    simpleAcl.rules = rules()
  } catch (error) {
    /* empty */
  }

  if (authRequired && !store.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default { router, simpleAcl }
