<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top h-20">
    <div class="container-fluid">
      <div class="navbar-brand d-flex align-items-center">
        <img src="../assets/images/logo.png" alt="Logo" class="logo" />
      </div>
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
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item d-flex align-items-center position-relative">
          <router-link to="/">
            <i class="bi bi-house-door icon"></i>
            <span class="tooltip-text">Home</span>
          </router-link>
        </li>
        <li class="nav-item d-flex align-items-center position-relative">
          <router-link to="/fixer" class="nav-link p-0">
            <i class="bi bi-person icon"></i>
            <span class="tooltip-text">Fixer List</span>
          </router-link>
        </li>
      </ul>
      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <form class="d-flex search-form">
          <button class="form-control me-2" type="button" @click="toggleOptions">
            {{ showOptions ? 'Close' : 'Fix Now' }}
          </button>
        </form>
        <div class="options-container" v-if="showOptions">
          <button type="button" @click="viewServices">View Services</button>
          <button type="button" @click="showBookingForm = true">Book Service</button>
        </div>
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item d-flex align-items-center position-relative">
            <router-link to="/map">
              <i class="bi bi-geo-alt icon"></i>
              <span class="tooltip-text">Location</span>
              <span class="badge bg-danger rounded-pill notification-badge">1</span>
            </router-link>
          </li>
          <li class="nav-item d-flex align-items-center position-relative">
            <i class="bi bi-chat-dots icon" @click="showChat = true"></i>
            <span class="tooltip-text">Messages</span>
            <span class="badge bg-danger rounded-pill notification-badge">1</span>
          </li>
          <li class="nav-item d-flex align-items-center position-relative" @click="toggleNotifications">
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
          </li>

          <!-- Profile dropdown -->
          <li class="nav-item dropdown d-flex align-items-center position-relative">
            <a
              class="nav-link dropdown-toggle p-0"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="bi bi-person-circle icon" title="Profile"></i>
              <span class="tooltip-text">Profile</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><router-link to="/profile" class="dropdown-item">View Profile</router-link></li>
              <li><a href="#" class="dropdown-item" @click="logout">Logout</a></li>
              <li><router-link to="/signup" class="dropdown-item">Sign Up</router-link></li>
              <li><router-link to="/login" class="dropdown-item">Sign In</router-link></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <chat-modal v-if="showChat" @close="showChat = false"></chat-modal>
  <booking-form v-if="showBookingForm" @close="showBookingForm = false"></booking-form>
</template>

<script>
import ChatModal from '@/Components/Messanger.vue'
import BookingForm from '@/Components/BookingForm.vue'

export default {
  components: {
    ChatModal,
    BookingForm
  },
  data() {
    return {
      showChat: false,
      showBookingForm: false,
      showOptions: false,
      showNotifications: false,
      notifications: [
        'New comment on your post',
        'New like on your photo',
        'Friend request received'
        // Add more notifications as needed
      ]
    }
  },
  methods: {
    logout() {
      console.log('Logging out...')
    },
    toggleOptions() {
      this.showOptions = !this.showOptions
    },
    viewServices() {
      console.log('View Services clicked')
    },
    toggleNotifications() {
      this.showNotifications = !this.showNotifications
    }
  }
}
</script>

<style scoped>
/* Navbar Styles */
.navbar {
  background-color: #fff;
  padding: 1rem;
  top: 0;
  width: 100%;
  z-index: 1000;
}

.options-container {
  display: flex;
  justify-content: center;
  flex-direction: column;
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-40%);
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  z-index: 100;
  width: 400px;
}

.options-container button {
  padding: 10px 20px;
  background-color: orange;
  color: white;
  border: none;
  cursor: pointer;
  width: 100%;
}

.options-container button:last-child {
  margin: 10px 0 0 0;
}

.options-container button:hover {
  background-color: #218838;
}

.dropdown-menu {
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: none;
  border-radius: 5px;
  padding: 10px 0;
}

.dropdown-menu .dropdown-item {
  padding: 8px 20px;
  color: #343a40;
}

.dropdown-menu .dropdown-item i {
  margin-right: 10px;
}

.dropdown-menu .dropdown-item:hover {
  background-color: orange;
  color: #fff;
}

.dropdown-toggle::after {
  display: none;
}

.main-wrapper {
  padding: 20px;
  background-color: #f8f9fa;
}

.logo {
  width: 200px;
  height: auto;
  padding: 7px 50px 10px 0;
}

.brand-text {
  font-size: 20px;
  color: #ff7f50;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
  text-decoration: none;
}

.navbar-toggler {
  border-color: rgba(0, 0, 0, 0.1);
}

.search-form {
  flex: 1;
  display: flex;
  justify-content: center;
}

.notification-badge {
  position: absolute;
  top: 0;
  right: 11px;
  z-index: 1;
  font-size: 0.8rem;
}

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
  align-items: center;
  opacity: 0;
  transition: opacity 0.3s;
  font-size: 15px;
}

.nav-item:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}

.notification-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  width: 200px;
  z-index: 1000;
  margin-top: 5px;
}

.notification-dropdown ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.notification-dropdown li {
  padding: 10px;
  border-bottom: 1px solid #eee;
}

.notification-dropdown li:last-child {
  border-bottom: none;
}

/* Chat Modal Styles */
.chat-modal-wrapper {
  position: fixed;
  top: 10%;
  right: 2%;
  width: 300px;
  height: 400px;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  z-index: 1050;
  display: flex;
  flex-direction: column;
}

@media (max-width: 992px) {
  .navbar-brand {
    flex-direction: column;
    align-items: center;
  }

  .brand-text {
    font-size: 20px;
  }
}

@media (max-width: 576px) {
  .navbar-nav {
    flex-direction: column;
  }

  .nav-item {
    margin-bottom: 0.5rem;
    gap: 2rem;
  }

  .search-form {
    margin: 0;
    width: 100%;
  }
}

.search-form .form-control {
  border: 2px solid orange;
  border-radius: 20px;
  width: 400px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.search-form .form-control:hover {
  border-color: darkorange;
  box-shadow: 0 0 5px rgba(255, 165, 0, 0.5);
}
</style>
