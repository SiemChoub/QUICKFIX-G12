import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const isAuthenticated = ref(false)
  const permissions = ref([])
  const roles = ref([])

  async function login(credentials) {
    try {
      const response = await axios.post('/api/login', credentials)
      user.value = response.data.user
      isAuthenticated.value = true
      permissions.value = response.data.permissions
      roles.value = response.data.roles
      localStorage.setItem('token', response.data.token)
    } catch (error) {
      console.error('Login failed:', error)
    }
  }

  async function logout() {
    try {
      await axios.post('/api/logout', {}, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      })
      user.value = null
      isAuthenticated.value = false
      permissions.value = []
      roles.value = []
      localStorage.removeItem('token')
    } catch (error) {
      console.error('Logout failed:', error)
    }
  }

  return {
    user,
    roles,
    permissions,
    isAuthenticated,
    login,
    logout
  }
})