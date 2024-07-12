<template>
  <div class="container">
    <div class="mb-3 p-2">
      <div class="list-btn d-flex gap-sm-4 text-align:center">
        <h1>Customer Booking</h1>
      </div>
      <ul id="list-booking" class="list-group w-100 gap-3">
        <li
          v-for="book in bookings"
          :key="book.id"
          id="list_booking_item"
          class="list-group-item action rounded-2 d-flex w-100 flex-column flex-md-row align-items-center gap-3"
        >
          <div class="right d-flex align-items-center gap-3">
            <img
              src="/src/assets/img/cat.jpeg"
              class="rounded-circle"
              style="width: 50px; height: 50px"
              alt="Profile"
            />
            <h3 class="h5 mb-0">{{ book.customer_name }}</h3>
          </div>
          <div class="left d-flex align-items-center flex-grow-1 mt-2 mt-md-0">
            <p class="mb-0">Date: {{ book.date }}</p>
          </div>
          <div class="btn-groups d-flex flex-wrap flex-md-nowrap justify-content-end mt-2 mt-md-0 gap-5">
            <button class="btn" @click="rejectBooking(book.id)">
              <i class="bi text-danger text-25px bi-x-circle-fill"></i>
            </button>
            <button class="btn" @click="acceptBooking(book.id)">
              <i class="bi text-secondary text-25px bi-check2-circle"></i>
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const accessToken = localStorage.getItem('access_token');
const bookings = ref([]);

async function getBooking() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/booking', {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    });
    bookings.value = response.data;
  } catch (error) {
    if (error.response) {
      console.error('Backend error:', error.response.data);
    }
  }
}

async function acceptBooking(bookingId) {
  try {
    const fixer = JSON.parse(localStorage.getItem('user'));
    const fixer_id = fixer.id;

    const response = await axios.post('http://127.0.0.1:8000/api/fixer/accept', {
      fixer_id: fixer_id,
      booking_id: bookingId
    }, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    });
    console.log('Booking accepted:', response.data);
    getBooking(); // Refresh the bookings list after accepting
  } catch (error) {
    if (error.response) {
      console.error('Backend error:', error.response.data);
    }
  }
}

async function rejectBooking(bookingId) {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/fixer/reject', {
      booking_id: bookingId
    }, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    });
    console.log('Booking rejected:', response.data);
    getBooking(); // Refresh the bookings list after rejecting
  } catch (error) {
    if (error.response) {
      console.error('Backend error:', error.response.data);
    }
  }
}

onMounted(() => {
  getBooking();
});
</script>



<style scoped>
#booking,
#booked {
  cursor: pointer;
}
#booked {
  background: #000;
}
#list-booking button {
  background: #00000017;
}
#list-booking button:hover {
  background: orange;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
}
</style>
