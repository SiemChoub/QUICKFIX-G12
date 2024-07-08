<template>
  <router-view v-slot="{ Component }">
    <transition>
      <component :is="Component" />
    </transition>
  </router-view>
  <WebLayout>
    <div class="container-fluid p-0 mt-5">
      <!-- Main Carousel -->
      <div id="headerCarousel" class="carousel slide carousel-fade mx-auto" data-bs-ride="carousel" data-interval="3000">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="3"></button>
          <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="4"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 1" />
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 2" />
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 3" />
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 4" />
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 5" />
            </div>
          </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev custom-prev" type="button" data-bs-target="#headerCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next custom-next" type="button" data-bs-target="#headerCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <!-- Small Card Slider -->
      <div class="small-card-slider">
        <div class="small-card" v-for="(image, index) in images" :key="index" @click="goToSlide(index)">
          <img :src="image" alt="Small Slide" class="small-card-img">
        </div>
      </div>

      <!-- Additional Content -->
      <div class="content">
        <div class="row service">
          <WebService />
        </div>
        <div class="row">
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

<script setup>
import { ref } from 'vue';
import WebLayout from '@/Components/Layouts/WebLayout.vue';
import ProvinceMap from '@/Components/ProvinceMap.vue';
import AboutPage from '@/Components/AboutPage.vue';
import FooterPage from '@/Components/FooterPage.vue';
import WebService from '@/Components/WebServiceCustomer.vue';

const images = ref([
  '@/assets/images/image.png',
  '@/assets/images/image.png',
  '@/assets/images/image.png',
  '@/assets/images/image.png',
  '@/assets/images/image.png'
]);

const goToSlide = (index) => {
  const carousel = document.getElementById('headerCarousel');
  const carouselInstance = bootstrap.Carousel.getInstance(carousel);
  carouselInstance.to(index);
};
</script>

<style scoped>
.carousel.slide {
  width: 100%;
}

.carousel-item img {
  height: 75vh;
  object-fit: cover;
}

.carousel-caption {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, 15%);
  text-align: center;
  color: #fff;
  width: 100%;
  z-index: 5;
  background: rgba(11, 11, 11, 0.142); /* Adjust the rgba values to get the desired gray color with opacity */
}

.carousel-title {
  font-size: 3rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.carousel-subtitle {
  font-size: 1.5rem;
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
  z-index: 2; /* Ensure buttons are above blurred background */
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

.small-card-slider {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  z-index: 3;
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
  align-items: center;
  height: 75px; /* Match the height of the small-card-img */
}

.small-card {
  margin-left: 10px;
  cursor: pointer;
  transition: transform 0.3s ease-in-out;
}

.small-card:hover {
  transform: scale(1.1);
}

.small-card-img {
  width: 100px;
  height: 75px;
  object-fit: cover;
}
</style>
