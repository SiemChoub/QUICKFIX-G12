<template>
    <h1 id="title-service">Our Service</h1>
  <div class="card-group">
    <div class="card">
      <img src="https://www.motorbiscuit.com/wp-content/uploads/2020/04/Motorcycle-maintenance.jpg?w=902&h=507&crop=1" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Motorcycles Repair</h5>
        <p class="card-text"><small class="text-muted">Motorcycle repair begins with evaluating the motor’s performance based on customer reports or observed issues.</small></p>
        <button id="click">Click Now!</button>
      </div>
    </div>
    <div class="card">
      <img src="https://s7d1.scene7.com/is/image/bridgestone/checking-the-technical-condition-of-a-car-blog-images-2022-02-feb-fcac-web-bsro?scl=1" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Car Repair</h5>
        <p class="card-text"><small class="text-muted"> Car repair begins with identifying issues through customer reports, diagnostic tools, and physical inspections.</small></p>
        <button id="click">Click Now!</button>
      </div>
    </div>
    <div class="card">  
      <img src="https://as1.ftcdn.net/v2/jpg/01/17/97/12/1000_F_117971249_DPPcWS8JHcHWUDWhlaZRSaFg8recmFNp.jpg" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">TukTuk​ Repair</h5>
        <p class="card-text"><small class="text-muted">TukTuk repair is a specialized field that demands expertise in electrical and mechanical engineering. </small></p>
        <button id="click">Click Now!</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style>
h1 {
    margin-top: 2%;
    margin-left: 1%;
}
#title-service{
  margin-left: 4%;
}
.card-group {
    margin-top: 1%;
    margin-bottom: 2%;
}
.card {
    margin-left: 4%;
    margin-right: 4%;
}
image {
    width: 50%;
    height: 10%;
    object-fit: cover;
    object-position: center;
}
#click {
    background-color: orange;
    border: none;
    width: 40%;
    height: 5vh;
}
</style>