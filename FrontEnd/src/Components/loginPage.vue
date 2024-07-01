<template>
  <div class="login-page d-flex align-items-center justify-content-center vh-100">
    <transition name="fade">
      <div v-if="showSpinner" class="spinner-container position-fixed w-100 h-100 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </transition>

    <div class="login-container shadow-lg d-flex">
      <div class="image-container">
        <img src="@/assets/images/image.png" alt="Login Image" />
      </div> 
      <div class="form-container p-5">
        <h2 class="mb-4">Login</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group mb-4">
            <label for="username">Email:</label>
            <input type="email" id="username" v-model="username" class="form-control" required />
          </div>
          <div class="form-group mb-4">
            <label for="password">Password:</label>
            <input type="password" id="password" v-model="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-4" style="background: orange; border: none;">Login</button>
        </form>
        <div class="social-login">
          <h3 class="mb-3">Or login with:</h3>
          <google-login
            :clientId="clientId"
            :scope="scope"
            :buttonText="buttonText"
            @success="onGoogleLoginSuccess"
            @failure="onGoogleLoginFailure"
            @error="onGoogleLoginError"
            class="btn btn-google w-100"
          >
            <i class="fab fa-google"></i> Login with Google
          </google-login>
          <p class="mt-3">
            Don't have an account? <router-link to="/signup">Sign Up</router-link>
          </p>
          <p>
            <router-link to="/">Back to Home</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import { GoogleLogin } from 'vue3-google-login';
import { GOOGLE_CLIENT_ID } from '@/main';

export default {
  name: 'Login',
  components: {
    GoogleLogin,
  },
  data() {
    return {
      showSpinner: false,
      username: '',
      password: '',
      clientId: GOOGLE_CLIENT_ID,
      scope: 'profile email',
      buttonText: 'Login with Google',
    };
  },
  methods: {
    async handleSubmit() {
      try {
        this.showSpinner = true;
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.username,
          password: this.password
        });
        
        const { access_token } = response.data;
        localStorage.setItem('token', access_token);
        
        // Navigate to home page
        this.$router.push('/'); // Navigate to home page
      } catch (error) {
        console.error('Login error:', error);
        // Handle error (e.g., show error message to user)
      } finally {
        this.showSpinner = false;
      }
    },
    onGoogleLoginSuccess(googleUser) {
      console.log('Logged in successfully with Google:', googleUser);
      // Handle Google login success as needed
    },
    onGoogleLoginFailure(error) {
      console.error('Google login failed:', error);
      // Handle Google login failure as needed
    },
    onGoogleLoginError(error) {
      console.error('Error while logging in with Google:', error);
      // Handle Google login error as needed
    },
  },
};
</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';

.login-page {
  background-color: #f0f2f5;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-container {
  display: flex;
  height: 100%;
  overflow: hidden;
  background-color: white;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.image-container {
  flex: 1.5;
  display: flex;
  justify-content: center;
  align-items: center;
}

.image-container img {
  width: 100%;
  height: auto;
  object-fit: cover;
}

.form-container {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

h2 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #333;
}

label {
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #555;
}

.form-control {
  margin-bottom: 1.5rem;
  padding: 12px;
  font-size: 1.1rem;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  font-size: 1.2rem;
  padding: 12px;
  border-radius: 5px;
}

.btn-facebook {
  background-color: #3b5998;
  color: white;
  font-size: 1.1rem;
  padding: 12px;
  border-radius: 5px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
  text-align: center;
  cursor: pointer;
}

.btn-facebook:hover {
  background-color: #2d4373;
}

.btn-facebook i {
  margin-right: 10px;
}

.btn-google {
  background-color: #dd4b39;
  color: white;
  font-size: 1.1rem;
  padding: 12px;
  border-radius: 5px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
  text-align: center;
  cursor: pointer;
}

.btn-google:hover {
  background-color: #c23321;
}

.btn-google i {
  margin-right: 10px;
}

.social-login h3 {
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  text-align: center;
  color: #333;
}

.social-login p {
  font-size: 1rem;
  color: #555;
  text-align: center;
  margin-top: 1rem;
}

.social-login a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.social-login a:hover {
  text-decoration: underline;
}

.spinner-container {
  background-color:white;
  z-index: 999;
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
