<template>
  <div class="profile-right">
<router-link to="/">
  <button class="btn btn-back">
    <i class="bi bi-arrow-left"></i> Back
  </button>
</router-link>  </div>
  <div class="profile-container">
    <div class="profile-left">
      <div class="profile-image">
        <div class="edit-profile">
          <router-link to="/profile/edit" class="btn btn-orange">
            <i class="bi bi-camera-fill"></i> Edit Profile
          </router-link>
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
import { useAuthStore } from '@/stores/auth-store'

const authStore = useAuthStore()
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
.profile-right a{
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