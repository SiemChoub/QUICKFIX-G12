<template>
  <Navbar />
  <div class="container">
    <div class="mb-3 p-2">
      <div class="list-btn d-flex gap-sm-4">
        <h3 id="booking" class="btn btn-outline-secondary text-16px" @click="showBooking">
          Booking
        </h3>
        <h3 id="booked" class="btn btn-outline-success text-16px" @click="showBooked">
          Booked
        </h3>
      </div>
      <ul v-if="isBooking" id="list-booking" class="list-group w-100 gap-3 mt-2">
        <li
          id="list_booking_item"
          class="list-group-item action rounded-2 d-flex w-100 flex-column flex-md-row align-items-center gap-3"
         
        >
          <div class="right d-flex align-items-center gap-3">
            <img
              src="/src/assets/img/cat.jpeg"
              class="rounded-circle"
              style="width: 50px; height: 50px"
              alt="Profile"
            />
            <h3 class="h5 mb-0">koeuk</h3>
          </div>
          <div class="left d-flex align-items-center flex-grow-1 mt-2 mt-md-0">
            <p class="mb-0">Date: 12,12,2024</p>
          </div>
          <div
            class="btn-groups d-flex flex-wrap flex-md-nowrap justify-content-end mt-2 mt-md-0 gap-2"
          >
            <router-link to="/chatView" class="btn"
              ><i class="bi text-secondary text-25px bi-messenger"></i
            ></router-link>
            <button class="btn">
              <i class="bi text-danger text-25px bi-x-circle-fill"></i>
            </button>
            <!-- <button
              class="btn "
              data-bs-toggle="modal"
              data-bs-target="#edit"
            >
            <i class="bi text-25px bi-pencil-square"></i>
            </button> -->
            <button class="btn">
              <i class="bi text-secondary text-25px bi-check2-circle"></i>
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="bi text-primary text-25px bi-info-square"></i>
            </button>
          </div>
        </li>
      </ul>
      <!-- <h3>List Booking</h3> -->
      <ul v-else id="list_booked" class="list-group gap-3 mt-2">
        <li
          v-for="i in 3"
          :key="i"
          id="list_booked_item"
          class="list-group-item rounded-2 d-flex flex-column flex-md-row align-items-center gap-3"
         
        >
          <div class="right d-flex align-items-center gap-3">
            <img
              src="/src/assets/img/cat.jpeg"
              class="rounded-circle"
              style="width: 50px; height: 50px"
              alt="Profile"
            />
            <h3 class="h5 mb-0">koeuk</h3>
          </div>
          <div class="left d-flex align-items-center flex-grow-1 mt-2 mt-md-0">
            <p class="mb-0">Date: 12,12,2024</p>
          </div>
          <div
            class="btn-groups d-flex flex-wrap flex-md-nowrap justify-content-end mt-2 mt-md-0 gap-2"
          >
            <router-link to="/chatView" class="btn"
              ><i class="bi text-25px bi-messenger"></i
            ></router-link>
            <button class="btn">
              <i class="bi text-danger text-25px bi-x-circle-fill"></i>
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#edit">
              <i class="bi text-25px bi-pencil-square"></i>
            </button>
            <button class="btn">
              <i class="bi text-secondary text-25px bi-check2-circle"></i>
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="bi text-primary text-25px bi-info-square"></i>
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <!-- Button trigger modal -->
  <!-- <button
    type="button"
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#exampleModal"
  >
    sdf
  </button> -->

  <!-- Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog ml-0 h-100 mt-0 modal-dialog-scrollable modal-lg">
      <div class="modal-content rounded-0 mt-0">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="card p-2">
            <div class="d-flex flex-column flex-md-comlumn gap-3">
              <div class="d-flex align-items-center gap-3">
                <img
                  src="/src/assets/img/cat.jpeg"
                  class="rounded-circle shadow-lg"
                  style="width: 100px; height: 100px"
                  alt="Profile"
                />
                <h3 class="h5 mb-0"><b>koeuk</b></h3>
              </div>
              <div class="d-flex flex-column mt-3 mt-md-0">
                <p class="mb-0 text-16px"><b>Date:</b> 12-12-2024</p>
                <p class="mb-0 text-16px"><b>Booked :</b> 18-12-2024</p>
                <p class="mb-0 text-16px">
                  <b>Description :</b> Please fix my machine on the day that I provided
                  above.
                </p>
              </div>
            </div>
            <div class="btn-groups d-flex flex-wrap justify-content-end mt-2 gap-2">
              <router-link to="/chatView" class="btn btn-outline-danger">
                <i class="bi text-25px bi-messenger"></i>
              </router-link>
              <button
                class="btn btn-outline-danger"
                data-bs-toggle="modal"
                data-bs-target="#edit"
              >
                <i class="bi text-25px bi-pencil-square"></i>
              </button>
            </div>
          </div>
          <div class="ratio ratio-16x9 mt-4">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509616!2d144.95373531531037!3d-37.81627927975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f08fba33%3A0x4b0b0b0b0b0b0b0b!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1615689992598!5m2!1sen!2sau"
              allowfullscreen=""
              loading="lazy"
              style="width: 100%; height: 300px"
            ></iframe>
          </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-outline-primary">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>
  
  <div
  class="modal fade"
  id="edit"
  tabindex="-1"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog ml-0 h-100 mt-0 modal-dialog-scrollable modal-lg">
    <div class="modal-content rounded-0 h-100 mt-0">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Card</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="card p-3">
          <div class="d-flex flex-column flex-md-row gap-2">
            <div class="info d-flex ml-0 justify-content-between w-100">
              <div class="d-flex align-items-center gap-3">
                <img
                  src="/src/assets/img/cat.jpeg"
                  class="rounded-circle shadow-lg"
                  style="width: 100px; height: 100px"
                  alt="Profile"
                />
                <h3 class="h5 mb-0"><b>koeuk</b></h3>
              </div>
              <div class="date d-flex justify-content-end ">
                <input
                  type="date"
                  class="form-control w-auto h-30px w-auto"
                />
              </div>
            </div>
          </div>
          <div class="mt-3">
            <p class="mb-0 text-16px"><b>Date:</b> 12-12-2024</p>
            <p class="mb-0 text-16px"><b>Booked :</b> 18-12-2024</p>
            <p class="mb-0 text-16px">
              <b>Description :</b>Please fix my machine on the day that I provided above.
            </p>
          </div>
          <div class="d-flex flex-wrap justify-content-end mt-2 gap-2">
            <router-link to="/chatView" class="btn btn-outline-danger">
              <i class="bi text-25px bi-messenger"></i>
            </router-link>
            <button
              class="btn btn-outline-danger"
              data-bs-toggle="modal"
              data-bs-target="#edit"
            >
              <i class="bi text-25px bi-pencil-square"></i>
            </button>
          </div>
        </div>
        <div class="ratio ratio-16x9 mt-4">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509616!2d144.95373531531037!3d-37.81627927975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f08fba33%3A0x4b0b0b0b0b0b!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1615689992598!5m2!1sen!2sau"
            allowfullscreen=""
            loading="lazy"
            style="width: 100%; height: 300px"
          ></iframe>
        </div>
      </div>
      <div class="modal-footer mt-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-outline-primary">Update</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import Navbar from "@/Components/Fixer/Navbar.vue";

export default {
  name: "booking",
  components: {
    Navbar,
  },
  // list of hidden bookings
  data() {
    return {
      isBooking: true,
    };
  },
  methods: {
    showBooking() {
      this.isBooking = true;
    },
    showBooked() {
      this.isBooking = false;
    },
  },
};
// the end
</script>

<style>

 #list_booking_item, #list_booked_item {
  border-left: 15px solid rgb(129, 129, 129);
  transition: transform 0.2s;
 }
 #list_booking_item:hover  {
  transform: scale(1.02);
 }
 #list_booked_item:hover {
  transform: scale(1.02);
 }

#list-booking {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.right {
  display: flex;
  justify-content: space-between;
}
.left {
  display: flex;
  justify-content: flex-start;
}

.info {
  display: flex;
  flex-direction: row;
  gap: 2px;
}
@media (min-width: 768px) {
  #list-booking {
    flex-direction: row;
  }
}

.left {
  display: flex;
  justify-content: flex-start;
}

.btn-groups {
  display: flex;
  gap: 0.5rem;
}

@media (max-width: 512px) {
  #list-booking {
    flex-direction: column;
  }
  #list_booked_item {
    display: flex;
    flex-direction: column;
    border-left: rgb(58, 58, 58) 15px solid;
    margin: 0px;
  }
  .right {
    width: 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0px;
    padding: 0;
    margin: 0;
  }
  .left {
    background-color: antiquewhite;
  }
  .list-btn {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 5px;
  }
}
</style>
