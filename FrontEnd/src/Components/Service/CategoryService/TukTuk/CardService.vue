<template>
  <div id="main-motorcycles">
    <div class="card mb-3" style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4" id="moto-image">
          <img src="https://uaegamer.com/cdn/shop/products/10003_e655cb81-a073-4108-8274-078ddc498405.jpg?v=1710757068" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Cargo Tuk Tuks</h5>
            <p class="card-text">
              Tuk Tuk Factory is a well-known manufacturer based in Cambodia. They produce a range.
            </p>
            <button id="Booking-btn" @click="navigateToBooking"><router-link to="/booking">Booking Now!</router-link></button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://cdn.imweb.me/thumbnail/20230328/65710e0577472.png" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Electric Tuk Tuks</h5>
            <p class="card-text">
             electric tuk tuks as concerns over pollution and fuel costs increase. 
            </p>
            <button id="Booking-btn" @click="navigateToBooking"><router-link to="/booking">Booking Now!</router-link></button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://www.passapptaxis.com/backend/img/services/1554344227.png" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Remork-Moto</h5>
            <p class="card-text">
               It features a motorcycle or scooter with a larger trailer-like carriage attached to the rear.
            </p>
            <button id="Booking-btn" @click="navigateToBooking"><router-link to="/booking">Booking Now!</router-link></button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://www.passapptaxis.com/backend/img/services/1554345125.png" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">India Tuk Tuks</h5>
            <p class="card-text">
              Piaggio is an Italian company that manufactures the Ape series of vehicles, which include auto rickshaws.
            </p>
            <button id="Booking-btn" @click="navigateToBooking"><router-link to="/booking">Booking Now!</router-link></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style>
#main-motorcycles {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2%;
    margin-bottom: 4%;
    margin-top: 2%;
    margin: 2%;
}
 #Booking-btn {
    background-color: orange;
    border: none;
    width: 30%;
    height: 5vh;
    margin-top: 17%;
    margin-left: 68%;
    border-radius: 50vh;
 }
 #Booking-btn a {
  text-decoration: none;
  color: inherit;
  font-weight: bold;
}
</style>