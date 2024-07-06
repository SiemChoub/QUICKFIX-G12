<template>
  <div class="profile-right">
    <router-link to="/">
      <button class="btn btn-back"><i class="bi bi-arrow-left"></i> Back</button>
    </router-link>
  </div>
  <div class="profile-container">
    <div class="profile-left">
      <div class="profile-image">
        <div class="edit-profile">
          <div class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-camera-fill"></i> Edit Profile
          </div>
          <!-- Modal -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
          >
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Information</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <form ref="form">
                    <div class="group-input">
                      <label for="username" class="form-label">User Name:</label>
                      <input type="text" class="form-control" id="username" v-model="authStore.user.name"  />
                    </div>
                    <div class="group-input">
                      <label for="phone" class="form-label">Phone Number:</label>
                      <input type="tel" class="form-control" id="phone" v-model="authStore.user.phone" />
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" @click="update()">Update</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <img :src="authStore.user.profile" alt="Profile Image" class="center-image" />
      </div>
      <div class="profile-info">
        <div class="info">
          <label>Role:</label>
          <span class="info-value">{{ authStore.user.role }}</span>
        </div>
        <div class="info">
          <label>User Name:</label>
          <span class="info-value">{{ authStore.user.name }}</span>
        </div>
        <div class="info">
          <label>Email:</label>
          <span class="info-value">{{ authStore.user.email }}</span>
        </div>
        <div class="info">
          <label>Phone Number:</label>
          <span class="info-value">{{ authStore.user.phone }}</span>
        </div>
        <div class="info">
          <label>Create Date:</label>
          <span class="info-value">{{ authStore.user.created_at }}</span>
        </div>
        <div class="info">
          <label>Create Time:</label>
          <span class="info-value">{{ authStore.user.created_at }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth-store';
import axios from 'axios';

const authStore = useAuthStore();

const form = ref(null);

async function update() {
  try {
    const formValues = {
      name: authStore.user.name,
      phone: authStore.user.phone,
    };

    console.log('Form Values:', formValues);

    const response = await axios.put(`http://127.0.0.1:8000/api/profile/update/${authStore.user.id}`, formValues);

    if (response.status === 200) {
      console.log('Update successful:', response.data);
      
      // Debug logs
      console.log('Current localStorage user:', localStorage.getItem('user'));
      
      localStorage.removeItem('user');
      console.log('localStorage user removed');

      localStorage.setItem('user', JSON.stringify(response.data));
      console.log('Updated localStorage user:', localStorage.getItem('user'));
    } else {
      console.log('Update failed with status:', response.status);
    }
  } catch (error) {
    if (error.response) {
      console.error('Backend error:', error.response.data);
    }
  }
}

</script>

<style scoped>
.profile-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh;
  margin-top: 30px;
  background-color: #b6b3b3;
  border-radius: 5px;
  padding: 20px;
}
.profile-left {
  width: 70%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-self: center;
}

.profile-right {
  width: 10%;
  margin-left: 20px;
}

.profile-image {
  position: relative;
  text-align: center;
  justify-content: center;
  margin-bottom: 20px;
}
.profile-right a {
  list-style: none;
  text-decoration: none;
}

.profile-image img {
  width: 250px;
  height: 250px;
  border-radius: 50%;
  object-fit: cover;
}

.edit-profile {
  position: absolute;
  bottom: 10px; /* Adjust the positioning as needed */
  right: 10px; /* Adjust the positioning as needed */
}
.group-input{
  /* margin-right: 60%; */
  text-align: start;
}
.edit-profile .btn {
  background-color: orange;
  color: white;
  border: 1px solid orange;
  padding: 8px 16px;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s ease;
  display: flex;
  align-items: center;
}

.edit-profile .btn:hover {
  background-color: #ff7f50; /* Lighter shade of orange */
}

.btn-back {
  background-color: #6c757d;
  color: white;
  border: 1px solid #6c757d;
  padding: 8px 16px;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s ease;
  display: flex;
  align-items: center;
}

.btn-back:hover {
  background-color: orange; /* Darker shade of gray */
}

.profile-info {
  padding: 20px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.info {
  margin-bottom: 10px;
  display: flex;
  align-items: center;
}

.info label {
  width: 120px;
  font-weight: bold;
}

.info-value {
  flex: 1;
  margin-left: 20px;
}

@media (max-width: 768px) {
  .profile-container {
    flex-direction: column;
    height: auto;
  }

  .profile-left {
    width: 100%;
    margin-bottom: 20px;
  }

  .profile-info {
    padding: 10px;
  }
}
</style>