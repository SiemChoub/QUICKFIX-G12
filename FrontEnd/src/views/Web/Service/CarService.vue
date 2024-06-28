<template>
  <CarNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterService/>
</template>

<script>
import CarNavbar from '@/Components/Service/CategoryService/CarService/Navbar.vue'
import SlideShow from '@/Components/Service/CategoryService/CarService/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/CarService/CardService.vue'
import FooterService from '@/Components/Service/CategoryService/CarService/FooterService.vue'

export default {
   components: {
    CarNavbar,
    SlideShow,
    CardService,
    FooterService,
   }
}
</script>

<style>

</style>