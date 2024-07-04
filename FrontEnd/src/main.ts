// Import CSS files
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap/dist/css/bootstrap.min.css' // Import Bootstrap CSS
import 'bootstrap/dist/js/bootstrap.min.js' // Import Bootstrap JS

import './assets/main.css' // Custom CSS styles

// Import necessary Vue and related libraries
import { createApp } from 'vue'
import { createPinia } from 'pinia'
export const GOOGLE_CLIENT_ID = "1061846549456-ap7pb6q2sn155qvvtuikofc581jdsqte.apps.googleusercontent.com";

// Import root component and router configuration
import App from './App.vue'
import { router, simpleAcl } from './router'

// Import UI library and its styles
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

// Import Axios instance
import axios from './plugins/axios'

// Import Uno.css for additional styles
import 'uno.css'

// Import VeeValidate for form validation configuration
import { configure } from 'vee-validate'

// Create Vue application instance
const app = createApp(App)

// Configure VeeValidate
configure({
  validateOnInput: true
})

// Use Pinia for state management
app.use(createPinia())

// Use Vue Router for navigation
app.use(router)

// Use ACL for role-based access control
app.use(simpleAcl)

// Use Element Plus UI library
app.use(ElementPlus)

// Set Axios as a global property accessible in components
app.config.globalProperties.$axios = axios

// Mount the app to the DOM
app.mount('#app')
