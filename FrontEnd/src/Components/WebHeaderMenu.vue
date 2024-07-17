<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <!-- Brand logo -->
      <router-link to="/" class="navbar-brand d-flex align-items-center">
        <img src="../assets/images/logo.png" alt="Logo" class="logo" />
      </router-link>

      <!-- Navbar Toggler -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Items -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav navbar-nav-left me-auto mb-2 mb-lg-0">
          <!-- Home -->
          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="bi bi-house-door icon"></i>
              <span class="tooltip-text">Home</span>
            </router-link>
          </li>

          <!-- Fixer List -->
          <li class="nav-item">
            <router-link to="/fixer" class="nav-link">
              <img
                src="https://media.istockphoto.com/id/1445981943/vector/repair-service-man-worker-logo-mechanic-workshop-vector-illustration.jpg?s=612x612&w=0&k=20&c=vizyPckB7zfeO0HYpJaj6uSm1jiZ9ozqlFWwWeFPCy4="
                alt="Fixer Icon"
                style="width: 35px; border-radius: 50%"
              />
              <span class="tooltip-text">Fixer List</span>
            </router-link>
          </li>

          <!-- Offer Button -->
        </ul>
        <div class="center">
          <button class="btn offer-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            OFFER
          </button>
        </div>

        <div
          class="modal fade custom-slide-modal"
          id="staticBackdrop"
          tabindex="-1"
          aria-labelledby="staticBackdropLabel"
          aria-hidden="true"
          data-bs-backdrop="false"
          style="top: 15px"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Promotion</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3 hello d-flex align-items-center">
                    <input
                      type="email"
                      class="form-control me-2"
                      id="exampleFormControlInput1"
                      placeholder="Search"
                    />
                  </div>
                  <div
                    class="mb-3 card d-flex align-items-center"
                    v-for="promotion in promotions"
                    :key="promotion.id"
                  >
                    <div class="discount">Promotion {{ promotion.discount }}%</div>
                    <div class="text-truncate" style="max-width: 200px">
                      <!-- Adjust max-width as needed -->
                      🎉{{ promotion.description }}💛
                    </div>
                    <div class="date">Promotion {{ promotion.start_date }}</div>
                    <div class="date">Promotion {{ promotion.end_date }}</div>
                    
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Right-aligned Navbar Items -->
        <div class="right navbar-nav-right">
          <!-- Messages -->
          <div class="nav-item position-relative">
            <i class="bi bi-chat-dots icon" @click="showChat = true"></i>
            <span class="tooltip-text">Messages</span>
            <span class="badge bg-danger rounded-pill notification-badge">1</span>
          </div>

          <!-- Notifications -->
          <div class="nav-item position-relative" @click="toggleNotifications">
            <i class="bi bi-bell icon" title="Notifications"></i>
            <span class="tooltip-text">Notifications</span>
            <span class="badge bg-danger rounded-pill notification-badge">1</span>
            <div v-if="showNotifications" class="notification-dropdown">
              <ul>
                <li v-for="(notification, index) in notifications" :key="index">
                  {{ notification }}
                </li>
              </ul>
            </div>
          </div>

          <!-- Profile Dropdown -->
          <div class="nav-item dropdown position-relative">
            <a
              class="nav-link dropdown-toggle p-0"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                :src="
                  authStore.user?.profile ||
                  'https://st3.depositphotos.com/1767687/17621/v/450/depositphotos_176214104-stock-illustration-default-avatar-profile-icon.jpg'
                "
                alt="Profile"
                title="Profile"
                class="profile-image"
              />
              <span class="tooltip-text">Profile</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li v-if="isLoggedIn">
                <router-link to="/profile" class="dropdown-item">
                  <i class="bi bi-eye-fill"></i>
                  <p>view Profile</p>
                </router-link>
              </li>
              <li v-if="isLoggedIn">
                <router-link to="#" class="dropdown-item">
                  <i class="bi bi-clock-history"></i>
                  <p>History</p>
                </router-link>
              </li>
              <li v-if="isLoggedIn">
                <a href="#" class="dropdown-item" @click="logout">
                  <i class="bi bi-box-arrow-right"></i>
                  <p>Logout</p>
                </a>
              </li>
              <li v-if="!isLoggedIn">
                <router-link to="/signup" class="dropdown-item">Sign Up</router-link>
              </li>
              <li v-if="!isLoggedIn">
                <router-link to="/login" class="dropdown-item">Sign In</router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Chat Modal and Booking Form Components -->
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth-store'
import axios from 'axios'

const promotions = ref(null)
const authStore = useAuthStore()
const showNotifications = ref(false)
const notifications = ref([
  'New comment on your post',
  'New like on your photo',
  'Friend request received'
])

const isLoggedIn = computed(() => !!authStore.user)

onMounted(async () => {
  await listPromotion()
})
const logout = async () => {
  try {
    authStore.logout() 
    alert('User logged out successfully!')
    location.reload()
  } catch (error) {
    console.error('Error logging out:', error)
  }
}

async function listPromotion() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/promotion/list')
    promotions.value = response.data
  } catch (error) {
    console.log('error getting promotion')
  }
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
}
</script>

<style scoped>
/* Navbar Styles */
.custom-slide-modal .modal-dialog {
  margin: 0;
  transform: translateX(100%);
  transition: transform 0.3s ease-out;
  z-index: 1050; /* Ensure modal appears above modal backdrop */
}
.modal-body {
  overflow-y: scroll;
  height: 450px;
}

.hoverable::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 0%;
  height: 2px;
  background-color: #007bff; /* Color of the border */
  transition: width 0.3s ease; /* Smooth transition for width change */
}

.hoverable:hover::after {
  width: 100%; /* Expand the width to show the border on hover */
}
.card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 15px;
  max-width: 350px;
  text-align: center;
  margin-left: 6%;
}
.card .title {
  font-size: 1em;
  color: #ffa000;
}
.card .discount {
  font-size: 1.8em;
  margin: 10px 0;
  color: #000;
  font-weight: bold;
}
.card .date {
  font-size: 15px;
}
/* Logo */
.logo {
  width: 150px;
  height: auto;
}
.navbarSupportedContent {
  display: flex;
  background: #000;
  flex: 0.5;
}

/* Offer Button */
.offer-btn {
  padding: 7px 20px;
  background-color: orange;
  color: white;
  width: 100%;
  border: none;
  cursor: pointer;
}

.offer-btn:hover {
  background-color: #ff7f50; /* Lighter shade of orange on hover */
}

/* Profile Image */
.profile-image {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

/* Navbar Toggler */
.navbar-toggler {
  border-color: rgba(0, 0, 0, 0.1);
}

/* Notification Badge */
.notification-badge {
  position: absolute;
  top: 0;
  right: 11px;
  z-index: 1;
  font-size: 0.8rem;
}

/* Icon Styles */
.icon {
  font-size: 24px;
  margin: 0 1.5rem;
  cursor: pointer;
  transition: transform 0.1s ease, box-shadow 0.1s ease;
  color: #343a40;
}

.icon:hover {
  transform: scale(1.3);
  color: #ff7f50;
}
.navbar-nav-right {
  display: flex;
  justify-content: end;
  gap: 3rem;
  flex: 0.5;
}
.dropdown-item {
  display: flex;
  gap: 5px;
}
.center {
  display: flex;
  flex: 0.2;
  justify-content: center;
}
.navbar-nav-left {
  display: flex;
  justify-content: center;
  flex: 0.5;
  gap: 2rem;
}
/* Tooltip Text */
.tooltip-text {
  visibility: hidden;
  width: 120px;
  background-color: #0a0a0a88;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  bottom: -55%;
  left: 50%;
  margin-left: -30px;
  opacity: 0;
  transition: opacity 0.3s;
  font-size: 15px;
}

.nav-item:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}

/* Dropdown Menu */
.dropdown-menu {
  position: absolute;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: none;
  border-radius: 5px;
  padding: 10px;
  left: -90px; /* Adjust dropdown position */
}

.dropdown-menu .dropdown-item {
  padding: 8px 20px;
  color: #343a40;
}

.dropdown-menu .dropdown-item:hover {
  background-color: orange;
  color: #fff;
}

.dropdown-toggle::after {
  display: none;
}

/* Notification Dropdown */
.notification-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 6px;
  z-index: 10;
  padding: 5px 0;
  min-width: 200px;
  text-align: left;
}

.notification-dropdown ul {
  list-style: none;
  padding: 0;
}

.notification-dropdown ul li {
  padding: 10px;
  cursor: pointer;
}

.notification-dropdown ul li:hover {
  background-color: #f1f1f1;
}

/* Responsive Styles */
@media (max-width: 992px) {
  .navbar-toggler {
    border-color: #ff7f50; /* Orange color for toggler on smaller screens */
  }

  .navbar-collapse {
    background-color: #fff;
  }

  .dropdown-menu {
    left: -60px; /* Adjust dropdown position */
  }

  .notification-dropdown {
    left: unset;
    right: 10px; /* Adjust notification dropdown position */
  }
}
</style>
