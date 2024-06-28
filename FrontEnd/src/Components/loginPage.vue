<template>
  <div class="login-page d-flex align-items-center justify-content-center vh-100">
    <div class="login-container shadow-lg d-flex">
      <div class="image-container">
        <img src="@/assets/images/image.png" alt="Login Image" />
      </div>
      <div class="form-container p-5">
        <h2 class="mb-4">Login</h2>
        <form @submit.prevent="login">
          <div class="form-group mb-4">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="email" class="form-control" required />
          </div>
          <div class="form-group mb-4">
            <label for="password">Password:</label>
            <input type="password" id="password" v-model="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-4">Login</button>
        </form>
        <div class="social-login">
          <h3 class="mb-3">Or login with:</h3>
          <button class="btn btn-facebook w-100 mb-2" @click="loginWithFacebook">
            <i class="fab fa-facebook-f"></i> Login with Facebook
          </button>
          <button class="btn btn-google w-100" @click="loginWithGoogle">
            <i class="fab fa-google"></i> Login with Google
          </button>
          <p class="mt-3">Don't have an account? <router-link to="/signup">Sign Up</router-link></p>
          <p>
            <router-link to="/">Back to Home</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    login() {
      axios
        .post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        })
        .then((response) => {
          console.log(response.data)
          this.$router.push('/service')
        })
        .catch((error) => {
          console.error(error.response.data)
        })
    },
    loginWithFacebook() {
      console.log('Logging in with Facebook')
    },
    loginWithGoogle() {
      console.log('Logging in with Google')
    }
  }
}
</script>

<style scoped>
@import '@fortawesome/fontawesome-free/css/all.css';

.login-page {
  background-color: #f0f2f5;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.login-container {
  max-width: 1000px;
  display: flex;
  border-radius: 10px;
  overflow: hidden;
  background-color: white;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.image-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #007bff;
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
  width: 100%;
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
</style>
