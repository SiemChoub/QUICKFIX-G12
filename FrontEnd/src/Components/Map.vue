<template>
  <div class="custom-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <i class="bi bi-chevron-left"></i>
        <router-link to="/" class="back">Back</router-link>
      </div>
      <div class="sidebar-image">
        <h2>Information</h2>
      </div>
      <div class="info-container">
        <div class="info">
          <p>Name Repair</p>
          <p>{{phone}}</p>
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
          <p>{{ duration }} mn</p>
          <p>{{ distance }} km</p>
        </div>
      </div>
      <div class="icon">
        <div class="right">
          <i class="bi bi-telephone-fill"></i>
        </div>
        <div class="center">
          <router-link to="/messanger">
            <i class="bi bi-chat-dots"></i>
          </router-link>
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
  name: 'DeliveryMap',
  data() {
    return {
      map: null,
      destination: [104.91, 11.55],
      distance: 0,
      duration: 0,
      userLocation: null,
      userMarker: null,
      deliveryMarker: null,
      route: null,
      locationWatchId: null,
      phone:null
    }
  },
  mounted() {
    mapboxgl.accessToken =
      'pk.eyJ1Ijoic2llbWNob3ViMTExMSIsImEiOiJjbHg3bDRrdGowaW1kMmxweG50MHdpazMzIn0.cAYH_6kwxhwH43FM46qmOg'

    this.map = new mapboxgl.Map({
      container: this.$refs.map,
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [105, 12.5657],
      zoom: 17
    })

    this.map.on('load', () => {
      this.getCurrentLocation()
    })
    this.phone = JSON.parse(localStorage.getItem('user')).phone
  },
  methods: {
    getCurrentLocation() {
      if (navigator.geolocation) {
        const options = {
          enableHighAccuracy: true,
          maximumAge: 0
        };

        this.locationWatchId = navigator.geolocation.watchPosition(
          (position) => {
            const { latitude, longitude } = position.coords;
            this.userLocation = [longitude, latitude];
            this.updateMap();
          },
          (error) => {
            console.error('Error getting current location:', error);
            let errorMessage = 'Please enable location services for accurate map positioning.';
            
            if (error.code === 1) {
              errorMessage = 'Location access denied. Please enable location services.';
            } else if (error.code === 2) {
              errorMessage = 'Location unavailable. Please try again later.';
            }
            
            alert(errorMessage);
          },
          options
        );
      } else {
        alert('Geolocation is not supported by this browser.');
      }
    },
    updateMap() {
      this.map.setCenter(this.userLocation)
      this.map.setZoom(13)

      if (!this.userMarker) {
        this.userMarker = new mapboxgl.Marker({ color: '#FF5733' })
          .setLngLat(this.userLocation)
          .addTo(this.map)
      } else {
        this.userMarker.setLngLat(this.userLocation)
      }

      if (!this.deliveryMarker) {
        this.deliveryMarker = new mapboxgl.Marker({ color: '#3887be' })
          .setLngLat(this.destination)
          .addTo(this.map)
      }

      this.calculateRoute()
    },
    calculateRoute() {
      if (!this.userLocation) return

      const coordinates = [this.userLocation, this.destination]
      const apiUrl = `https://api.mapbox.com/directions/v5/mapbox/driving/${coordinates[0][0]},${coordinates[0][1]};${coordinates[1][0]},${coordinates[1][1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`

      fetch(apiUrl)
        .then((response) => response.json())
        .then((data) => {
          const route = data.routes[0]
          this.route = route
          this.distance = (route.distance / 1000).toFixed(1)
          this.duration = Math.floor(route.duration / 60)

          if (this.map.getLayer('route')) {
            this.map.removeLayer('route')
            this.map.removeSource('route')
          }

          this.map.addLayer({
            id: 'route',
            type: 'line',
            source: {
              type: 'geojson',
              data: {
                type: 'Feature',
                properties: {},
                geometry: {
                  type: 'LineString',
                  coordinates: route.geometry.coordinates
                }
              }
            },
            layout: {
              'line-join': 'round',
              'line-cap': 'round'
            },
            paint: {
              'line-color': '#3887be',
              'line-width': 8,
              'line-opacity': 0.8
            }
          })
        })
        .catch((error) => console.error('Error calculating the route:', error))
    }
  },
  beforeDestroy() {
    if (navigator.geolocation && this.locationWatchId) {
      navigator.geolocation.clearWatch(this.locationWatchId)
    }
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

.sidebar {
  width: 30%;
  background: #f7f7f7;
  padding: 20px;
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

.icon {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border-radius: 10px;
  background-color: #fff;
  width: 100%;
  margin-top: auto;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.icon > div {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  background-color: #f57c00;
  border-radius: 50%;
  transition: background-color 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}

.icon > div:hover {
  background-color: #ff9800;
  transform: scale(1.1);
}

.icon .bi {
  font-size: 24px;
  color: #ffffff;
  transition: color 0.3s ease;
}

.icon .center {
  background-color: #4caf50;
}

.icon .center:hover {
  animation: bounce 0.5s ease alternate infinite;
}

@keyframes bounce {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-5px);
  }
}

.map-container {
  width: 70%;
  height: 100%;
}
</style>
