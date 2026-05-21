<template>
  <div class="qf-svc">
    <!-- Section header -->
    <header class="qf-svc__head">
      <div class="qf-svc__head-left">
        <div class="qf-svc__eyebrow qf-mono">/services — directory</div>
        <h2 class="qf-svc__title">
          What can we <em>fix</em> for you today?
        </h2>
      </div>
      <div class="qf-svc__head-right qf-mono">
        <span>{{ filteredServices.length }}</span> / {{ services.length }} matched
      </div>
    </header>

    <!-- Sticky filter bar -->
    <section class="qf-filter">
      <div class="qf-filter__search">
        <i class="bi bi-search"></i>
        <input
          type="text"
          placeholder="Search services, parts, repairs..."
          v-model="searchTerm"
          @input="filterCategories"
        />
        <button v-if="searchTerm" class="qf-filter__clear" @click="searchTerm = ''" aria-label="Clear">
          <i class="bi bi-x"></i>
        </button>
      </div>

      <div class="qf-filter__chips" ref="chipsBar">
        <button
          @click="filterServices(null)"
          class="qf-chip"
          :class="{ 'qf-chip--active': selectedCategory === null }"
        >
          <span class="qf-mono">01</span> All
        </button>
        <button
          v-for="(category, index) in categories"
          :key="index"
          @click="filterServices(category.name)"
          class="qf-chip"
          :class="{ 'qf-chip--active': selectedCategory === category.name }"
        >
          <span class="qf-mono">{{ String(index + 2).padStart(2, '0') }}</span>
          {{ category.name }}
        </button>
      </div>
    </section>

    <!-- Service grid -->
    <section class="qf-grid">
      <article
        v-if="filteredServices.length === 0"
        class="qf-empty-state"
      >
        <div class="qf-mono">/no_results</div>
        <p>No services match your filter. Try clearing the search or selecting a different category.</p>
        <button class="qf-btn qf-btn--ghost" @click="resetFilters">Reset filters</button>
      </article>

      <article
        v-for="(service, index) in filteredServices"
        :key="index"
        class="qf-card"
        @click="openModal(service)"
      >
        <div class="qf-card__media">
          <img :src="service.image" :alt="service.name" loading="lazy" />
          <div class="qf-card__tag qf-mono">
            <span class="qf-card__tag-dot"></span>
            {{ service.category || 'GENERAL' }}
          </div>
        </div>
        <div class="qf-card__body">
          <h3 class="qf-card__title">{{ service.name }}</h3>
          <p class="qf-card__desc">{{ service.description }}</p>
          <div class="qf-card__foot">
            <div class="qf-card__price">
              <span class="qf-mono">USD</span>
              <span class="qf-card__price-num">{{ service.price }}</span>
            </div>
            <button class="qf-card__cta" @click.stop="openModal(service)">
              <span>Book</span>
              <i class="bi bi-arrow-up-right"></i>
            </button>
          </div>
        </div>
      </article>
    </section>

    <ModalForm v-if="showModal" :service="selectedService" @close="closeModal" />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import ModalForm from '@/Components/BookingForm.vue'

const categories = ref([])
const services = ref([])
const selectedCategory = ref(null)
const searchTerm = ref('')
const showModal = ref(false)
const selectedService = ref(null)

onMounted(async () => {
  await fetchCategories()
  await fetchServices()
})

async function fetchCategories() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/category/list')
    categories.value = response.data.category
  } catch (error) {
    console.error('Error fetching categories:', error)
  }
}

async function fetchServices() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/service/list')
    services.value = response.data.services
  } catch (error) {
    console.error('Error fetching services:', error)
  }
}

const closeModal = () => {
  showModal.value = false
  selectedService.value = null
}

const openModal = (service) => {
  selectedService.value = service
  showModal.value = true
}

const filteredServices = computed(() => {
  let filtered = services.value
  if (selectedCategory.value !== null) {
    filtered = filtered.filter((service) => {
      const category = categories.value.find((cat) => cat.name === service.category)
      return category && category.name === selectedCategory.value
    })
  }
  if (searchTerm.value.trim() !== '') {
    const regex = new RegExp(searchTerm.value.trim(), 'i')
    filtered = filtered.filter(
      (service) => regex.test(service.name) || regex.test(service.description)
    )
  }
  return filtered
})

function filterServices(categoryName) {
  selectedCategory.value = categoryName
}

function filterCategories() {
  selectedCategory.value = null
}

function resetFilters() {
  searchTerm.value = ''
  selectedCategory.value = null
}
</script>

<style scoped>
.qf-svc {
  --qf-bone: #F2EFE6;
  --qf-bone-deep: #EAE6DB;
  --qf-ink: #0F1011;
  --qf-steel: #1C1C1F;
  --qf-orange: #FF5B1F;
  --qf-orange-deep: #D8460B;
  --qf-fog: #9C998F;
  --qf-rule: rgba(15, 16, 17, 0.12);
  --qf-font-display: 'Bricolage Grotesque', system-ui, sans-serif;
  --qf-font-body: 'DM Sans', system-ui, sans-serif;
  --qf-font-mono: 'IBM Plex Mono', 'Menlo', monospace;
  font-family: var(--qf-font-body);
  color: var(--qf-ink);
}

.qf-mono {
  font-family: var(--qf-font-mono);
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--qf-steel);
}

/* Header */
.qf-svc__head {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 32px;
  gap: 24px;
}
.qf-svc__eyebrow {
  color: var(--qf-orange);
  margin-bottom: 12px;
  display: block;
}
.qf-svc__title {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: clamp(34px, 4.4vw, 60px);
  line-height: 1.02;
  letter-spacing: -0.03em;
  margin: 0;
  color: var(--qf-ink);
  max-width: 720px;
}
.qf-svc__title em {
  font-style: italic;
  color: var(--qf-orange);
  font-weight: 600;
}
.qf-svc__head-right { color: var(--qf-fog); flex-shrink: 0; }
.qf-svc__head-right span { color: var(--qf-orange); font-weight: 600; }

/* Sticky filter bar */
.qf-filter {
  position: sticky;
  top: 88px;
  z-index: 20;
  background: rgba(242, 239, 230, 0.88);
  backdrop-filter: blur(12px) saturate(140%);
  -webkit-backdrop-filter: blur(12px) saturate(140%);
  border: 1px solid var(--qf-rule);
  border-radius: 14px;
  padding: 12px;
  margin-bottom: 36px;
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 12px;
  align-items: center;
}
.qf-filter__search {
  position: relative;
  display: flex;
  align-items: center;
  background: var(--qf-bone-deep);
  border: 1px solid transparent;
  border-radius: 10px;
  padding: 4px 10px;
  transition: border-color 0.2s ease;
}
.qf-filter__search:focus-within { border-color: var(--qf-orange); }
.qf-filter__search i { color: var(--qf-fog); font-size: 15px; }
.qf-filter__search input {
  flex: 1;
  border: none;
  background: transparent;
  outline: none;
  padding: 10px 8px;
  font-family: var(--qf-font-body);
  font-size: 14px;
  color: var(--qf-ink);
}
.qf-filter__search input::placeholder { color: var(--qf-fog); }
.qf-filter__clear {
  background: var(--qf-ink);
  color: var(--qf-bone);
  border: none;
  width: 24px;
  height: 24px;
  display: grid;
  place-items: center;
  border-radius: 999px;
  cursor: pointer;
  font-size: 12px;
}

.qf-filter__chips {
  display: flex;
  gap: 6px;
  overflow-x: auto;
  scrollbar-width: thin;
  scrollbar-color: var(--qf-fog) transparent;
  padding: 2px;
  margin: -2px;
  scroll-behavior: smooth;
}
.qf-filter__chips::-webkit-scrollbar { height: 4px; }
.qf-filter__chips::-webkit-scrollbar-track { background: transparent; }
.qf-filter__chips::-webkit-scrollbar-thumb { background: var(--qf-rule); border-radius: 4px; }

.qf-chip {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 9px 16px;
  background: transparent;
  border: 1px solid var(--qf-rule);
  color: var(--qf-steel);
  border-radius: 999px;
  font-family: var(--qf-font-body);
  font-weight: 500;
  font-size: 13.5px;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
}
.qf-chip:hover { border-color: var(--qf-ink); transform: translateY(-1px); }
.qf-chip .qf-mono { font-size: 10px; color: var(--qf-fog); }
.qf-chip--active {
  background: var(--qf-ink);
  color: var(--qf-bone);
  border-color: var(--qf-ink);
}
.qf-chip--active .qf-mono { color: var(--qf-orange); }

/* Grid */
.qf-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 20px;
  padding-bottom: 20px;
}

/* Empty state */
.qf-empty-state {
  grid-column: 1 / -1;
  padding: 64px 32px;
  background: var(--qf-bone-deep);
  border: 1px dashed var(--qf-rule);
  border-radius: 16px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}
.qf-empty-state .qf-mono { color: var(--qf-orange); }
.qf-empty-state p {
  font-size: 15px;
  color: var(--qf-steel);
  margin: 0;
  max-width: 380px;
}

/* Card */
.qf-card {
  position: relative;
  background: var(--qf-bone-deep);
  border: 1px solid var(--qf-rule);
  border-radius: 16px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: transform 0.3s cubic-bezier(.2,.9,.3,1.05), border-color 0.25s ease, box-shadow 0.3s ease;
}
.qf-card:hover {
  transform: translateY(-4px);
  border-color: var(--qf-ink);
  box-shadow: 0 24px 60px -20px rgba(15,16,17,0.22);
}
.qf-card__media {
  position: relative;
  aspect-ratio: 4 / 3;
  overflow: hidden;
  background: var(--qf-steel);
}
.qf-card__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(.2,.9,.3,1);
}
.qf-card:hover .qf-card__media img { transform: scale(1.06); }
.qf-card__tag {
  position: absolute;
  top: 14px;
  left: 14px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 9px;
  background: rgba(15,16,17,0.75);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  color: var(--qf-bone);
  border-radius: 999px;
  font-size: 9.5px;
  letter-spacing: 0.08em;
}
.qf-card__tag-dot {
  width: 5px;
  height: 5px;
  background: var(--qf-orange);
  border-radius: 50%;
}

.qf-card__body {
  padding: 18px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  flex: 1;
}
.qf-card__title {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: 19px;
  letter-spacing: -0.02em;
  margin: 0;
  color: var(--qf-ink);
  line-height: 1.2;
}
.qf-card__desc {
  font-size: 13.5px;
  line-height: 1.5;
  color: var(--qf-steel);
  margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
}
.qf-card__foot {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 6px;
  padding-top: 14px;
  border-top: 1px dashed var(--qf-rule);
}
.qf-card__price { display: flex; align-items: baseline; gap: 4px; }
.qf-card__price .qf-mono { color: var(--qf-fog); font-size: 10px; }
.qf-card__price-num {
  font-family: var(--qf-font-display);
  font-weight: 700;
  font-size: 22px;
  color: var(--qf-ink);
  letter-spacing: -0.02em;
}
.qf-card__cta {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: var(--qf-ink);
  color: var(--qf-bone);
  border: none;
  border-radius: 999px;
  font-family: var(--qf-font-body);
  font-weight: 600;
  font-size: 13px;
  cursor: pointer;
  transition: background 0.25s ease, transform 0.18s ease;
}
.qf-card__cta i { transition: transform 0.3s ease; }
.qf-card__cta:hover { background: var(--qf-orange); transform: translateX(2px); }
.qf-card__cta:hover i { transform: translate(2px, -2px); }

/* Inline button */
.qf-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 18px;
  font-family: var(--qf-font-body);
  font-weight: 600;
  font-size: 13.5px;
  border-radius: 10px;
  border: 1px solid var(--qf-ink);
  background: transparent;
  color: var(--qf-ink);
  cursor: pointer;
  transition: background 0.2s ease, color 0.2s ease;
}
.qf-btn--ghost:hover { background: var(--qf-ink); color: var(--qf-bone); }

/* Responsive */
@media (max-width: 900px) {
  .qf-filter {
    grid-template-columns: 1fr;
    top: 80px;
  }
  .qf-svc__head { flex-direction: column; align-items: flex-start; gap: 10px; }
  .qf-svc__head-right { font-size: 11px; }
}
@media (max-width: 600px) {
  .qf-grid { grid-template-columns: 1fr; gap: 16px; }
  .qf-card__media { aspect-ratio: 16 / 10; }
  .qf-svc__title { font-size: 32px; }
  .qf-filter { padding: 10px; border-radius: 12px; }
}
</style>
