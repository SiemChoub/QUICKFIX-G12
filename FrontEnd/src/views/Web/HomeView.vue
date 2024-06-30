<template>
  <transition name="fade">
    <router-view />
  </transition>
  <WebLayout>
    <div class="container-fluid p-0">
      <!-- Carousel -->
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
          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 1" />
            </div>
            <div class="carousel-caption d-none d-md-block">
              <h2 class="carousel-title">THE BEST REPAIR AND MAINTENANCE SERVICES</h2>
              <p class="carousel-subtitle">Providing top-notch solutions for your needs.</p>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 2" />
            </div>
            <div class="carousel-caption d-none d-md-block">
              <h2 class="carousel-title">FAST AND RELIABLE FIXES</h2>
              <p class="carousel-subtitle">Quick solutions that you can trust.</p>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 3" />
            </div>
            <div class="carousel-caption d-none d-md-block">
              <h2 class="carousel-title">EXPERT SERVICE PROVIDERS</h2>
              <p class="carousel-subtitle">Skilled professionals at your service.</p>
            </div>
          </div>

          <!-- Slide 4 -->
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 4" />
            </div>
            <div class="carousel-caption d-none d-md-block">
              <h2 class="carousel-title">CUSTOMER SATISFACTION GUARANTEED</h2>
              <p class="carousel-subtitle">Your happiness is our priority.</p>
            </div>
          </div>

          <!-- Slide 5 -->
          <div class="carousel-item">
            <div class="carousel-blur-background">
              <img src="@/assets/images/image.png" class="d-block w-100" alt="Slide 5" />
            </div>
            <div class="carousel-caption d-none d-md-block">
              <h2 class="carousel-title">24/7 SUPPORT AVAILABLE</h2>
              <p class="carousel-subtitle">Always here when you need us.</p>
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

      <!-- Additional Content -->
      <div class="content">
          <WebService />
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
import { onMounted, onBeforeUnmount } from 'vue';
import WebLayout from '@/Components/Layouts/WebLayout.vue';
import ProvinceMap from '@/Components/ProvinceMap.vue';
import AboutPage from '@/Components/AboutPage.vue';
import FooterPage from '@/Components/FooterPage.vue';
import WebService from '@/Components/WebServiceCustomer.vue';
import { useRouter } from 'vue-router';

const router = useRouter();
</script>

<style scoped>
.carousel.slide {
  width: 100%;
}

.carousel-item img {
  height: 90vh; /* Adjust the height of the carousel */
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
  z-index: 1; 
  background: rgba(11, 11, 11, 0.142); /* Adjust the rgba values to get the desired gray color with opacity */
  padding: 10px; /* Add padding to make text more readable */
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

.content {
  padding-top: 20px;
}
</style>
