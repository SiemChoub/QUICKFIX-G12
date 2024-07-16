<template>
  <div class="container">
    <div class="mb-3 p-2">
      <ul id="list-booking" class="list-group w-100 gap-3">
      </ul>
    </div>

    <div class="mb-3 p-2">
      <div class="list-btn d-flex gap-sm-4 text-align:center">
        <h1>Accepted Fixers</h1>
      </div>
      <ul id="list-accepted-fixers" class="list-group w-100 gap-3">
        <li
          v-for="fixer in acceptedFixers"
          :key="fixer.id"
          class="list-group-item action rounded-2 d-flex w-100 flex-column flex-md-row align-items-center gap-3"
        >
          <div class="right d-flex align-items-center gap-3">
            <img
              :src="
                fixer.profile_image_url
                  ? fixer.profile_image_url
                  : '/src/assets/img/default-profile.jpg'
              "
              class="rounded-circle"
              style="width: 50px; height: 50px"
              alt="Profile"
            />
            <h3 class="h5 mb-0">{{ fixer.booking_type_id }}</h3>
          </div>
          <div class="left d-flex align-items-center flex-grow-1 mt-2 mt-md-0">
            <p class="mb-0">Email: {{ fixer.email }}</p>
          </div>
          <div
            class="btn-groups d-flex flex-wrap flex-md-nowrap justify-content-end mt-2 mt-md-0 gap-5"
          >
            <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="setFixerId(fixer.id, fixer.booking_id)">
              <i class="bi text-warning text-25px bi-x-circle"></i> Cancel
            </button>
            <button class="btn" @click="startFixer(fixer.id)">
              <i class="bi text-primary text-25px bi-play-circle"></i> Start
            </button>
          </div>
        </li>
      </ul>
    </div>

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
            <h5 class="modal-title" id="exampleModalLabel">Confirm Cancellation</h5>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to cancel this accepted booking?</p>
            <div class="d-flex align-items-center">
              <i class="bi bi-info-circle-fill text-info me-1"></i>
              <span class="text-muted">Cancellation is irreversible once confirmed.</span>
            </div>
          </div>
          <input type="text" v-model="fixer_id" style="display: none;">
          <input type="text" v-model="booking_id" style="display: none;">
          <div class="modal-footer">
            <button
              type="button"
              class="btn"
              data-bs-dismiss="modal"
              style="background: white; border: 1px solid orange"
            >
              <i class="bi bi-x-circle-fill text-danger me-1"></i> Cancel
            </button>
            <button
              type="button"
              class="btn btn-primary"
              style="background: orange"
              @click="cancelFixerAction"
              data-bs-dismiss="modal"
            >
              <i class="bi bi-check-circle-fill text-success me-1"></i> Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
const router = useRouter();

const accessToken = localStorage.getItem('access_token')
const acceptedFixers = ref([])
let fixerId = JSON.parse(localStorage.getItem('user')).id
let fixer_id = ref()
let booking_id = ref()

async function getAcceptedFixers() {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/fixer/accepted/${fixerId}`, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type':'application/json'
      }
    })
    acceptedFixers.value = response.data.accepted_bookings
    console.log(response.data.accepted_bookings);
  } catch (error) {
    console.error('Error fetching accepted fixers:', error)
  }
}

function setFixerId(id, bookingId) {
  fixer_id.value = id 
  booking_id.value = bookingId
}

async function cancelFixerAction() {
  try {
    const response = await axios.delete(`http://127.0.0.1:8000/api/fixer/cancel/${fixer_id.value}`, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      },
      data: {
        booking_id: booking_id.value
      }
    })
    console.log('Cancellation response:', response.data);
    await getAcceptedFixers(); 
  } catch (error) {
    console.error('Error cancelling fixer:', error)
  }
}
async function startFixer(fixerId) {
  try {
    // const response = await axios.post(`http://127.0.0.1:8000/api/fixer/start/${fixerId}`, {}, {
    //   headers: {
    //     Authorization: `Bearer ${accessToken}`,
    //     'Content-Type': 'application/json'
    //   }
    // });
    router.push('/map');
    console.log(fixerId);
    console.log('Start fixer response:', response.data);
    await getAcceptedFixers(); 
  } catch (error) {
    console.error('Error starting fixer:', error);
  }
}

onMounted(async () => {
  await getAcceptedFixers()
})
</script>

<style scoped>
</style>
