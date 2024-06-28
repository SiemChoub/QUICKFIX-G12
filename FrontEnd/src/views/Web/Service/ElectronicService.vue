<template>
  <CarNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterService/>
</template>

<script>
import CarNavbar from '@/Components/Service/CategoryService/Electronic/NavBar.vue'
import SlideShow from '@/Components/Service/CategoryService/Electronic/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/Electronic/CardService.vue'
import FooterService from '@/Components/Service/CategoryService/Electronic/FooterService.vue'

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