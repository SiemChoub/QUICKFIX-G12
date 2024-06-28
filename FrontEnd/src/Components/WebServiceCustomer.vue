<template>
  <div>
    <section id="services" class="service-section">
      <div class="row service">
        <div class="col col-7 d-flex flex-wrap justify-content-between py-5">
          <div class="card w-45 h-40 mt-5 mx-3 shadow">
            <p>hi</p>
          </div>
        </div>
        <div class="col col-1"></div>
        <div class="col col-4 d-flex justify-content-center align-items-center service-right">
          <div class="card text-center shadow p-5">
            <div class="card-body">
              <h5 class="card-title display-6">SERVICES</h5>
              <p class="card-text">
                Our comprehensive repair service is designed to provide quick, reliable, and professional
                solutions for a variety of household and commercial equipment.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<style scoped>
:root {
  --primary: orange;
  --secondary: #2B9BFF;
  --light: #EFFDF5;
  --dark: #2B3940;
}

.service {
  height: 80vh;
}

.card-title {
  color: var(--primary);
  font-weight: bolder;
}

.navbar .nav-link {
  cursor: pointer;
  color: var(--dark);
}

.navbar .nav-link:hover {
  color: var(--primary);
}

.navbar-brand {
  color: var(--dark);
  font-size: 40px;
}

.btn-outline-orange {
  color: var(--primary);
  border-color: var(--primary);
}

.btn-outline-orange:hover {
  background-color: var(--primary);
  color: #fff;
}
html {
  scroll-behavior: smooth;
}

</style>
