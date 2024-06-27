<template>
  <CategoryNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterService/>
</template>

<script>
import CategoryNavbar from '@/Components/Service/CategoryService/mobiles/NavBar.vue'
import SlideShow from '@/Components/Service/CategoryService/mobiles/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/mobiles/CardService.vue'
import FooterService from '@/Components/Service/CategoryService/mobiles/FooterService.vue'

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