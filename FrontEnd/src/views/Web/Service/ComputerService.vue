<template>
  <CarNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterService/>
</template>

<script>
import CarNavbar from '@/Components/Service/CategoryService/Computer/NavBar.vue'
import SlideShow from '@/Components/Service/CategoryService/Computer/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/Computer/CardService.vue'
import FooterService from '@/Components/Service/CategoryService/Computer/FooterService.vue'

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