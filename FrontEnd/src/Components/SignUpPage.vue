<template>
  <div class="auth-page d-flex align-items-center justify-content-center">
    <transition name="fade">
      <div
        v-if="showSpinner"
        class="spinner-container position-fixed w-100 d-flex align-items-center justify-content-center"
      >
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </transition>
    <transition name="fade">
      <div class="auth-container shadow-lg d-flex flex-column flex-lg-row w-100">
        <div class="image-container">
          <img src="@/assets/images/image.png" alt="Auth Image" />
        </div>
        <div class="form-container p-5">
          <h2 class="mb-4">Sign Up</h2>
          <form @submit.prevent="signUp">
            <div class="form-group mb-4">
              <label for="username">Username:</label>
              <input type="text" id="username" v-model="username" class="form-control" required />
            </div>
            <div class="form-group mb-4">
              <label for="email">Email:</label>
              <input type="email" id="email" v-model="email" class="form-control" required />
            </div>
            <div class="form-group mb-4">
              <label for="password">Password:</label>
              <input
                type="password"
                id="password"
                v-model="password"
                class="form-control"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-4">Sign Up</button>
          </form>
          <div class="social-login">
            <h3 class="mb-3">Or Sign Up with:</h3>

            <button class="btn btn-google w-100" @click="loginWithGoogle">
              <i class="fab fa-google"></i> Google
            </button>
          </div>
          <div class="toggle-auth mt-4">
            <p>
              Already Have Account?
              <router-link to="/login">Login</router-link>
            </p>
          </div>
        
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

const username = ref('')
const email = ref('')
const password = ref('')
const showSpinner = ref(true) // Initially show spinner

onMounted(() => {
  setTimeout(() => {
    showSpinner.value = false
  }, 1000)
})

const signUp = () => {
  console.log('Sign Up form submitted')
  console.log('Username:', username.value)
  console.log('Email:', email.value)
  console.log('Password:', password.value)
  // Here you can implement your sign-up logic, e.g., call an API
  // After successful sign-up, you might redirect the user or update state
  username.value = ''
  email.value = ''
  password.value = ''
}

const loginWithGoogle = () => {
  console.log('Login with Google')
  // Here you can implement Google login logic, e.g., using Google SDK
}
</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';

.auth-page {
  background-color: #f0f2f5;
  display: flex;
  /* justify-content: center; */
  /* align-items: center; */
  /* height: auto; */
}

.auth-container {
  display: flex;
  flex-direction: column;
  border-radius: 10px;
  overflow: hidden;
  background-color: white;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  /* width: 90%; */
  /* max-width: 900px; */
}

@media (min-width: 992px) {
  .auth-container {
    flex-direction: row;
  }
}

.image-container {
  flex: 1.5;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #007bff;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.form-container {
  flex: 1;
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
  /* margin-bottom: 1.5rem; */
  /* padding: 12px; */
  font-size: 1.1rem;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.btn-primary {
  background-color: orange;
  border-color: #007bff;
  font-size: 1.2rem;
  padding: 8px;
  border-radius: 5px;
  border: none;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
  border-color: #6c757d;
  font-size: 1.2rem;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.btn-google {
  background-color: #dd4b39;
  color: white;
  font-size: 1.1rem;
  padding: 8px;
  border-radius: 5px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
  text-align: center;
  cursor: pointer;
  width: 100%;
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

.toggle-auth {
  text-align: center;
}

.toggle-auth a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.toggle-auth a:hover {
  text-decoration: underline;
}

.back-home {
  text-align: center;
  margin-top: 1rem;
}

.back-home .btn-secondary {
  background-color: #6c757d;
  color: white;
  border-color: #6c757d;
  font-size: 1.2rem;
  padding: 12px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.back-home .btn-secondary:hover {
  background-color: #5a6268;
}

.spinner-container {
  background-color:white; /* Semi-transparent background */
  z-index: 999; /* Ensure it's above other content */
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
  color: #ffc107; /* Yellow color */
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>
