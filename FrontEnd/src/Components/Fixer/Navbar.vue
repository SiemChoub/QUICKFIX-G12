<template>
  <div class="card card-header bg-none  border-0 m-0 p-0 w-100 gap-4" style="background:none;">
    <div id="card-body" class="card-body m-0 d-flex gap-4">
      <div class="cardPro align-baseline border rounded-35 p-2">
        <img
          src="/src/assets/img/cat.jpeg"
          alt="pro"
          class="w-100 bg-black shadow-lg rounded-35"
        />
      </div>
      <div class="d-flex justify-content-between cardtext">
        <h6>Name : koeuk</h6>
        <!-- <h5>ID : 123456</h5> -->
        <h6>ID : 123456</h6>
        <h6>Joined : 12 June 2024</h6>
      </div>
      <div class="dropdown mt-40">
        <div class="nav-item dropdown">
          <i class="bi icon text-25px bi-list" data-bs-toggle="dropdown"></i>

          <!-- <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
          <!-- <span class="d-none d-lg-inline-flex">John Doe</span> -->
          <div
            class="dropdown-menu dropdown-menu-end bg-white shadow-lg border-0 rounded-2 m-0"
          >
            <a href="#" class="dropdown-item">Change Profile</a>
            <a href="#" class="dropdown-item">Edit</a>
            <a href="#" class="dropdown-item">Log Out</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div id="current" class="mb-3 row flex-lg-wrap mt-5">
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Repaired : 23</h5>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Booking : 4</h5>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Booked : 3</h5>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="mb-3">
      <div id="cardbtn" class="btn d-flex align-content-center w-auto mt-5">
        <router-link to="/dashboard" id="btn1" class="btn pl-xl btn-outline" type="button"
          ><i class="bi bi-grid-fill text-36px"></i
        ></router-link>
        <router-link
          to="/booking"
          id="btn1"
          class="btn rounded-0 btn-outline-orange"
          type="button"
        >
          <i class="bi text-coral text-36px bi-cart3"></i>
        </router-link>
        <router-link
          to="/Skill"
          id="btn1"
          class="btn rounded-0 btn-xxl btn-outline-secondary"
          type="button"
        >
          <i class="bi text-36px bi-reddit"></i>
        </router-link>
        <router-link
          to="/chatView"
          id="btn1"
          class="btn rounded-0 btn-xxl btn-outline-secondary position-relative"
          type="button"
        >
          <i class="bi bi-messenger text-36px"></i>
          <h5
            class="notification bg- w-25px rounded-30 position-absolute top-0 start-100 translate-middle"
          >
            2
          </h5>
        </router-link>
        <router-link
          to="/HistoryView"
          id="btn1"
          class="btn rounded-0 book pl-xl btn-outline btn-outline-secondary"
          type="button"
        >
          <i class="bi text-36px bi-book-half"></i>
        </router-link>
      </div>
    </div>
  </div>

  <section></section>
</template>

<script>
export default {
  name: "NavBar",
};
</script>

<style>
#current {
  display: flex;
  flex-wrap: wrap;
}

.card-body{
  background-color: rgb(255, 255, 255);
  border-radius: 0px 0px 40px 40px;
}
.btn i {
  color: rgb(235, 145, 112);
}
.btn i:hover {
  color: white;
}
#cardCurr {
  width: 200px;
  display: flex;
  align-content: center;
  margin: 0;

}
.cards {
  margin: 10px;
  padding: 10px;
  width: 250px;
  height: 120px;
  border-radius: 5px 50px;
  background: rgb(255, 255, 255);
  border-left: 20px solid rgb(224, 134, 101);
  transition: 0.3s;
}
.cards:hover {
  border-left: 5px solid rgb(230, 114, 72);
  background-color: rgba(255, 127, 80, 0.327);
  background-color: linear-gradient(to right, rgba(255, 127, 80, 0.196) 0%, rgba(255, 127, 80, 0.196) 100%);
}

.notification {
  background-color: rgb(67, 67, 67);
  color: azure;
}

.icon:hover {
  scale: 1.3;
  transition: 0.3s;
  font-size: 24px;
  color: coral;
}

#btn1 {
  border: none;
  width: 100px;
}
#btn1:hover {
  background-color: rgb(90, 90, 90);
  color: rgb(255, 255, 255);
  border-radius: 10px;
  height: 100%;
  align-content: center;
  border: none;
  border-radius: 10px 0px 0px 10px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

#cardbtn {
  height: 80px;
  align-items: center;
  width: 50%;
  display: flex;
  background-color: rgb(255, 255, 255);
  color: white;
  border-radius: 10px;
  border: none;
  padding: 0;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
  align-content: center;
}

#card-body {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
}

.cardtext {
  display: flex;
  flex-direction: column;
  height: 100%;
  width: 100%;
}

@media (max-width: 512px) {
  .profile {
    width: auto;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .pro p {
    font-size: 12px;
    width: 150px;
  }
  h5 {
    font-size: 12px;
    width: auto;
    display: flex;
    align-self: center;
  }
  .profile img {
    display: none;
  }
  .pro {
    font-size: 10px;
    width: auto;
  }
  strong {
    font-size: 10px;
    width: auto;
  }

  #cardCurr {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }
  .cards {
    background-color: rgb(255, 255, 255);

    width: 80%;
    height: 100%;
    display: flex;
    align-items: center;
  }
  .card-body {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 10px;
  }
  #cardbtn {
    width: 100%;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: row;
    justify-content: center;
  }
  #cardbtn #btn {
    height: 100%;
    background-color: rgb(5, 162, 162);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 10px;
  }
  .btn i {
    font-size: 20px;
  }

  #btn1 .book :hover {
    background-color: rgb(255, 123, 0);
    color: rgb(255, 255, 255);
    border-radius: 10px;
    height: 100%;
    align-content: center;
    border: none;
    font-size: 20px;
    font-weight: bold;
  }
}
</style>
