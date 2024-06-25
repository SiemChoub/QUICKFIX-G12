
<template>
   <transition name="fade">
    <router-view />
  </transition>
  <WebLayout>
    <div class="container-fluid p-0">
      <div
        id="carouselExampleIndicators"
        class="carousel slide carousel-fade mx-auto"
        data-bs-ride="carousel"
      >
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>  
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="3"
            aria-label="Slide 4"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide-to="4"
            aria-label="Slide 5"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 1" />
          </div>
          <div class="carousel-item">
            <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 2" />
          </div>
          <div class="carousel-item">
            <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 3" />
          </div>
          <div class="carousel-item">
            <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 4" />
          </div>
          <div class="carousel-item">
            <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 5" />
          </div>
        </div>
        <button
          class="carousel-control-prev custom-prev"
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next custom-next"
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <header class="overlay text-center d-flex flex-column align-items-center mx-auto">
        <h1 class="main-title mb-3">THE BEST REPAIR AND MANTERNENCE SERVICES</h1>
        <h1 class="sub-title">QUICKFIX</h1>
        <button class="btn btn-primary button mt-3">Use Now!</button>
      </header>
      <div class="content mt-5">
        <div class="row service">
          <ServiceLayout />
        </div>
        <div class="row mt-5 mapProvince">
          <ProvinceMap />
        </div>
        <div class="row mt-5 mb-5">
          <AboutPage />
        </div>
        <div class="row mt-5 mapProvince">
          <FooterPage />
        </div>
      </div>
    </div>
  </WebLayout>
</template>
<script setup lang="ts">
import { onMounted, onBeforeUnmount } from 'vue'
import WebLayout from '@/Components/Layouts/WebLayout.vue'
import ServiceLayout from '@/Components/WebServiceCustomer.vue'
import ProvinceMap from '@/Components/ProvinceMap.vue'
import AboutPage from '@/Components/AboutPage.vue'
import FooterPage from '@/Components/FooterPage.vue'
import { useRouter } from 'vue-router'
const router = useRouter()

</script>
<style scoped>
.carousel.slide {
  width: 90%;
}

.carousel-item img {
  height: 80vh; /* Adjust the height of the carousel */
  object-fit: cover;
}

.overlay {
  position: absolute;
  bottom: 70px;
  left: 50%;
  transform: translateX(-50%);
  width: 90%;
  height: 60%;
  z-index: 3;
  background: rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  pointer-events: none;
}
.button.btn-primary {
  background-color: orange;
  border-color: orange;
  cursor: pointer;
  padding: 15px 30px;
  transition: background-color 0.3s, border-color 0.3s;
  font-size: 30px;
}

.button.btn-primary:hover {
  background-color: darkorange;
  border-color: darkorange;
}

.main-title {
  font-size: 3rem;
  font-weight: bold;
  color: white;
  padding: 20px 0;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  pointer-events: all; /* Ensure text remains clickable */
}

.sub-title {
  color: orange;
  font-weight: bolder;
  font-size: 4rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  pointer-events: all; /* Ensure text remains clickable */
}

.custom-prev,
.custom-next {
  background-color: orange;
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 4; /* Ensure buttons are above overlay */
}

.custom-prev {
  left: 10px;
}

.custom-next {
  right: 10px;
}

.custom-prev:hover,
.custom-next:hover {
  background-color: darkorange;
}
 
.custom-prev-icon,
.custom-next-icon {
  filter: invert(1);
}

.content { 
  padding-top: 20px;
}
</style>


