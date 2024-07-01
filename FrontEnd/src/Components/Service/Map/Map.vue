<template>
  <div class="custom-container">
    <div class="custom-contan">
      <div class="custom-sibar">
        <i class="bi bi-chevron-left"></i>
        <router-link to="/service"><p>Back</p></router-link>
      </div>
      <div class="custom-sibarimg">
        <img src="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" alt="">
      </div>
      <div class="custom-infor">
        <div class="custom-info">
          <p>Name Repair</p>
          <p>Number Phone Repare</p>
          <p>Repair</p>
          <p>Customer</p>
          <p>Duration</p>
          <p>Distance</p>
        </div>
        <div class="custom-infoof">
          <p>Chandamunineat</p>
          <p>0978907237</p>
          <p>Kampong Cham</p>
          <p>Kampong Thom</p>
          <p>17 mn</p>
          <p>8 km</p>
        </div>
      </div>
    </div>
    <div ref="map" class="custom-map"></div>
  </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';

export default {
  mounted() {
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg';
    const map = new mapboxgl.Map({
      container: this.$refs.map,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [105, 12.5657], // Centered on Cambodia
      zoom: 7 // Adjust zoom level as needed
    });

    // Add a marker or customize the map further here
    let rmFoot = document.querySelector(".mapboxgl-ctrl-bottom-right .mapboxgl-ctrl-attrib");
    if (rmFoot) {
      rmFoot.innerHTML = '';
    }
  }
}
</script>

<style>
.custom-container {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  display: flex;
  height: 100vh;
  width: 100%;
}

.custom-contan {
  background: rgb(232, 233, 229);
  width: 40%;
  padding-top: 20px;
  padding-left: 25px;
}

.custom-map {
  width: 100%;
  height: 100%;
}

.custom-sibar {
  display: flex;
  gap: 20px;
}

.custom-infor {
  display: flex;
  gap: 13%;
  padding-top: 27px;
}

.custom-sibarimg {
  padding-top: 8px;
}

img {
  margin-top: 10px;
  width: 55vh;
  height: 40vh;
  border-radius: 10px;
  background: #000;
}
</style>