 <style>
.logo-color {
  background-color: orange;
  color: #ffffff;
  font-weight: bold;
  width: 70px;
  height: 70px;
  border-radius: 100%;
  margin-left: 26px;
}
.quickfix {
  display: flex;
  position: absolute;
  top: 30px;
  left: 50px;
}
</style>

<template>
  <div class="container  p-0">
    <div class="d-flex">
      <!-- Sidebar -->
      <aside class="sidebar border-0 m-0 shadow-md h-100 bg-light border-end">
        <div class="logo">
          <div class="logo-color"></div>
          <h2 class="quickfix">QUICKFIX</h2>
        </div>

        <div class="sidebar-content ">
          <button
            :class="{
              'btn-outline-secondary active': currentView === 'Dashboard',
              'btn-outline-secondary': currentView !== 'Dashboard'
            }"
            @click="setCurrentView('Dashboard')"
            class="btn w-100 mb-2"
          >
            Dashboard
          </button>
          <div class="dropdown w-100" :class="{ active: isDropdownActive }">
            <button
              class="btn btn-outline-secondary w-100 mb-2 dropdown-toggle"
              type="button"
              id="dropdownBookingList"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              @click="toggleDropdown"
            >
              Booking List
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownBookingList">
              <li>
                <a
                  class="dropdown-item d-flex h-auto justify-center"
                  href="#"
                  @click="setCurrentView('Booking')"
                  >Customer Booking</a
                >
              </li>
              <li>
                <a
                  class="dropdown-item d-flex h-auto justify-center"
                  href="#"
                  @click="setCurrentView('Booking2')"
                  >Accept Booked</a
                >
              </li>
            </ul>
          </div>
          <button
            :class="{
              'btn-outline-secondary active': currentView === 'Skill',
              'btn-outline-secondary': currentView !== 'Skill'
            }"
            @click="setCurrentView('Skill')"
            class="btn w-100 mb-2"
          >
            Skill
          </button>
          <button
            :class="{
              'btn-outline-secondary active': currentView === 'History',
              'btn-outline-secondary': currentView !== 'History'
            }"
            @click="setCurrentView('History')"
            class="btn w-100 mb-2"
          >
            History
          </button>
        </div>
      </aside>

      <!-- Main Content -->
      <div class="main-content flex-grow-1">
        <!-- Navbar -->
        <nav class="navbar buttom-shadow navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <div class="d-flex w-100 align-items-center">
              <!-- Profile section -->
              <div class="profile d-flex align-items-center gap-2">
                <!-- Profile image -->
                <div class="cardPro border rounded-circle p-2">
                  <img
                    src="/src/assets/img/cat.jpeg"
                    alt="pro"
                    class="w-100 bg-black shadow-lg rounded-circle"
                  />
                </div>
                <!-- User info -->
                <div class="cardtext">
                  <h6 class="m-0">{{ users.name }}</h6>
                  <h6 class="m-0">{{ users.id }}</h6>
                </div>
              </div>
              <!-- Dropdown menu -->
              <div class="dropdown ms-auto">
                <a
                  class="bi bi-list text-25px dropdown-toggle"
                  href="#"
                  role="button"
                  id="dropdownMenuLink"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                ></a>
                <ul
                  class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-2"
                  aria-labelledby="dropdownMenuLink"
                >
                  <li><router-link to="/profile"  class="dropdown-item text-center">View Profile</router-link></li>
                  <li>
                    <a
                      href="#"
                      class="dropdown-item text-center"
                      data-bs-toggle="modal"
                      data-bs-target="#editProfileModal"
                      >Change</a
                    >
                  </li>
                  <li>
                    <div @click="logout" class="dropdown-item text-center">Log Out</div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>

        <!-- Dynamic Content -->
        <div class="content p-3">
          <component :is="currentView"></component>
        </div>
      </div>

      <!-- Edit Profile Modal -->
      <!-- Modal code remains unchanged -->
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Dashboard from './DashBoard.vue'
import Booking from './ListBooking.vue'
import Skill from './CardSkill.vue'
import ChatView from './ChatView.vue'
import HistoryView from './HistoryView.vue'

export default {
  name: 'NavBar',
  components: {
    Dashboard,
    Booking,
    Skill,
    ChatView,
    HistoryView
  },
  data() {
    return {
      users: [],
      currentView: 'Dashboard',
      isDropdownActive: false
    }
  },
  methods: {
    setCurrentView(view) {
      this.currentView = view
      if (view === 'Booking' || view === 'Booking2') {
        this.isDropdownActive = true
      } else {
        this.isDropdownActive = false
      }
    },
    toggleDropdown() {
      this.isDropdownActive = !this.isDropdownActive
    },
    userData() {
      this.users = JSON.parse(localStorage.getItem('user'))
    },
    async logout() {
      try {
        const token = localStorage.getItem('access_token')
       axios.post(
          'http://127.0.0.1:8000/api/logout',
          {
            headers: {
              Authorization: `Bearer ${token}`
            }
          }
        )
        localStorage.removeItem('user')
        localStorage.removeItem('access_token')
        this.$router.push('/')
      } catch (error) {
        console.error('Logout failed:', error)
      }
    }
  },
  mounted() {
    this.userData()
  }
}
</script>

<style scoped>
.d-flex {
  height: 100vh;
}

.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #f8f9fa;
  padding: 1rem 0;
}

.sidebar-title {
  text-align: center;
  margin-bottom: 1rem;
  width: 100%;
}
.dropdown-item {
  padding: 10px 0;
}

.sidebar-content {
  display: flex;
  flex-direction: column;
  margin-top: 60px;
}

.btn-outline-secondary {
  position: relative;
  transition: all 0.3s ease-in-out;
  border: none;
  padding: 15px 0;
  margin: 20px 0;
}

.btn-outline-secondary:hover {
  background-color: orange;
  color: white;
}

.btn-outline-secondary.active {
  background-color: orange;
  color: white;
}

.dropdown.active .dropdown-toggle {
  background-color: orange;
  color: white;
}

.notification {
  font-size: 0.75rem;
  width: 1.5rem;
  height: 1.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

.main-content {
  width: calc(100% - 250px);
  height: 100vh;
}

.navbar {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 1rem;
  border-bottom: 1px solid #dee2e6;
  height: 15vh;
}

.profile {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.cardPro {
  max-width: 50px;
  max-height: 50px;
  overflow: hidden;
}

.cardPro img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cardtext h6 {
  margin: 0;
  font-size: 0.875rem;
}

.dropdown .bi {
  cursor: pointer;
  color: #dc2727;
  transition: color 0.3s;
}

.dropdown .bi:hover {
  color: orange;
}

.modal-header,
.modal-footer {
  border-bottom: 1px solid #dee2e6;
  border-top: 1px solid #dee2e6;
}

@media (max-width: 768px) {
  .cardPro {
    max-width: 40px;
  }

  .sidebar {
    width: 200px;
  }

  .main-content {
    width: calc(100% - 200px);
  }

  .sidebar-title {
    font-size: 1.5rem;
  }

  .navbar {
    height: auto;
  }
}
</style>
