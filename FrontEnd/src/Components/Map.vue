<template>
  <div class="custom-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <i class="bi bi-chevron-left"></i>
        <router-link to="/" class="back"> Back</router-link>
      </div>
      <div class="sidebar-image">
        <h2>Information</h2>
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
      <div class="icon">
        <div class="right">
          <i class="bi bi-telephone-fill"></i>
        </div>
        <div class="center">
          <i class="bi bi-chat-dots"></i>
        </div>
        <div class="left">
          <i class="bi bi-x-circle-fill"></i>
        </div>
      </div>
    </div>
    <div ref="map" class="map-container"></div>
  </div>
</template>

<script>
import mapboxgl from 'mapbox-gl'

export default {
  name: 'MapView',
  mounted() {
    mapboxgl.accessToken =
      'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg'
    const map = new mapboxgl.Map({
      container: this.$refs.map,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [105, 12.5657], // Centered on Cambodia
      zoom: 7 // Adjust zoom level as needed
    })

    // Remove mapbox attribution
    map.on('load', () => {
      let rmFoot = document.querySelector('.mapboxgl-ctrl-bottom-right .mapboxgl-ctrl-attrib')
      if (rmFoot) {
        rmFoot.innerHTML = ''
      }
    })
  }
}
</script>

<style scoped>
.custom-container {
  display: flex;
  height: 100vh;
  width: 100%;
  overflow: hidden;
}
.icon {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border-radius: 10px;
  background-color: #f9f9f9; /* Light background */
  width: 100%;
  max-width: 300px; /* Adjust max-width as per your design */
  margin: auto;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Adds a subtle shadow */
}

.icon > div {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px; /* Larger width for cute design */
  height: 50px; /* Larger height for cute design */
  background-color: #f57c00; /* Orange background color */
  border-radius: 50%; /* Makes the icons circular */
  transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for background color and transform */
  cursor: pointer; /* Changes cursor to pointer on hover */
}

.icon > div:hover {
  background-color: #ff9800; /* Lighter orange on hover */
  transform: scale(1.1); /* Scale effect on hover */
}



.icon .right p:hover {
  color: #007bff; /* Blue hover color for text */
}

.icon .bi {
  font-size: 24px; /* Larger icon size for cute design */
  color: #ffffff; /* White icon color */
  transition: color 0.3s ease; /* Smooth transition for icon color */
}

.icon .left:hover .bi, .icon .center:hover .bi {
  color: #ffffff; /* White icon color on hover */
}

.icon .center {
  background-color: #4caf50; /* Green background color for center icon */
}

.icon .center:hover {
  animation: bounce 0.5s ease alternate infinite; /* Bounce animation on hover */
}

@keyframes bounce {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-5px);
  }
}

.sidebar {
  width: 30%;
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

.back {
  color: white;
  text-decoration: none;
}

.sidebar-image {
  margin-bottom: 20px;
}

.info-container {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.info,
.info-details {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.info p,
.info-details p {
  margin: 0;
}

.map-container {
  width: 70%;
  height: 100%;
}
</style>
