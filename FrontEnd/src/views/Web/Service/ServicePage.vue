<template>
  <serviceNavbar/>

  <SlideShow/>
  <CardService1/>
  <ShowSlide1/>
  <CardService2/>
  <ShowSlide2/>
  <FooterPage/>
</template>

<script >
import serviceNavbar from '@/Components/Service/navbarService.vue'
import SlideShow from '@/Components/Service/SlideShow.vue'
import CardService1 from '@/Components/Service/CardService1.vue'
import ShowSlide1 from '@/Components/Service/ShowSlide1.vue'
import CardService2 from '@/Components/Service/CardService2.vue'
import ShowSlide2 from '@/Components/Service/ShowSlide2.vue'
import FooterPage from '@/Components/Service/FooterPage.vue'
export default {
    components: {
        serviceNavbar,
        SlideShow,
        CardService1,
        ShowSlide1,
        CardService2,
        ShowSlide2,
        FooterPage,
        
    }
}
</script>

<style>

</style>