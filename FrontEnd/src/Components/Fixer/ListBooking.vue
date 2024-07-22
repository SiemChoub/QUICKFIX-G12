<template>
  <div class="container">
    <div class="mb-3 p-2">
      <div class="list-btn d-flex gap-sm-4 justify-center">
        <h1 class="text-3xl font-bold text-gray-900">Customer Bookings</h1>
      </div>
      <ul id="list-booking">
        <li
          v-for="book in bookings"
          :key="book.id"
          id="list_booking_item"
          class="list-group-item action rounded-2 mb-4 card"
        >
          <div class="card-body d-flex">
            <div class="profile-info flex-grow-1">
              <div class="d-flex align-items-center gap-3">
                <img
                  src="/src/assets/img/cat.jpeg"
                  class="rounded-circle"
                  style="width: 50px; height: 50px;"
                  alt="Profile"
                />
                <div>
                  <h3 class="h5 mb-0">{{ book.user.name }}</h3>
                  <p class="mb-0">{{ book.user.location }}</p>
                  <p class="mb-0">Service: {{ getServiceName(book.booking.service_id) }}</p>
                  <p class="mb-0">Date: {{ book.booking.date }}</p>
                </div>
              </div>
            </div>
            <div class="map-placeholder bg-gray-200 rounded-lg ml-3">
              <div class="map"></div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center mt-3">
            <div>
              <button class="btn btn-accept" @click="acceptBooking(book.booking.id)">
                Accept Booking
                <i class="bi text-secondary bi-check2-circle"></i>
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const accessToken = localStorage.getItem('access_token')
const bookings = ref([])

async function getBookings() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/booking', {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    })
    bookings.value = response.data.bookings
    // Initialize Google Maps for each booking
    initializeMaps();
  } catch (error) {
    console.error('Backend error:', error.response.data)
  }
}

async function acceptBooking(bookingId) {
  try {
    const fixer = JSON.parse(localStorage.getItem('user'))
    const fixer_id = fixer.id

    const response = await axios.post(
      'http://127.0.0.1:8000/api/fixer/accept',
      {
        fixer_id: fixer_id,
        booking_id: bookingId
      },
      {
        headers: {
          Authorization: `Bearer ${accessToken}`,
          'Content-Type': 'application/json'
        }
      }
    )
    getBookings()
  } catch (error) {
    console.error('Backend error:', error.response.data)
  }
}

function initializeMaps() {
  // Initialize Google Maps for each booking with lat/lng
  bookings.value.forEach(book => {
    const mapElement = document.getElementById(".map");
    console.log(mapElement);
    if (mapElement = null) {
      const map = new google.maps.Map(mapElement, {
        center: { lat: parseFloat(book.booking.latitude), lng: parseFloat(book.booking.longitude) },
        zoom: 12 // Adjust zoom level as needed
      });
      new google.maps.Marker({
        position: { lat: parseFloat(book.booking.latitude), lng: parseFloat(book.booking.longitude) },
        map: map,
        title: book.user.name // Marker title
      });
    }
  });
}

// Load Google Maps API script asynchronously
function loadGoogleMapsScript() {
  const script = document.createElement('script');
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyAEkPs2AFjaazwiQaO25lkaHp-nlX00sK0&callback=initializeMaps`;
  script.defer = true;
  script.async = true;
  document.head.appendChild(script);
}

function getServiceName(serviceId) {
  // Replace with your logic to get service name based on serviceId
  // Example implementation:
  switch (serviceId) {
    case 1:
      return 'Service A';
    case 2:
      return 'Service B';
    default:
      return 'Unknown Service';
  }
}

onMounted(() => {
  getBookings();
  loadGoogleMapsScript();
});
</script>

<style scoped>
#list-booking button {
  background: #00000017;
}
#list-booking button:hover {
  background: orange;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
}

.card {
  width: 100%;
  margin-bottom: 20px;
  transition: transform 0.3s ease-in-out;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.card-body {
  display: flex;
}

.profile-info {
  flex-grow: 1;
  padding-right: 20px;
}

.map-placeholder {
  width: 40%;
  height: 200px; /* Adjust height as needed */
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  font-size: 1.2rem;
  color: #333;
}

.map {
  width: 100%;
  height: 100%;
  border-radius: 8px;
}

.btn-accept {
  background-color: orange;
  color: white;
  border: none;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-right: 20px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius: 4px;
}

.btn-accept:hover {
  background-color: #45a049;
  color: white;
}
</style>
