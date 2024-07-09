<template>
  <router-view v-slot="{ Component }">
  <transition>
    <component :is="Component" />
  </transition>
</router-view>
  <WebLayout>
    <div class="container-fluid p-0">
      <div class="container-slider">
        <div class="slide" ref="slide">
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/qCkd9jS/img1.jpg)"
          >
            <div class="content">
              <div class="name">Switzerland</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/jrRb11q/img2.jpg)"
          >
            <div class="content">
              <div class="name">Finland</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/NSwVv8D/img3.jpg)"
          >
            <div class="content">
              <div class="name">Iceland</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/Bq4Q0M8/img4.jpg)"
          >
            <div class="content">
              <div class="name">Australia</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/jTQfmTq/img5.jpg)"
          >
            <div class="content">
              <div class="name">Netherland</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
          <div
            class="item"
            style="background-image: url(https://i.ibb.co/RNkk6L0/img6.jpg)"
          >
            <div class="content">
              <div class="name">Ireland</div>
              <div class="des">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!
              </div>
              <button>See More</button>
            </div>
          </div>
        </div>

        <div class="button">
          <button class="prev" ref="prevButton"><i class="bi bi-arrow-left"></i></button>
          <button class="next" ref="nextButton"><i class="bi bi-arrow-right"></i></button>
        </div>
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
import { ref, onMounted, onBeforeUnmount } from 'vue';
import WebLayout from '@/Components/Layouts/WebLayout.vue';
import ProvinceMap from '@/Components/ProvinceMap.vue';
import AboutPage from '@/Components/AboutPage.vue';
import FooterPage from '@/Components/FooterPage.vue';
import WebService from '@/Components/WebServiceCustomer.vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const slide = ref(null);
const nextButton = ref(null);
const prevButton = ref(null);

const moveSlide = (direction: string) => {
  const items = slide.value?.querySelectorAll('.item');
  if (items && items.length > 0) {
    if (direction === 'next') {
      slide.value?.appendChild(items[0]);
    } else if (direction === 'prev') {
      slide.value?.prepend(items[items.length - 1]);
    }
  }
};

onMounted(() => {
  if (nextButton.value && prevButton.value) {
    nextButton.value.addEventListener('click', () => moveSlide('next'));
    prevButton.value.addEventListener('click', () => moveSlide('prev'));
  }
});

onBeforeUnmount(() => {
  if (nextButton.value && prevButton.value) {
    nextButton.value.removeEventListener('click', () => moveSlide('next'));
    prevButton.value.removeEventListener('click', () => moveSlide('prev'));
  }
});
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
  /* padding: 10px; Add padding to make text more readable */
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

/* ---------------------------------------------------------- */

.container-slider {
  height: 500px;
  background: #f5f5f5;
  box-shadow: 0 30px 50px #dbdbdb;
}

.container-slider .slide .item {
  width: 150px;
  height: 200px;
  position: absolute;
  top: 50%;
  transform: translate(0, -50%);
  border-radius: 10px;
  box-shadow: 0 30px 50px #505050;
  background-position: 50% 50%;
  background-size: cover;
  display: inline-block;
  transition: 0.5s;
}

.slide .item:nth-child(1),
.slide .item:nth-child(2) {
  top: 0;
  left: 0;
  transform: translate(0, 0);
  border-radius: 0;
  width: 100%;
  height: 100%;
}

.slide .item:nth-child(3) {
  left: 60%;
}

.slide .item:nth-child(4) {
  left: calc(60% + 170px);
}

.slide .item:nth-child(5) {
  left: calc(60% + 340px);
}

/* here n = 0, 1, 2, 3,... */
.slide .item:nth-child(n + 6) {
  left: calc(50% + 100px);
  opacity: 0;
}

.item .content {
  position: absolute;
  top: 50%;
  left: 100px;
  width: 300px;
  text-align: left;
  color: #eee;
  transform: translate(0, -50%);
  font-family: system-ui;
  display: none;
}

.slide .item:nth-child(2) .content {
  display: block;
}

.content .name {
  font-size: 40px;
  text-transform: uppercase;
  font-weight: bold;
  opacity: 0;
  animation: animate 1s ease-in-out 1 forwards;
}

.content .des {
  margin-top: 10px;
  margin-bottom: 20px;
  opacity: 0;
  animation: animate 1s ease-in-out 0.3s 1 forwards;
}

.content button {
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  opacity: 0;
  animation: animate 1s ease-in-out 0.6s 1 forwards;
}

@keyframes animate {
  from {
    opacity: 0;
    transform: translate(0, 100px);
    filter: blur(33px);
  }

  to {
    opacity: 1;
    transform: translate(0);
    filter: blur(0);
  }
}

.button {
  width: 90%;
  text-align: center;
  position: absolute;
  bottom: 80px;
}

.button button {
  width: 30px;
  height: 25px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  margin: 0 10px;
  border: 1px solid #000;
  transition: 0.3s;
}

.button button:hover {
  background: #ababab;
  color: #fff;
}
</style>
