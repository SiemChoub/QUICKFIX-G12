<template>
  <div class="container">
    <div id="btn-back">
      <button @click="goBack" class="btn btn-secondary back-button">Back</button>
    </div>
    <div class="overlay">
      <div class="card shadow">
        <div class="card-body">
          <h2 class="card-title text-center mb-4 title-highlight">Fixer Register</h2>
          <form @submit.prevent="submitForm" novalidate>
           <div id="profile-fixer" class="text-center mb-4">
              <div class="profile-fixxer">
                <label for="profileInput" class="profile-upload">
                  <input
                    type="file"
                    id="profileInput"
                    class="visually-hidden"
                    @change="handleFileUpload"
                    accept="image/*"
                  />
                  <div id="profile-input" class="position-relative">
                    <i class="bi bi-camera"></i>
                    <img
                      src="https://www.shutterstock.com/image-vector/vector-flat-illustration-grayscale-avatar-600nw-2264922221.jpg"
                      alt="Profile"
                      class="profile-placeholder"
                    />
                  </div>
                </label>
                <img
                  v-if="profilePicture"
                  :src="profilePicture"
                  class="profile-image"
                  alt="Profile Preview"
                />
              </div>
              <div class="name-fixer">
                <p>Fixer Name</p>
              </div>
            </div>

            <div class="form-group">
              <div class="mb-3">
                <label for="nameInput" class="form-label">Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="formData.name"
                    :class="{ 'is-invalid': submitted && !formData.name }"
                    placeholder="Enter your name"
                    required
                    autocomplete="name"
                  />
                </div>
                <div v-if="submitted && !formData.name" class="invalid-feedback">
                  Please enter your name.
                </div>
              </div>
              <div class="mb-3">
                <label for="emailInput" class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input
                    type="email"
                    id="emailInput"
                    class="form-control"
                    v-model="formData.email"
                    :class="{ 'is-invalid': submitted && !validEmail(formData.email) }"
                    placeholder="Please enter your email"
                    required
                    autocomplete="email"
                  />
                </div>
                <div v-if="submitted && !validEmail(formData.email)" class="invalid-feedback">
                  Please enter a valid email.
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-key"></i></span>
                  <input
                    type="password"
                    id="passwordInput"
                    class="form-control"
                    v-model="formData.password"
                    :class="{ 'is-invalid': submitted && !formData.password }"
                    placeholder="Please enter your password"
                    required
                    autocomplete="new-password"
                  />
                </div>
                <div v-if="submitted && !formData.password" class="invalid-feedback">
                  Please enter your password.
                </div>
              </div>

              <div class="mb-3">
                <label for="locationInput" class="form-label">Location</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-geo"></i></span>
                  <input
                    type="text"
                    id="locationInput"
                    class="form-control"
                    v-model="formData.location"
                    :class="{ 'is-invalid': submitted && !formData.location }"
                    placeholder="Enter your location"
                    required
                    autocomplete="location"
                  />
                </div>
                <div v-if="submitted && !formData.location" class="invalid-feedback">
                  Please enter your location.
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="mb-3">
                <label for="careerSelect" class="form-label">Career</label>
                <select
                  class="form-select"
                  id="careerSelect"
                  v-model="formData.career"
                  :class="{ 'is-invalid': submitted && !formData.career }"
                  required
                >
                  <option value="" disabled>Choose...</option>
                  <option value="Mechanic">Mechanic</option>
                  <option value="Electrician">Electrician</option>
                  <option value="Plumber">Plumber</option>
                </select>
                <div v-if="submitted && !formData.career" class="invalid-feedback">
                  Please choose your career.
                </div>
              </div>

              <!-- <div class="mb-3">
                <label for="profileInput" class="form-label">Profile Picture</label>
                <input
                  type="file"
                  class="form-control"
                  id="profileInput"
                  @change="handleFileUpload"
                  :class="{ 'is-invalid': submitted && !profilePicture }"
                  required
                />
                <div v-if="submitted && !profilePicture" class="invalid-feedback">
                  Please select your profile picture.
                </div>
              </div> -->
            </div>

            <button type="submit" class="btn btn-primary w-100">
              {{ submitted ? 'Submitting...' : 'Submit' }}
            </button>
          </form>

          <transition name="fade">
            <div v-if="submitted && validForm" class="alert alert-success mt-4" role="alert">
              Thank you for your registration! We will get back to you soon.
            </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'FixerRegisterForm',
  setup() {
    const formData = ref({
      name: '',
      email: '',
      password: '',
      location: '',
      career: ''
    })

    const profilePicture = ref(null)
    const submitted = ref(false)
    const validForm = ref(false)

    const validEmail = (email) => {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    }

    const validateForm = () => {
      validForm.value =
        formData.value.name &&
        validEmail(formData.value.email) &&
        formData.value.password &&
        formData.value.location &&
        formData.value.career &&
        profilePicture.value
    }

    const handleFileUpload = (event) => {
      profilePicture.value = event.target.files[0]
    }

    const submitForm = () => {
      submitted.value = true
      validateForm()
      if (validForm.value) {
        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
          console.log('Form data:', formData.value, 'Profile picture:', profilePicture.value)
          submitted.value = false // Reset submitted state
        }, 1000)
      }
    }

    return {
      formData,
      submitted,
      validEmail,
      validForm,
      handleFileUpload,
      submitForm
    }
  }
}
</script>

<style scoped>
#profile-fixer {
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}
.position-relative i {
  font-size: 180%;
  position: absolute;
  top: 70%;
  left: 22%;
  transform: translate(-50%, -50%);
  opacity: 0.7;
}


.name-fixer {
  font-size: 1.5rem;
}

.profile-fixxer {
  position: relative;
  display: flex;
  justify-content: center;
  width: 20%;
  border-radius: 50%;
}

#profile-input {
  position: relative;
  width: 100%;
  cursor: pointer;
}

.profile-placeholder {
  width: 100%;
  border-radius: 50%;
}

.profile-image {
  width: 160%;
  border-radius: 50%;
}



#profile-fixer {
  /* display: flex; */
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.profile-icon {
  margin-top: -4%;
  font-size: 4rem;
  color: #ff8c00;
}

.name-fixer {
  font-size: 1.5rem;
}
.profile-fixxer {
  display: flex;
  justify-content: center;
  margin-left: 40%;
  width: 20%;
  /* border: 1.5px solid rgba(0, 0, 0, 0.567); */
  border-radius: 50vh;
  margin-top: -2%;
}

.title-highlight {
  display: inline-block;
  margin-left: 30%;
  padding: 0.25rem 0.5rem;
  background-color: #ff8c00;
  border-radius: 0.25rem;
  color: white;
  transition: background-color 0.3s, color 0.3s;
}

.title-highlight:hover {
  background-color: #e67e00;
  color: #fff;
}

.input-group-text {
  background-color: #ff8c00;
  border: none;
  color: white;
  transition: background-color 0.3s, color 0.3s;
}

.input-group-text:hover {
  background-color: #e67e00;
  color: #fff;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: url('https://roadguardinterlock.com/wp-content/uploads/2019/09/car-repair-with-an-interlock-device.jpg')
    no-repeat center center;
  background-size: cover;
}

.overlay {
  padding: 2rem;
  border-radius: 10px;
  width: 100%;
  max-width: 700px;
  background-color: rgba(255, 255, 255, 0.85);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.card {
  border: none;
  border-radius: 10px;
}

.card-body {
  padding: 2rem;
}

.btn-primary {
  background-color: #ff8c00;
  border-color: #ff8c00;
  transition: background-color 0.3s, border-color 0.3s;
}

.btn-primary:hover {
  background-color: #e67e00;
  border-color: #e67e00;
}

.btn-primary:focus {
  box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.5);
}

.invalid-feedback {
  color: #dc3545;
  display: none; /* initially hide feedback */
}

.is-invalid ~ .invalid-feedback {
  display: block; /* show when input is invalid */
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.form-group {
  display: flex;
  gap: 16%;
}

.form-group .mb-3 {
  flex: 1;
}

.form-group .form-label {
  width: 100%;
}

input,
select {
  width: 100%;
}

#btn-back {
  width: 50%;
  margin-bottom: 20%;
  margin-right: -25%;
  margin-left: -24%;
}

.btn-secondary {
  background-color: #ff8c00;
  width: 10%;
  border: none;
  margin-bottom: 1rem;
  margin-bottom: 42%;
  margin-right: 44%;
}

.btn-secondary:hover {
  background-color: #6c757d;
}
</style>
