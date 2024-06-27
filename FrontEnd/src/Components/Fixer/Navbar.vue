<template>
  <div class="card card-header bg-none border-0 m-0 p-0 w-100 gap-4" style="background: none">
    <div id="card-body" class="card-body m-0 d-flex gap-4">
      <div class="cardPro align-baseline border rounded-35 p-2">
        <img src="/src/assets/img/cat.jpeg" alt="pro" class="w-100 bg-black shadow-lg rounded-35" />
      </div>
      <div class="d-flex flex-column justify-content-center cardtext">
        <h6>Name: koeuk</h6>
        <h6>ID: 123456</h6>
        <h6>Joined: 12 June 2024</h6>
      </div>
      <div class="dropdown mt-40">
        <div class="nav-item dropdown">
          <i class="bi icon text-25px bi-list" data-bs-toggle="dropdown"></i>

          <div class="dropdown-menu dropdown-menu-end bg-white shadow-lg border-0 rounded-2 m-0">
            <a href="#" class="dropdown-item">Change Profile</a>
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              Edit
            </button>
            <a href="#" class="dropdown-item">Log Out</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form for editing profile details -->
        <form id="updateForm">
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" value="koeuk"  />
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" style="background-color: orange;">Update</button>
      </div>
    </div>
  </div>
</div>

  <div class="container">
    <div id="current" class="mb-3 row flex-lg-wrap mt-5">
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Repaired: 23</h5>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Booking: 4</h5>
        </div>
      </div>
      <div id="cardCurr" class="col w-auto">
        <div class="cards d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">Booked: 3</h5>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="mb-3">
      <div id="cardbtn" class="btn d-flex align-content-center w-auto mt-5">
        <router-link to="/dashboard" class="btn pl-xl btn-outline" type="button">
          <i class="bi bi-grid-fill text-36px"></i>
        </router-link>
        <router-link to="/booking" class="btn rounded-0 btn-outline-orange" type="button">
          <i class="bi text-coral text-36px bi-cart3"></i>
        </router-link>
        <router-link to="/Skill" class="btn rounded-0 btn-xxl btn-outline-secondary" type="button">
          <i class="bi text-36px bi-reddit"></i>
        </router-link>
        <router-link to="/chatView" class="btn rounded-0 btn-xxl btn-outline-secondary position-relative" type="button">
          <i class="bi bi-messenger text-36px"></i>
          <h5 class="notification bg-white text-dark rounded-30 position-absolute top-0 start-100 translate-middle">2</h5>
        </router-link>
        <router-link to="/HistoryView" class="btn rounded-0 book pl-xl btn-outline btn-outline-secondary" type="button">
          <i class="bi text-36px bi-book-half"></i>
        </router-link>
      </div>
    </div>
  </div>
  <section></section>
</template>

<script>
export default {
  name: 'NavBar',
  methods: {
    updateUser() {
      // Functionality to update user profile (you can implement this as per your requirement)
      console.log('Updating user...');
    }
  }
};
</script>

<style scoped>
#current {
  display: flex;
  flex-wrap: wrap;
}

.card-body {
  background-color: #fff;
  border-radius: 0 0 40px 40px;
}

.btn i {
  color: #eb9170;
}

.btn i:hover {
  color: #fff;
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
  background: #fff;
  border-left: 20px solid #e08665;
  transition: 0.3s;
}

.cards:hover {
  border-left: 5px solid #e67248;
  background-color: rgba(255, 127, 80, 0.327);
  background-color: linear-gradient(to right, rgba(255, 127, 80, 0.196) 0%, rgba(255, 127, 80, 0.196) 100%);
}

.notification {
  background-color: #434343;
  color: #fff;
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
  background-color: #5a5a5a;
  color: #fff;
  border-radius: 10px;
  height: 100%;
  align-content: center;
  border: none;
  border-radius: 10px 0 0 10px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

#cardbtn {
  height: 80px;
  align-items: center;
  width: 50%;
  display: flex;
  background-color: #fff;
  color: #fff;
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
    background-color: #fff;
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
    background-color: #05a2a2;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 10px;
  }

  .btn i {
    font-size: 20px;
  }

  #btn1 .book:hover {
    background-color: #ff7b00;
    color: #fff;
    border-radius: 10px;
    height: 100%;
    align-content: center;
    border: none;
    font-size: 20px;
    font-weight: bold;
  }
}
</style>
