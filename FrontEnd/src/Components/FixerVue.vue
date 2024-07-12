<template>
  <div>
    <NavbarView />
    <div class="search-container mt-5 d-flex justify-content-center">
      <select v-model="selectedCareer" class="form-select" aria-label="Select Career">
        <option value="">Select Career</option>
        <option v-for="career in careers" :key="career.id" :value="career.name">
          {{ career.name }}
        </option>
      </select>
      <select v-model="selectedPlace" class="form-select" aria-label="Select Place">
        <option value="">Select Place</option>
        <option v-for="place in places" :key="place.id" :value="place.name">
          {{ place.name }}
        </option>
      </select>
    </div>
    <hr />
    <div class="repairers-list container m-4 d-flex gap-5">
      <div v-if="filteredRepairers.length === 0" class="no-results">No repairers found.</div>
      <div v-for="repairer in fixers" :key="repairer.id" class="repairer-card">
        <div class="repairer-content">
          <div class="repairer-image">
            <img v-if="repairer.image" :src="repairer.image" alt="Repairer Image" />
            <!-- Otherwise, display a default image -->
            <img
              v-else
              src="https://media.istockphoto.com/id/1451587807/vector/user-profile-icon-vector-avatar-or-person-icon-profile-picture-portrait-symbol-vector.jpg?s=612x612&w=0&k=20&c=yDJ4ITX1cHMh25Lt1vI1zBn2cAKKAlByHBvPJ8gEiIg="
              alt="Default Repairer Image"
            />
          </div>
          <div class="repairer-info">
            <h3>
              Name: <span>{{ repairer.name }}</span>
            </h3>
            <p class="career">
              Career: <span> Repair car{{ repairer.career }}</span>
            </p>
            <p class="place">
              Place: <span> {{ repairer.place }}</span>
            </p>
            <p class="phone">Tel: <span>111111</span></p>
          </div>
          <div class="repairer-icons">
            <i class="fas fa-phone"></i>
            <button class="btn btn-primary" @click="bookAppointment(repairer)">Book</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { ref, computed } from 'vue'
import NavbarView from '@/Components/WebHeaderMenu.vue' // Adjust path based on your structure

export default {
  components: {
    NavbarView
  },
  data() {
    return {
      fixers: [],
      careers: [{ name: '' }],
      places: [{ name: '' }],
      repairers: [
        {
          name: '',
          career: '',
          place: '',
          image: '' // Adjust path based on your structure
        }
      ],
      selectedCareer: '',
      selectedPlace: ''
    }
  },
  mounted() {
    this.getFixer()
  },
  methods: {
    async getFixer() {
      try {
        this.showSpinner = true
        const response = await axios.get('http://127.0.0.1:8000/api/fixer/list')
        console.log(response.data)
        this.fixers = response.data
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errorMessage = Object.values(error.response.data.errors).flat().join(' ')
        } else {
          console.error('Error registering user:', error.message)
          this.errorMessage = 'Registration failed. Please try again.'
        }
      } finally {
        this.showSpinner = false // Hide spinner regardless of success or failure
      }
    },
    loginWithGoogle() {
      // Implement Google login functionality if needed
    }
  },
  computed: {
    filteredRepairers() {
      let filtered = this.repairers

      if (this.selectedCareer) {
        filtered = filtered.filter((repairer) => repairer.career === this.selectedCareer)
      }

      if (this.selectedPlace) {
        filtered = filtered.filter((repairer) => repairer.place === this.selectedPlace)
      }

      return filtered
    }
  }
  // methods: {
  //   bookAppointment(repairer) {
  //     // Implement your booking logic here
  //     console.log(Booking appointment with ${repairer.name});
  //   },
  // },
}
</script>

<style scoped>
.search-container {
  margin-top: 20px;
  text-align: center;
}
hr {
  border: 2px solid orange;
  margin-top: 50px;
  width: 94%;
  margin: auto;
  margin-top: 40px;
  margin-bottom: 40px;
  align-self: center;
}

.form-select {
  margin: 0 35px;
  margin-top: 80px;
  padding: 8px 12px; /* Adjust padding for better spacing */
}
.career span {
  color: blue;
  font-family: cursive;
}
.repairers-list {
  margin-top: 20px;
  display: flex;
  flex-wrap: wrap;
}
.repairer-card {
  background-color: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  margin-bottom: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out;
  overflow: hidden;
  width: 30%;
}

.repairer-card:hover {
  transform: translateY(-5px);
}

.repairer-content {
  display: flex;
  align-items: center;
  padding: 15px;
}

.repairer-image {
  flex: 0 0 auto;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #fff; /* Optional: Add a border around the image */
}

.repairer-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.repairer-info {
  padding-left: 15px;
  height: 25vh;
}

.repairer-info h3 {
  margin: 0;
  font-size: 1.2rem;
  color: #333;
  margin-top: 15px;
}

.repairer-info p {
  margin: 5px 0;
  color: #666;
  font-weight: bold;
}

.repairer-icons {
  margin-top: 10px;
}

.repairer-icons i {
  margin-right: 10px;
  color: #888;
}

.btn-primary {
  background-color: orange;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 10%;
  margin-top: 90px;
}

.btn-primary:hover {
  background-color: bisque;
  color: black;
}
</style>