<template>
  <transition name="fade">
    <div v-if="showBookingForm" class="booking-form-modal position-fixed w-100 h-100 d-flex align-items-center justify-content-center">
      <div class="booking-form-container p-4 bg-white shadow-lg rounded">
        <button @click="closeBookingForm" class="close-btn">&times;</button>
        <h2 class="mb-4 text-center">Book a Service</h2>
        <form @submit.prevent="submitBooking">
          <div class="form-group mb-4">
            <label for="category">Category:</label>
            <select id="category" v-model="category" class="form-control" required>
              <option value="" disabled>Select Category</option>
              <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="service">Service:</label>
            <select id="service" v-model="service" class="form-control" required>
              <option value="" disabled>Select Service</option>
              <option v-for="ser in services" :key="ser" :value="ser">{{ ser }}</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="location">Location:</label>
            <div id="map" class="map-container"></div>
          </div>
          <div class="form-group mb-4">
            <label for="image">Upload Image:</label>
            <input type="file" id="image" @change="handleImageUpload" class="form-control-file" required />
          </div>
          <div class="form-group mb-4">
            <label>Buy Something New:</label>
            <div>
              <label class="radio-inline mr-3">
                <input type="radio" v-model="buyNew" value="yes"> Yes
              </label>
              <label class="radio-inline">
                <input type="radio" v-model="buyNew" value="no"> No
              </label>
            </div>
            <div v-if="buyNew === 'yes'" class="mt-3">
              <label for="newItem">New Item Details:</label>
              <input type="text" id="newItem" v-model="newItem" class="form-control" placeholder="Enter details...">
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Submit Booking</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref } from 'vue'
import mapboxgl from 'mapbox-gl'

const showBookingForm = ref(true)
const category = ref('')
const service = ref('')
const image = ref(null)
const categories = ref(['Plumbing', 'Electrical', 'Cleaning', 'Gardening'])
const services = ref(['Installation', 'Repair', 'Maintenance'])
const buyNew = ref('')
const newItem = ref('')

const closeBookingForm = () => {
  showBookingForm.value = false
}

const handleImageUpload = (event) => {
  image.value = event.target.files[0]
}

const submitBooking = () => {
  console.log('Category:', category.value)
  console.log('Service:', service.value)
  console.log('Image:', image.value)
  console.log('Buy New:', buyNew.value)
  if (buyNew.value === 'yes') {
    console.log('New Item:', newItem.value)
  }
  // Handle booking submission logic here
}

const initializeMap = () => {
  mapboxgl.accessToken = 'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg'
  const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [104.91, 12.5657], // Coordinates for Cambodia
    zoom: 7
  })
}
</script>

<style scoped>
.booking-form-modal {
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1050;
}

.booking-form-container {
  width: 800px;
  max-width: 90%;
  max-height: 95%;
  overflow-y: auto;
  position: relative;
  padding: 2rem;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  font-size: 2rem;
  cursor: pointer;
}

.map-container {
  height: 300px;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 1rem;
}

.btn-primary {
  background-color: orange;
  border: none;
  font-size: 1.2rem;
  padding: 12px;
  border-radius: 5px;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: darkorange;
}
</style>
