<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar bg-light border-end">
      <h1 class="sidebar-title">QUICKFIX</h1>
      <div class="sidebar-content">
        <button
          v-for="item in menuItems"
          :key="item.name"
          @click="setCurrentView(item.view)"
          class="btn btn-outline-secondary w-100 mb-2"
          :class="{
            active: currentView === item.view,
            'position-relative': item.view === 'ChatView'
          }"
        >
          {{ item.name }}
          <span
            v-if="item.notification"
            class="notification bg-white text-dark rounded-circle position-absolute top-0 start-100 translate-middle"
            >{{ item.notification }}</span
          >
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <div class="d-flex w-100 align-items-center">
            <div class="profile d-flex align-items-center gap-2">
              <div class="cardPro border rounded-circle p-2">
                <img
                  src="/src/assets/img/cat.jpeg"
                  alt="pro"
                  class="w-100 bg-black shadow-lg rounded-circle"
                />
              </div>
              <div class="cardtext">
                <h6 class="m-0">Name: Koeuk</h6>
                <h6 class="m-0">ID: 123456</h6>
                <h6 class="m-0">Joined: 12 June 2024</h6>
              </div>
            </div>
            <div class="dropdown ms-auto">
              <i class="bi bi-list text-25px" data-bs-toggle="dropdown"></i>
              <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-2">
                <li><a href="#" class="dropdown-item">Details</a></li>
                <li>
                  <a
                    href="#"
                    class="dropdown-item"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal"
                    >Change</a
                  >
                </li>
                <li><a href="#" class="dropdown-item">Log Out</a></li>
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

    <!-- Modal -->
    <div
      class="modal fade"
      id="editProfileModal"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="editProfileModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form id="updateForm">
              <div class="mb-3">
                <label for="profilePic" class="form-label">Picture:</label>
                <input type="file" class="form-control" id="profilePic" />
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" value="Koeuk" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" style="background-color: orange">
              Update
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
      menuItems: [
        { name: 'Dashboard', view: 'Dashboard' },
        { name: 'List Booking', view: 'Booking' },
        { name: 'My Skill', view: 'Skill' },
        { name: 'Message', view: 'ChatView', notification: 2 },
        { name: 'History', view: 'HistoryView' }
      ],
      currentView: 'Dashboard'
    }
  },
  methods: {
    setCurrentView(view) {
      this.currentView = view
    }
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
