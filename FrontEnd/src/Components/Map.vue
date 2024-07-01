<template>
  <div class="custom-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <i class="bi bi-chevron-left"></i>
        <router-link to="/" class="back"> Back</router-link>
      </div>
      <div class="sidebar-image">
        <h2>Information</h2>
        <img src="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" alt="Repair Information">
      </div>
      <div class="info-container">
        <div class="info">
          <p>Name Repair</p>
          <p>Number Phone Repair</p>
          <p>Repair</p>
          <p>Customer</p>
          <p>Duration</p>
          <p>Distance</p>
        </div>
        <div class="info-details">
          <p>Chandamunineat</p>
          <p>0978907237</p>
          <p>Kampong Cham</p>
          <p>Kampong Thom</p>
          <p>17 mn</p>
          <p>8 km</p>
        </div>
      </div>
    </div>
    <div ref="map" class="map-container"></div>
  </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';

export default {
  name: 'MapView',
  mounted() {
    mapboxgl.accessToken = 'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg';
    const map = new mapboxgl.Map({
      container: this.$refs.map,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [105, 12.5657], // Centered on Cambodia
      zoom: 7 // Adjust zoom level as needed
    });

    // Remove mapbox attribution
    map.on('load', () => {
      let rmFoot = document.querySelector(".mapboxgl-ctrl-bottom-right .mapboxgl-ctrl-attrib");
      if (rmFoot) {
        rmFoot.innerHTML = '';
      }
    });
  }
};
</script>

<style scoped>
.custom-container {
  display: flex;
  height: 100vh;
  width: 100%;
  overflow: hidden;
}

.sidebar {
  width: 35%;
  background: #e8e9e5;
  padding: 25px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.sidebar-header {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #fff;
  margin-bottom: 20px;
  border: 2px solid orange;
  border-radius: 10px;
  padding: 5px;
  background: orange;
  transition: background 0.3s, border-color 0.3s;
  cursor: pointer;
  width: 100px;
}

.sidebar-header:hover {
  background: #ff9f1c;
  border-color: #ff9f1c;
}

.sidebar-header i {
  font-size: 1.5rem;
}


.back{
  color: white;
  text-decoration: none;
}

.sidebar-image {
  margin-bottom: 20px;
}

.sidebar-image img {
  width: 100%;
  border-radius: 10px;
  object-fit: cover;
}

.info-container {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.info, .info-details {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.info p, .info-details p {
  margin: 0;
}

.map-container {
  width: 65%;
  height: 100%;
}
</style>
