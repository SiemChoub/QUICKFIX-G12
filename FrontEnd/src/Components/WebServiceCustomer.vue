<template>
  <div>
    <!-- Category Selection -->
    <section id="categories">
      <h2>Categories</h2>
      <ul class="category-list">
        <li @click="filterServices(null)" :class="{ active: selectedCategory === null }">All</li>
        <li v-for="(category, index) in categories" :key="index" @click="filterServices(category.id)" :class="{ active: selectedCategory === category.id }">
          {{ category.name }}
        </li>
      </ul>
    </section>

    <!-- Services -->
    <section id="services">
      <div class="card-containers">
        <div v-for="(service, index) in filteredServices" :key="index" class="card">
          <img :src="service.image" class="card-img-top" :alt="service.name" />
          <div class="card-body">
            <h5 class="card-title">{{ service.name }}</h5>
            <p class="card-text">{{ service.description }}</p>
            <p class="card-text">Price: {{ service.price }}</p>
            <!-- Adjusted router link to use service.id -->
            <router-link :to="'/book/' + service.id" class="btn btn-primary">Book</router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Define reactive variables
const categories = ref([]);
const services = ref([]);
const selectedCategory = ref(null);

// Fetch categories and services on component mount
onMounted(async () => {
  await fetchCategories();
  await fetchServices();
});

// Function to fetch categories
async function fetchCategories() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/category/list');
    categories.value = response.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
    throw error;
  }
}

// Function to fetch services
async function fetchServices() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/service/list');
    services.value = response.data;
  } catch (error) {
    console.error('Error fetching services:', error);
    throw error;
  }
}

// Computed property for filtered services based on selected category
const filteredServices = computed(() => {
  if (!selectedCategory.value) {
    return services.value;
  } else {
    return services.value.filter(service => service.categoryId === selectedCategory.value);
  }
});

// Function to filter services based on category
function filterServices(categoryId) {
  selectedCategory.value = categoryId;
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
  padding: 1rem;
  margin-bottom: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-top: 50px;
}

.category-list {
  list-style-type: none;
  padding: 0;
  display: flex;
  justify-content: center;
}

.category-list li {
  cursor: pointer;
  padding: 0.5rem 1rem;
  margin-right: 10px;
  color: #495057;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.category-list li:hover {
  background-color: #f1f1f1;
}

.category-list .active {
  background-color:orange;
  color: #fff;
}

/* Services Styles */
#services {
  padding: 2rem 0;
}

.card-containers {
  display: flex;
  flex-wrap: nowrap; /* Prevent wrapping */
  gap: 20px; /* Adjust gap between cards */
  justify-content: flex-start; /* Align cards from the left */
  overflow-x: auto; /* Enable horizontal scrolling */
  padding-bottom: 20px; /* Add padding to accommodate scrollbar */
  margin-bottom: -20px; /* Compensate for gap to prevent extra space */
  -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
  scroll-behavior: smooth; /* Smooth scrolling behavior */
}

.card {
  flex: 0 0 calc(33.33% - 20px); /* Adjust card width and gap as needed */
  max-width: 300px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden; /* Ensure content within card does not overflow */
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
  background-color: orange; /* Your primary color */
  color: #fff;
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
  background-color: #ff7f50; /* Lighter shade on hover */
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


