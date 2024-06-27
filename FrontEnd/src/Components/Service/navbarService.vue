<template>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="col-lg-3 col-6 position-relative">
      <div style="position: relative; width: 80px; height: 75px;">
        <img
        src="../../assets/images/logo.png"
        alt="Logo"
        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
        />
        <div style="position: absolute; top: 50%; left: 90%; transform: translate(-50%, -50%); text-align: center;">
          <router-link to="/" class="navbar-brand">
            <b style="color: black; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);">QUICKFIX</b>
          </router-link>
        </div>
      </div>
    </div>
    
    
    <div class="container-fluid">
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="d-flex" id="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
        </form>
        <form class="d-flex1">
          <router-link to="/map">
             <i class="bi bi-map text-34px"></i>
          </router-link>
         
        </form>
        <form class="d-flex1">
          <i class="bi bi-send-fill text-34px"></i>
        </form>
        <form class="d-flex1">
          <i class="bi bi-bell-fill text-34px"></i>
        </form>
        <form class="d-flex1">
          <router-link :to="{ path: '/service/profile' }" tag="button">
  <i class="bi bi-person-circle text-34px"></i>
</router-link>        </form>
      </div>
    </div>
    <router-view/>
  </nav>
</template>

<script setup lang="ts">
// import ProfileVue from './Profile.vue'

// export default {
//   components:{
//     ProfileVue,
//   }
// }
</script>

<style>
#navbarSupportedContent {
  padding-left: 60%;
}
form{
  margin-left: 60%;
}
nav {
  background-color: rgb(203, 201, 201);
}
.d-flex1 {
  margin-left: -6%;
  padding-left: 8%;
  width: 30%;
}
#search {
  margin-right: 4%;
  margin-left: -11%;
  height: 6vh;
  width: 80%;
}
</style>