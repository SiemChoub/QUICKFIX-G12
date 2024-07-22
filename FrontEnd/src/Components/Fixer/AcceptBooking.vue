<template>
  <div class="container">
    <!-- Section for Accepted Fixers -->
    <div class="mb-5">
      <h1 class="text-center mb-4">YOUR ACCEPTED</h1>
      <div class="row row-cols-1 row-cols-md-2 g-3">
        <div v-for="fixer in acceptedFixers" :key="fixer.id" class="col">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-between">
              <!-- Left Section (Profile Image and Information) -->
              <div class="d-flex align-items-center mb-3">
                <img
                  :src="fixer.profile_image_url ? fixer.profile_image_url : '/src/assets/img/default-profile.jpg'"
                  class="rounded-circle me-3"
                  style="width: 50px; height: 50px;"
                  alt="Profile"
                />
                <div>
                  <h5 class="card-title mb-0">{{ fixer.booking_type_id }}</h5>
                  <p class="card-text mb-0">Email: {{ fixer.email }}</p>
                </div>
              </div>
              <!-- Action Buttons -->
              <div class="mt-3">
                <button class="btn btn-cancel" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="setFixerId(fixer.id, fixer.booking_id)">
                  <i class="bi bi-x-circle text-warning me-1"></i> Cancel
                </button>
                <button class="btn btn-primary ms-2" @click="startFixer(fixer.fixing_progress_id, fixer.booking_id)">
                  <i class="bi bi-play-circle text-primary me-1"></i> Start
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Cancellation Confirmation -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Cancellation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to cancel this accepted booking?</p>
            <div class="d-flex align-items-center">
              <i class="bi bi-info-circle-fill text-info me-1"></i>
              <span class="text-muted">Cancellation is irreversible once confirmed.</span>
            </div>
          </div>
          <!-- Hidden Inputs for Fixer and Booking IDs -->
          <input type="hidden" v-model="fixer_id">
          <input type="hidden" v-model="booking_id">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle-fill text-danger me-1"></i> Cancel
            </button>
            <button type="button" class="btn btn-primary" @click="cancelFixerAction">
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

const router = useRouter()
const accessToken = localStorage.getItem('access_token')
const acceptedFixers = ref([])
let fixerId = JSON.parse(localStorage.getItem('user')).id
let fixer_id = ref('')
let booking_id = ref('')
let fixing_progress_id = ref('')

async function getAcceptedFixers() {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/fixer/accepted/${fixerId}`, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    })
    acceptedFixers.value = response.data.accepted_bookings
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
    console.log('Cancellation response:', response.data)
    await getAcceptedFixers()
  } catch (error) {
    console.error('Error cancelling fixer:', error)
  }
}

async function startFixer(fixing_progress_id, booking_progres_id) {
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/fixer/start/${fixing_progress_id}`, {
      booking_id: booking_progres_id,
      fixer_id: fixerId
    }, {
      headers: {
        Authorization: `Bearer ${accessToken}`,
        'Content-Type': 'application/json'
      }
    })

    console.log('Starting fixer with ID:', response.data)
    localStorage.setItem('latitude', response.data.latitude)
    localStorage.setItem('longitude', response.data.longitude)
    router.push('/map')
  } catch (error) {
    console.error('Error starting fixer:', error)
  }
}

onMounted(async () => {
  await getAcceptedFixers()
})
</script>

<style scoped>
.card {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  cursor: pointer;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
  padding: 1.25rem;
}

.btn-cancel {
  background-color: white;
  border: 1px solid orange;
  color: orange;
}

.btn-cancel:hover {
  background-color: orange;
  color: white;
}

.btn-primary {
  background-color: orange;
}

.btn-primary:hover {
  background-color: #ff8c00; /* Darker shade of orange on hover */
}

.modal-content {
  background-color: #fff;
  border-radius: 10px;
}

.modal-body {
  padding: 20px;
}

.modal-footer {
  justify-content: space-between;
}

.modal-title {
  font-weight: bold;
}

.text-muted {
  font-size: 0.875rem;
}

.rounded-circle {
  border-radius: 50%;
}
</style>
