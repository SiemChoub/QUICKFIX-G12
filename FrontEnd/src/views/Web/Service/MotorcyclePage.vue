<template>
  <CategoryNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterService/>
</template>

<script>
import CategoryNavbar from '@/Components/Service/CategoryService/Motorcycles/NavBar.vue'
import SlideShow from '@/Components/Service/CategoryService/Motorcycles/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/Motorcycles/CardService.vue'
import FooterService from '@/Components/Service/CategoryService/Motorcycles/FooterService.vue'

export default {
   components: {
    CategoryNavbar,
    SlideShow,
    CardService,
    FooterService,
   }
}
</script>

<style>

</style>