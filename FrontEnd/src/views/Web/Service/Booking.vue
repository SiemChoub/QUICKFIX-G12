<template>
  <div id="app">
    <h1 class="text-center mb-4">Send us for Your Booking</h1>
    <p class="text-center mb-4">Please input about your problem and click send message for booking</p>

    <div class="booking-form container">
      <div class="form-group d-flex">
        <div class="col" id="test">
          <label for="phone">*Phone Number:</label>
          <input type="tel" id="phone" v-model="phone" class="form-control" required aria-describedby="phoneError" />
          <div v-if="phoneError" class="error text-danger" id="phoneError">{{ phoneError }}</div>
        </div>
        <div class="col">
          <label for="location">*Location:</label>
          <div class="input-group">
            <input type="text" id="location" v-model="location" class="form-control" required aria-describedby="locationError" />
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="bi bi-geo-alt-fill"></i>
              </span>
            </div>
          </div>
          <div v-if="locationError" class="error text-danger" id="locationError">{{ locationError }}</div>
        </div>
      </div>

      <div class="mt-4">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d31271.600019170564!2d104.88852885!3d11.555442049999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2skh!4v1719194243056!5m2!1sen!2skh" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div class="form-group mt-4">
        <label for="description">*How can we help?</label>
        <textarea id="description" v-model="description" class="form-control" required aria-describedby="descriptionError"></textarea>
        <div v-if="descriptionError" class="error text-danger" id="descriptionError">{{ descriptionError }}</div>
      </div>

      <div class="mb-3">
        <label for="formFileMultiple" class="form-label">*You can drop images your problem here !</label>
        <input class="form-control" type="file" id="formFileMultiple" multiple>
      </div>

      <div class="d-flex justify-content-end">
        <button @click="submitBooking" :disabled="hasErrors" class="btn btn-warning">Send Message</button>
      </div>
    </div>

    <div v-if="showConfirmation" class="confirmation container mt-5">
      <h2 class="mb-4">Booking Confirmed</h2>
      <p>Phone Number: <span class="font-weight-bold">{{ phone }}</span></p>
      <p>Location: <span class="font-weight-bold">{{ location }}</span></p>
      <p>Description: <span class="font-weight-bold">{{ description }}</span></p>
      <img v-if="imageUrl" :src="imageUrl" :alt="imageAltText" class="img-fluid mt-3" />
    </div>
  </div>
</template>
<style>
#test{
 margin-right: 5%;
}
</style>