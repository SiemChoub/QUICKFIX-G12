<template>
    <h1>Service Car</h1>
  <div class="card-group">
    <div class="card">
      <img src="https://admin.autofix.ae/public/images/service/large/1693206242-Desc%20Image.jpg" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Car Service</h5>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        <button id="click">Click Now!</button>
      </div>
    </div>
    <div class="card">
      <img src="https://s7d1.scene7.com/is/image/bridgestone/checking-the-technical-condition-of-a-car-blog-images-2022-02-feb-fcac-web-bsro?scl=1" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Card Service</h5>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        <button id="click">Click Now!</button>
      </div>
    </div>
    <div class="card">
      <img src="https://olympicpetroleum.co.tz/wp-content/uploads/2020/04/unnamed-1.jpg" height="350vh" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">Car Service</h5>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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