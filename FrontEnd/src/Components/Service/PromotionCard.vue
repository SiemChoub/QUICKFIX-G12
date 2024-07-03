<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card border-0 rounded-3 shadow-lg h-100 promotion-card">
          <div class="row g-0 h-100">
            <div class="col-md-5">
              <div class="card-image h-100">
                <img :src="promotionImage" class="img-fluid rounded-start object-fit-cover h-100" alt="Promotion Image">
              </div>
            </div>
            <div class="col-md-7">
              <div class="card-body h-100 d-flex flex-column justify-content-between">
                <div>
                  <h4 class="card-title mb-3 promotion-title">{{ promotionTitle }}</h4>
                  <p class="card-text promotion-description">{{ promotionDescription }}</p>
                </div>
                <div class="text-end">
                  <p class="mb-2">
                    <span class="badge bg-orange text-black fw-bold fs-5">OFFER: {{ promotionDiscount }}%</span>
                  </p>
                  <p class="card-text mb-2 promotion-dates">
                    <small>Promotion starts on {{ promotionStartDate }}</small>
                  </p>
                  <p class="card-text mb-4 promotion-dates">
                    <small>Promotion ends on {{ promotionEndDate }}</small>
                  </p>
                  <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-primary btn-lg claim-button" aria-label="Claim Offer">Claim Offer</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import carfixImage from '@/assets/images/carfix.png';

export default {
  data() {
    return {
      promotionImage: carfixImage,
      promotionTitle: 'Exciting Promotion',
      promotionDescription: 'Take advantage of our limited-time promotion and save big on your next purchase.',
      promotionDiscount: 25, // Promotion discount percentage
      promotionStartDate: '2022-08-31',
      promotionEndDate: '2023-08-31',
      isMouseOver: false,
    }
  },
  computed: {
    isHovered() {
      return this.isMouseOver;
    }
  }
}
</script>

<style scoped>
.promotion-card {
  transition: transform 0.3s ease-in-out;
}

.transform-up {
  transform: translateY(-10px);
}

.promotion-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.promotion-description {
  font-size: 1.1rem;
}

.promotion-discount,
.promotion-dates {
  font-size: 0.9rem;
}

.claim-button {
  font-size: 1.1rem;
  padding: 0.8rem 1.5rem;
}
</style>