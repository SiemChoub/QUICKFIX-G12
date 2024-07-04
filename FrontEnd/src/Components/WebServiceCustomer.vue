<template>
  <div>
    <section id="categories" class="d-flex align-items-center">
      <div class="category-list-container">
          <div class="search-input">
            <i class="bi bi-search"></i>
            <input
              type="text"
              placeholder="      Search Service..."
              v-model="searchTerm"
              @input="filterCategories"
            />
          </div>
        <ul class="category-list d-flex">
          <li @click="filterServices(null)" :class="{ active: selectedCategory === null }">All</li>
          <li
            v-for="(category, index) in categories"
            :key="index"
            @click="filterServices(category.id)"
            :class="{ active: selectedCategory === category.id }"
            class="category-item"
          >
            {{ category.name }}
          </li>
        </ul>
      </div>
    </section>

    <section id="services">
      <div class="card-containers">
        <div v-for="(service, index) in filteredServices" :key="index" class="card">
          <img src="data:image/jpeg;base64,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" class="card-img-top" :alt="service.name" />
          <div class="card-body">
            <h5 class="card-title">{{ service.name }}</h5>
            <p class="card-text">{{ service.description }}</p>
            <p class="card-text">Price: {{ service.price }}</p>
            <router-link :to="'/book/'" class="btn btn-primary">Book</router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// Define reactive variables
const categories = ref([])
const services = ref([])
const selectedCategory = ref(null)
const searchTerm = ref('')

// Fetch categories and services on component mount
onMounted(async () => {
  await fetchCategories()
  await fetchServices()
})

// Function to fetch categories
async function fetchCategories() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/category/list')
    categories.value = response.data
  } catch (error) {
    console.error('Error fetching categories:', error)
    throw error
  }
}

// Function to fetch services
async function fetchServices() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/service/list')
    services.value = response.data
  } catch (error) {
    console.error('Error fetching services:', error)
    throw error
  }
}

const filteredServices = computed(() => {
  let filtered = services.value
  if (selectedCategory.value !== null) {
    filtered = filtered.filter((service) => service.categoryId === selectedCategory.value)
  }
  if (searchTerm.value.trim() !== '') {
    const regex = new RegExp(searchTerm.value.trim(), 'i')
    filtered = filtered.filter(
      (service) => regex.test(service.name) || regex.test(service.description)
    )
  }
  return filtered
})

function filterCategories() {
  // Logic to filter categories based on search term
  // Example: if categories are fetched from API and you want to filter locally
  // You can implement similar logic as in filteredServices computed property
  // categoriesFiltered.value = categories.value.filter(category => regex.test(category.name));
}

// Function to filter services based on category
function filterServices(categoryId) {
  selectedCategory.value = categoryId
}
</script>

<style scoped>
:root {
  --primary: orange;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
}

#categories {
  background-color: #fff;
  padding: 1.1rem;
  margin-bottom: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow-x: auto; /* Enable horizontal scrolling */
  -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
  scroll-behavior: smooth; /* Smooth scrolling behavior */
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative; /* Add relative positioning */
}

.category-list-container {
  flex: 1; /* Take up remaining space */
  overflow-x: auto; /* Enable horizontal scrolling */
  white-space: nowrap; /* Prevent wrapping */
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.category-list {
  list-style-type: none;
  padding: 0;
  display: flex;
  gap: 1rem;

  margin-left: 25%; 
}

.category-list li {
  cursor: pointer;
  min-width: 200px; 
  padding: 10px 15px; 
  text-align: center;
  transition: background-color 0.3s ease;
  display: inline-block;
    background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 9px rgba(0, 0, 0, 0.1);
}
.search-input {
  position: absolute;
  display: flex;
  align-items: center;
  border: 1px solid orange;
  border-radius: 5px;
  padding: 2px 10px;
  top: 15px;
}

.search-input i {
  color: orange;
  font-size: 20px;
  margin-right: 10px;
}
.category-list li:hover {
  background-color: #f1f1f1;
}

.category-list .active {
  background-color: orange;
  color: #fff;
}

.search-input input {
  border: none;
  outline: none;
  padding: 10px;
  font-size: 14px;
}

/* Services Styles */
#services {
  padding: 2rem 0;
}

.card-containers {
  display: flex;
  flex-wrap: nowrap; 
  gap: 20px; 
  justify-content: flex-start;
  overflow-x: auto; 
  padding-bottom: 20px; 
  margin-bottom: -20px; 
  -webkit-overflow-scrolling: touch; 
  scroll-behavior: smooth; 
}

.card {
  flex: 0 0 calc(33.33% - 20px); 
  max-width: 300px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden; 
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card img {
  width: 100%;
  height: auto;
  object-fit: cover;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
}

.card-body {
  padding: 1rem;
}

.card-title {
  color: #333;
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.card-text {
  color: #666;
  line-height: 1.5;
}

.btn-primary {
  background-color: var(--primary); 
  color: #fff;
  background: orange;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.btn-primary:hover {
  background-color: #ff7f50;
}

@media (max-width: 768px) {
  .card {
    flex: 0 0 calc(50% - 20px);
    max-width: calc(50% - 20px);
  }
}

@media (max-width: 576px) {
  .card {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
 