<template>
  <serviceNavbar/>
  <SlideShow/>
  <CardService/>
  <FooterPage/>
</template>

<script>
import serviceNavbar from '@/Components/Service/CategoryService/TukTuk/NavBar.vue'
import SlideShow from '@/Components/Service/CategoryService/TukTuk/SlideShow.vue'
import CardService from '@/Components/Service/CategoryService/TukTuk/CardService.vue'
import FooterPage from '@/Components/Service/CategoryService/TukTuk/FooterService.vue'
export default {
    components: {
        serviceNavbar,
        SlideShow,
        CardService,
        FooterPage,
        
    }
}
</script>

<style>

</style>