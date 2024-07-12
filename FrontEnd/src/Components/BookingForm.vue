<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <h3>Book Service</h3>
            <button class="close" @click="$emit('close')">&times;</button>
          </div>
          <div class="modal-body">
            <div v-if="service">
              <form @submit.prevent="submitBooking" class="booking-form">
                <div class="form-group-map-container">
                  <div class="form-group-map">
                    <div class="input-group">
                      <input type="hidden" v-model="location" />
                      <input
                        type="text"
                        class="location"
                        v-model="reverseGeocodeResult"
                        @input="searchSimilarPlaces"
                        placeholder="Enter location or use the map icon"
                        required
                      />
                      <span class="input-group-append">
                        <button type="button" class="btn btn-map" @click="getCurrentLocation">
                          <i class="bi bi-geo-alt"></i>
                        </button>
                      </span>
                    </div>
                    <div v-if="similarPlaces.length" class="similar-places">
                      <ul>
                        <li
                          v-for="place in similarPlaces"
                          :key="place.id"
                          @click="selectPlace(place)"
                        >
                          {{ place.place_name }}
                        </li>
                      </ul>
                    </div>
                    <div class="form-group">
                      <label for="bookingDate">Booking Date:</label>
                      <div class="date">
                        <input type="date" v-model="bookingDate" required class="date" />
                        <button type="button" class="btn btn-map" @click="setTodayDate">
                          Today
                        </button>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="promotion">Promotion Code:</label>
                      <input
                        type="text"
                        v-model="promotionCode"
                        placeholder="Enter promotion code (if any)"
                      />
                    </div>
                    <div class="form-group">
                      <textarea
                        type="text"
                        v-model="information"
                        placeholder="More information....."
                      />
                    </div>
                    
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Book</button>
                  </div>
                  <div class="map" ref="mapContainer"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import mapboxgl from 'mapbox-gl'
import 'mapbox-gl/dist/mapbox-gl.css'

mapboxgl.accessToken =
  'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg'

const props = defineProps({
  service: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['close'])

const location = ref('')
const reverseGeocodeResult = ref('')
const selectedService = ref('')
const bookingDate = ref('')
const description = ref('')
const promotionCode = ref('')
const information = ref('')

const categories = ref([])
const services = ref([])
const similarPlaces = ref([])

onMounted(async () => {
  await fetchCategories()
  await fetchServices()
  initializeMap()
})

async function fetchCategories() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/category/list')
    categories.value = response.data
  } catch (error) {
    console.error('Error fetching categories:', error)
  }
}

async function fetchServices() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/service/list')
    services.value = response.data
  } catch (error) {
    console.error('Error fetching services:', error)
  }
}

const submitBooking = async () => {
    const userString = localStorage.getItem('user');
    const user = JSON.parse(userString);
    const user_id = user.id;
    const bookingData = {
        service_id: props.service.id,
        user_id: user_id,
        latitude: location.value.split(',')[0].trim(), // Corrected latitude extraction
        longitude: location.value.split(',')[1].trim(), // Corrected longitude extraction
        date: bookingDate.value,
        message: information.value || null,
        promotion_id: promotionCode.value || null,
    };
    console.log('Booking data:', bookingData);
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/bookin_immediatly', bookingData);
        console.log('Booking response:', response.data);
        emit('close');
    } catch (error) {
        console.error('Error submitting booking:', error);
    }
};
const getCurrentLocation = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const latLng = [position.coords.longitude, position.coords.latitude]
        location.value = `${latLng[1]}, ${latLng[0]}`
        reverseGeocode(latLng)
        map.flyTo({ center: latLng, zoom: 16 })
        addMarker(latLng)
        setTodayDate()
      },
      (error) => {
        console.error('Error getting location:', error)
      }
    )
  } else {
    alert('Geolocation is not supported by this browser.')
  }
}

const setTodayDate = () => {
  const today = new Date().toISOString().split('T')[0]
  bookingDate.value = today
}

let map
const initializeMap = () => {
  const cambodiaBounds = [
    [102.144, 10.486],
    [107.625, 14.704]
  ]

  map = new mapboxgl.Map({
    container: document.querySelector('.map'),
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [104.917, 12.5657],
    zoom: 6,
    maxBounds: cambodiaBounds
  })

  map.on('load', () => {
    let rmFoot = document.querySelector('.mapboxgl-ctrl-bottom-right .mapboxgl-ctrl-attrib')
    let rmFoot1 = document.querySelector('.mapboxgl-ctrl-bottom-left')
    if (rmFoot) {
      rmFoot.style.display = 'none'
      rmFoot1.style.display = 'none'
    }
  })
}

const addMarker = (latLng) => {
  new mapboxgl.Marker().setLngLat(latLng).addTo(map)
}

async function reverseGeocode(latLng) {
  try {
    const response = await axios.get(
      `https://api.mapbox.com/geocoding/v5/mapbox.places/${latLng[0]},${latLng[1]}.json`,
      {
        params: {
          access_token: mapboxgl.accessToken
        }
      }
    )
    if (response.data.features.length > 0) {
      const place = response.data.features[0]
      reverseGeocodeResult.value = place.place_name

      const street = place.text
      const specificLocation = place.properties.address
    } else {
      console.error('No results found for reverse geocoding.')
    }
  } catch (error) {
    console.error('Error during reverse geocoding:', error)
  }
}

const searchSimilarPlaces = async () => {
  try {
    const response = await axios.get(
      `https://api.mapbox.com/geocoding/v5/mapbox.places/${reverseGeocodeResult.value}.json`,
      {
        params: {
          access_token: mapboxgl.accessToken
        }
      }
    )
    similarPlaces.value = response.data.features.filter(
      (place) => place.context.some((context) => context.id.startsWith('country.')) &&
      place.context.some((context) => context.id.startsWith('region.')) &&
      place.context.some((context) => context.id.startsWith('place.')) &&
      place.context.some((context) => context.id.startsWith('postcode.'))
    )
  } catch (error) {
    console.error('Error searching similar places:', error)
  }
}

const selectPlace = (place) => {
  location.value = `${place.center[1]}, ${place.center[0]}`
  reverseGeocodeResult.value = place.place_name
  map.flyTo({ center: place.center, zoom: 16 })
  addMarker(place.center)
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-wrapper {
  width: 80%;
  margin: 20px;
  max-height: 90%;
  padding: 30px;
}

.modal-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
  padding: 30px;
  position: relative;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.5rem;
  font-weight: bold;
}

.close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-body {
  margin-bottom: 20px;
}

.booking-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group-map-container {
  display: flex;
  gap: 20px;
}

.form-group-map {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 50%;
}

.map {
  width: 50%;
  height: 300px;
  background-color: #f0f0f0;
}

.form-group-select {
  display: flex;
  width: 100%;
  justify-content: space-between;
  gap: 1rem;
}

.form-group-select select {
  flex: 1;
  padding: 10px;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: bold;
}
.date {
  display: flex;
}
.date input {
  border-radius: 0 5px 5px 0;
}

.form-group input,
.location,
.form-group textarea,
.form-group select {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  width: 100%;
}

.input-group {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.input-group input {
  flex: 1;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.input-group-append {
  margin-left: 10px;
}

.btn {
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 1rem;
  padding: 11.5px 20px;
  text-align: center;
}

.btn-primary {
  background-color: orange;
  color: white;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-map {
  background-color: orange;
  color: white;
  /* padding: 5px 0; */
  border: none;
}

.btn-map:hover {
  background-color: #0056b3;
}

.transition-enter-active,
.transition-leave-active {
  transition: opacity 0.3s ease;
}

.transition-enter-from,
.transition-leave-to {
  opacity: 0;
}
.similar-places {
  position: absolute;
  background-color: white;
  width: calc(50% - 20px);
  max-height: 200px;
  overflow-y: auto;
  z-index: 1000;
  margin-top: 50px;
  border: 1px solid #ddd;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.similar-places ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.similar-places ul li {
  padding: 10px;
  cursor: pointer;
}

.similar-places ul li:hover {
  background-color: #f0f0f0;
}
</style>