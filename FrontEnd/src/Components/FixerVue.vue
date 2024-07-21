<template>
  <div>
    <NavbarView />
    <div class="search-container mt-5 d-flex justify-content-center">
      <select class="form-select" v-model="selectedCareer">
        <option value="">Select Career</option>
        <option v-for="career in careers" :key="career.id" :value="career.name">
          {{ career.name }}
        </option>
      </select>
      <select class="form-select" v-model="selectedPlace">
        <option value="">Select Place</option>
        <option v-for="place in places" :key="place.id" :value="place.name">
          {{ place.name }}
        </option>
      </select>
    </div>
    <hr />

    <div class="repairers-list container m-4 d-flex gap-5 flex-wrap">
      <div v-if="filteredRepairers.length === 0" class="no-results">No repairers found.</div>
      <div v-for="repairer in filteredRepairers" :key="repairer.id" class="repairer-card">
        <div class="repairer-content">
          <div class="repairer-image">
            <img :src="repairer.image || 'https://via.placeholder.com/100'" alt="Repairer Image" />
          </div>
          <div class="repairer-info">
            <h3>
              {{ repairer.name }}
            </h3>
            <p class="career">
              Career: <span>{{ repairer.career }}</span>
            </p>
            <p class="place">
              Place: <span>{{ repairer.place }}</span>
            </p>
          </div>
          <div class="repairer-icons">
            <i class="bi bi-messenger"></i>
            <button
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#bookingModal"
              @click="openBookingModal(repairer.id)"
            >
              Book
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Booking Form -->
    <div
      class="modal fade"
      id="bookingModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitBooking" class="booking-form">
              <div class="form-group-map-container">
                <div class="form-group-map">
                  <input type="hidden" v-model="latitude" />
                  <input type="hidden" v-model="longitude" />

                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control map-search"
                      v-model="reverseGeocodeResult"
                      @input="searchSimilarPlaces"
                      placeholder="Enter location or use the map icon"
                    />

                    <span class="input-group-append">
                      <button type="button" class="btn btn-map" @click="getCurrentLocation">
                        <i class="bi bi-geo-alt"></i>
                      </button>
                    </span>
                  </div>

                  <div v-if="similarPlaces.length" class="similar-places">
                    <ul class="list-group">
                      <li
                        v-for="place in similarPlaces"
                        :key="place.place_id"
                        class="list-group-item"
                        @click="selectPlace(place)"
                      >
                        {{ place.place_name }}
                      </li>
                    </ul>
                  </div>

                  <input
                    v-else
                    type="hidden"
                    class="form-control map-search"
                    v-model="reverseGeocodeResult"
                    placeholder="Enter location or use the map icon"
                    required
                  />

                  <div class="form-group">
                    <label for="bookingDate">Booking Date:</label>
                    <div class="date">
                      <input type="date" v-model="bookingDate" required class="form-control" />
                      <button type="button" class="btn btn-secondary day" @click="setTodayDate">
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
                      class="form-control"
                    />
                  </div>

                  <div class="form-group">
                    <textarea
                      v-model="description"
                      placeholder="More information....."
                      class="form-control"
                    ></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary">Book</button>
                </div>
                <div class="map" ref="mapContainer"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, computed, onMounted, defineProps, defineEmits } from 'vue'
import axios from 'axios'
import NavbarView from '@/Components/WebHeaderMenu.vue'
import '@fortawesome/fontawesome-free/css/all.css'
import { Loader } from '@googlemaps/js-api-loader'

const apiKey = 'AIzaSyAEkPs2AFjaazwiQaO25lkaHp-nlX00sK0'
const loader = new Loader({
  apiKey: apiKey,
  version: 'beta',
  libraries: ['places']
})
const fixers = ref([])
const careers = ref([{ name: '' }])
const places = ref([{ name: '' }])
const selectedCareer = ref('')
const map = ref(null)
const mapContainer = ref(null)
const selectedPlace = ref('')
const latitude = ref('')
const geocoder = ref(null)
const longitude = ref('')
const reverseGeocodeResult = ref('')
const selectedService = ref('')
const bookingDate = ref('')
const description = ref('')
const promotionCode = ref('')
const information = ref('')
const categories = ref([])
const services = ref([])
const similarPlaces = ref([])
const placesService = ref(null)
const fixer_id = ref()

onMounted(async () => {
  await fetchCategories()
  await fetchServices()
  getFixer()
  await loader.load()
  initializeMap()
})
const openBookingModal = (id) => {
  fixer_id.value = id
}

const getFixer = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/fixer/list')
    fixers.value = response.data
  } catch (error) {
    console.error('Error fetching fixers:')
  }
}

const openBookingForm = (repairer) => {
  console.log('Opening modal for repairer:', repairer)
  $('#bookingModal').on('shown.bs.modal')
}


const filteredRepairers = computed(() => {
  let filtered = fixers.value

  if (selectedCareer.value) {
    filtered = filtered.filter((repairer) => repairer.career === selectedCareer.value)
  }

  if (selectedPlace.value) {
    filtered = filtered.filter((repairer) => repairer.place === selectedPlace.value)
  }

  return filtered
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

const initializeMap = () => {
  loader.load().then(() => {
    map.value = new google.maps.Map(document.querySelector('.map'), {
      center: { lat: 12.5657, lng: 104.917 },
      zoom: 8,
    });

    geocoder.value = new google.maps.Geocoder();
    placesService.value = new google.maps.places.PlacesService(map.value);
  });
};

const getCurrentLocation = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const { latitude: lat, longitude: lng } = position.coords;
        const latLng = new google.maps.LatLng(lat, lng);
        latitude.value = lat
        longitude.value = lng

        if (map.value) {
          map.value.setCenter(latLng);
          map.value.setZoom(14);

          if (marker.value) {
            marker.value.setMap(null);
          }
          marker.value = new google.maps.Marker({
            position: latLng,
            map: map.value,
            title: 'Your current location',
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
          });

          const circle = new google.maps.Circle({
            strokeColor: '#2196F3',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#2196F3',
            fillOpacity: 0.35,
            map: map.value,
            center: latLng,
            radius: 1000
          });

          const bounds = new google.maps.LatLngBounds();
          bounds.extend(marker.value.getPosition());
          bounds.union(circle.getBounds());
          map.value.fitBounds(bounds);
          console.log(bounds);

        }
      },
      (error) => {
        console.error('Error getting location:', error);
      },
      {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
      }
    );
  } else {
    alert('Geolocation is not supported by this browser.');
  }
};

const searchSimilarPlaces = async () => {
  try {
    if (!reverseGeocodeResult.value.trim()) {
      similarPlaces.value = [];
      return;
    }

    const request = {
      query: reverseGeocodeResult.value,
      fields: ['formatted_address', 'name', 'place_id', 'geometry']
    };

    placesService.value.textSearch(request, (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        similarPlaces.value = results.map((place) => ({
          place_id: place.place_id,
          place_name: place.name,
          location: place.geometry.location
        }));
      } else {
        console.error('PlacesService failed with status:', status);
        similarPlaces.value = [];
      }
    });
  } catch (error) {
    console.error('Error searching similar places:', error);
    similarPlaces.value = [];
  }
};

const selectPlace = (place) => {
  reverseGeocodeResult.value = place.place_name;
  similarPlaces.value = [];
  const latLng = new google.maps.LatLng(place.location.lat(), place.location.lng());

  // Update latitude and longitude
  latitude.value = place.location.lat();
  longitude.value = place.location.lng();

  // Update the map center and marker
  if (map.value) {
    map.value.setCenter(latLng);
    map.value.setZoom(14);

    if (marker.value) {
      marker.value.setMap(null);
    }
    marker.value = new google.maps.Marker({
      position: latLng,
      map: map.value,
      title: place.place_name,
      icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
    });

    // Optionally, fit map bounds to include the marker
    map.value.panTo(latLng);
  }
};


const setTodayDate = () => {
  bookingDate.value = new Date().toISOString().split('T')[0]
}
</script>

<style scoped>
.search-container {
  text-align: center;
  margin-top: 500px;
  background: #000;
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

.career span {
  color: blue;
  font-family: cursive;
}

.repairers-list {
  margin-top: 20px;
  display: flex;
  flex-wrap: wrap;
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
  border: 2px solid #fff;
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
  font-weight: bold;
}

.repairer-info p {
  margin: 5px 0;
  color: #666;
}

.repairer-icons {
  align-self: flex-end;
  display: flex;
  justify-content: space-between;
  align-items: end;
  width: 40%;
  border-radius: 0px;
  padding: 5px 0;
  /* gap: ; */
}

.repairer-icons i {
  color: white;
  font-size: 20px;
  margin-right: 10px;
  padding: 4px 10px;
  border-radius: 50%;
  background: orange;
  cursor: pointer;
}

.repairer-icons button {
  /* flex: 0 0 auto; */
  margin-right: 10px;
  background: orange;
  /* border-redius:1px; */
  padding: 8px 10px;
  border: none;
}
.repairer-icons .btn-primary:hover {
  background-color: gainsboro;
  box-shadow: rgba(0, 0, 0, 1);
  color: orange;
}
.repairer-icons i:hover {
  cursor: pointer;
  color: #000;
}
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
.map-search {
  padding: 11px 0;
}
.day {
  background: orange;
  color: white;
  border: none;
  border-radius: 0 5px 5px 0;
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
  border: 1px solid orange;
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
  border: 1px solid orange;
}

.input-group-append {
  margin-left: 10px;
  /* background: #000; */
  width: 18%;
}

.btn {
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
  padding: 11px 10px;
  border: none;
  width: 100%;
  border-radius: 0 5px 5px 0;
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
  width: calc(100% - 50%);
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
textarea {
  height: 100px;
  resize: none;
}
</style>