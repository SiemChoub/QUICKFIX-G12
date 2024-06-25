<template>
  <div class="card card-header m-0 rounded-0 w-100 gap-4">
    <div id="card-body" class="card-body d-flex gap-4">
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
      <div class="dropdown bi mt-0">
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <!-- <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
            <!-- <span class="d-none d-lg-inline-flex">John Doe</span> -->
          </a>
          <div
            class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0"
          >
            <a href="#" class="dropdown-item">Change Profile</a>
            <a href="#" class="dropdown-item">Edit</a>
            <a href="#" class="dropdown-item">Log Out</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container w-auto">
    <div id="current" class="row flex-lg-wrap mt-5">
      <div id="cardCurr" class="col w-auto">
        <div class="cards">
          <div
            class="card-body h-100 d-flex flex-column justify-content-center align-items-center"
          >
            <h5 class="card-title">Repaired : 23</h5>
            <!-- <h5 class="card-text">Rates : 23</h5> -->
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
          </div>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards">
          <div
            class="card-body h-100 d-flex flex-column justify-content-center align-items-center"
          >
            <h5 class="card-title">Booking : 4</h5>
            <!-- <p class="card-text">With supporting text</p> -->
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
          </div>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards">
          <div
            class="card-body h-100 d-flex flex-column justify-content-center align-items-center"
          >
            <h5 class="card-title">Booked : 3</h5>
            <!-- <p class="card-text">With supporting text</p> -->
            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="mb-3 p-2">
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
            class="notification bg- w-25px bg-dark rounded-30 position-absolute top-0 start-100 translate-middle"
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
  /* background: darkgrey; */
  display: flex;
  flex-wrap: wrap;
  /* padding: 5px; */
}
.card-header {
  background-color: rgb(255, 123, 0);
  /* background: linear-gradient(to right,rgba(78, 78, 72, 0.092), orange ); */
}
.btn i {
  color: rgb(255, 123, 0);
}
.btn i:hover {
  color: white;
}
.cards {
  margin: 10px;
  padding: 10px;
  width: 250px;
  height: 120px;
  border-radius: 10px;
  background: white;
  /* box-shadow: 0 4px 8px 0 rgba(101, 101, 101, 0.2), 0 6px 20px 0 rgba(120, 113, 113, 0.19); */
  transition: 0.3s;
}
.notification {
  /* padding: .5px; */
  border: 1px solid rgb(39, 39, 170);
  background-color: coral;
    /* font-size: 0.75rem;  */
    /* color: white;  */
    /* border-radius: 50%;  */
    /* padding: 0.2rem 0.5rem; */
    /* transform: translate(-50%, -50%);  */
  }
#btn {
  background-color: rgb(255, 123, 0);
  color: rgb(0, 0, 0);
  border-radius: 10px;
  width: 150px;
  height: 100%;
  align-content: center;
  border: none;
  border-radius: 10px 0px 0px 10px;
  padding: 5px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}
#btn1 {
  border: none;
  width: 100px;
}
#btn1:hover {
  background-color: rgb(255, 123, 0);
  color: rgb(255, 255, 255);
  border-radius: 10px;
  /* width: 120px; */
  height: 100%;
  align-content: center;
  border: none;
  border-radius: 10px 0px 0px 10px;
  /* padding: 5px; */
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
  /* margin-top: 150px; */
  padding: 0;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
  align-content: center;
}
#cardCurr {
  width: 200px;
  /* height: 200px; */
  /* background: #796666; */
  display: flex;
  align-content: center;

  margin: 0;
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
  /* align-items: start; */
  /* justify-content: start; */
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
    font-size: 12px; /* Adjust font size for phones */
    width: 150px;
  }
  h5 {
    font-size: 12px; /* Adjust font size for phones */
    width: auto;
    display: flex;
    align-self: center;

    /* display: grid; */
    /* grid-template-columns: auto 1fr 2fr; */
  }
  .profile img {
    display: none;
  }
  .pro {
    font-size: 10px; /* Adjust font size for phones */
    width: auto;
    /* display: grid; */
    /* grid-template-columns: auto 1fr 2fr; */
  }
  strong {
    font-size: 10px; /* Adjust font size for phones */
    width: auto;
    /* display: grid; */
    /* grid-template-columns: auto 1fr 2fr; */
  }

  #cardCurr {
    /* background-color: bisque; */
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    /* padding: 10px; */
  }
  .cards {
    background-color: rgb(255, 255, 255);

    width: 80%;
    height: 100%;
    display: flex;
    align-items: center;
    /* justify-content: center; */
    /* flex-direction: column; */
    /* padding: 10px; */
  }
  .card-body {
    /* background-color: aquamarine; */
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
    /* background-color: rgb(5, 162, 162); */
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: row;
    justify-content: center;
    /* padding: 10px; */
  }
  #cardbtn #btn {
    /* width: 100%; */
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
    /* width: 120px; */
    height: 100%;
    align-content: center;
    border: none;
    /* border-radius: 0px 10px 10px 0px; */
    /* padding: 5px; */
    font-size: 20px;
    font-weight: bold;
    /* cursor: pointer; */
  }
}
</style>
