<template>
  <div id="main-motorcycles">
    <div class="card mb-3" style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4" id="moto-image">
          <img src="https://yt3.googleusercontent.com/trvTsFBmg36XQ4y55jb2eqewRBwAZI4a9AdC6KRoml1OO0nq2Vt6oZn6HukLBIq5yElIoAWDAg=s900-c-k-c0x00ffffff-no-rj" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">SONY</h5>
            <p class="card-text">
             Known for consumer electronics such as TVs, audio equipment, cameras, gaming consoles.
            </p>
            <button id="Booking-btn">Booking Now!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRh1mR3HY57a4yDM4_JA9Hh_AYtaJpVUXrMPg&s" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">PANASONIC</h5>
            <p class="card-text">
             Dell is a variety of laptops (HP Spectre, HP Envy, HP Pavilion), desktops (HP Elite, HP Slimline).
            </p>
            <button id="Booking-btn">Booking Now!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://yt3.googleusercontent.com/-zWEw2JNHe3t4t-IDRSyGXoalLybQe_nnMTWUsLPT3pyaQ06SUdEBinX2iFrXVz12v5t1hANSg=s900-c-k-c0x00ffffff-no-rj" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">LG</h5>
            <p class="card-text">
              Known for TVs, home appliances (refrigerators, washing machines), smartphones, and display panels.
            </p>
            <button id="Booking-btn">Booking Now!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTv3KgnwqxfahE0A9lWBoELneDQxUntX280WQ&s" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">SAMSUNG</h5>
            <p class="card-text">
               Offers a diverse range of products including smartphones, TVs, home appliances, semiconductors, and display panels.
            </p>
            <button id="Booking-btn">Booking Now!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://cdn.dribbble.com/userupload/10821072/file/original-2ab994ea54b2567307b13615bbb09c12.jpg?resize=2250x2251" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">CANON</h5>
            <p class="card-text">
              Specializes in imaging and optical products including cameras, camcorders, printers, and medical equipment.
            </p>
            <button id="Booking-btn">Booking Now!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3"  style="max-width: 840px" id="moto-brand">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReN6qrEAeXAHKoKG4vSyx3qWfIwfq7rKcCsA&s" width="100%" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">HONEYWELL</h5>
            <p class="card-text">
               Honeywell aerospace systems, building technologies (HVAC systems, security solutions), performance materials.
            </p>
            <button id="Booking-btn">Booking Now!</button>
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

/* #moto-image img {
    width: 100%;
    height: 40vh;
} */
 #Booking-btn {
    background-color: orange;
    border: none;
    width: 30%;
    height: 5vh;
    margin-top: 17%;
    margin-left: 68%;
    font-weight: bold;
    border-radius: 50vh;
 }
</style>