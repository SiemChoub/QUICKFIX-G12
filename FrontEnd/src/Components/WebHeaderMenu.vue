<template>
  <header>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow p-0 px-5 py-2">
      <div class="container">
        <div class="row w-100 align-items-center">
          <div class="col-lg-3 col-6 d-flex align-items-center position-relative">
            <div class="col-lg-3 col-6 position-relative">
              <img
                src="../assets/images/logo.png"
                alt="Logo"
                style="width: 70px; height: 65px; border-radius: 50%"
              />
              <router-link to="/" class="navbar-brand position-absolute top-50 start-30 translate-middle">
                <b>QUICKFIX</b>
              </router-link>
            </div>
          </div>
          <div class="col-lg-6 col-6">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
              <ul class="navbar-nav d-flex justify-content-space-evently">
                <li class="nav-item active px-4">
                  <router-link to="/" class="nav-link" exact>Home</router-link>
                </li>
                <li class="nav-item px-4">
                  <router-link to="#" class="nav-link">Services</router-link>
                </li>
                <li class="nav-item px-4">
                  <router-link to="#" class="nav-link">About</router-link>
                </li>
                <li class="nav-item px-4">
                  <router-link to="#" class="nav-link">Region</router-link>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-12 d-flex justify-content-end align-items-center">
            <div>
              <router-link to="/login" class="btn btn-outline-orange mx-2">Login</router-link>
              <router-link to="/signup" class="btn btn-danger mx-2">Sign Up</router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
</script>

<style scoped>
a {
  text-decoration: none;
}

.navbar {
  border-radius: 5px 5px 0 0;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000; 
}

.navbar-light .navbar-nav .nav-link {
  color: #343a40;
}

/* .navbar-light .navbar-nav .nav-link:hover,
.router-link-active {
  color: black;
  font-weight: bold;
} */

.navbar-light .navbar-brand {
  color: #343a40;
  font-size: 40px;
}

.navbar-light .navbar-toggler {
  border-color: #343a40;
}

.navbar-light .navbar-toggler-icon {
  background-color: #343a40;
}

.navbar-light .form-inline .form-control {
  border-radius: 20px;
  padding: 0.375rem 0.75rem;
}

.navbar-light .form-inline .btn-outline-success {
  border-radius: 20px;
}

.navbar-light .dropdown-menu {
  border-radius: 5px;
}

.nav-item .nav-link {
  display: flex;
  align-items: center;
}

.navbar-letter {
  font-size: 24px;
  font-weight: bold;
  color: #007bff;
}

.btn-outline-orange {
  color: #ff7f50;
  border-color: #ff7f50;
}

.btn-outline-orange:hover {
  background-color: #ff7f50;
  color: #fff;
}
</style>
