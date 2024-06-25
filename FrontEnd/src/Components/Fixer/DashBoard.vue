<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="mb-3">
        <div class="card">
          <div class="card-body">
            <h3 class="p-3">CardCurrently</h3>
            <ul class="list-group gap-1 w-auto">
              <li
                v-for="(item, index) in items"
                :key="index"
                id="li"
                class="list-group-item callout-danger border-1"
              >
                <div class="pro">
                  <div class="profile w-auto d-flex gap-3">
                    <img src="/src/assets/img/cat.jpeg" alt="" class="rounded-25" />
                    <h5>
                      Repair: <b>{{ item.id }}</b>
                    </h5>
                  </div>
                  <p>Date : {{ item.date }}</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4 mb-4">
        <div class="h-100 bg-white rounded p-4">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Calendar</h6>
            <a href="">Show All</a>
          </div>
          <div id="calendar">
            <input type="date" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "../Fixer/Navbar.vue";

export default {
  name: "HistoryView",
  components: {
    Navbar,
  },
  data() {
    return {
      items: [
        { id: 1, date: "12, May 2024 12:23 PM" },
        { id: 2, date: "13, May 2024 01:30 PM" },
        { id: 3, date: "14, May 2024 02:45 PM" },
      ],
    };
  },
};

// $(document).ready(function(){
//         $('#calendar').datetimepicker({
//             inline: true,
//             format: 'L'
//         });
//     });
</script>

<style>
img {
  width: 16%;
  height: 100%;
  object-fit: cover;
}
#li {
  border-left: 5px solid coral;
}

.profile {
  display: flex;
  align-items: center;
  width: auto;
}

.pro {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
  align-items: center;
}

.pro p {
  margin: 0;
  color: rgb(0, 0, 0);
  font-size: 16px; /* Default font size */
  text-align: right;
  padding: 8px;
  border-radius: 5px;
  /* background-color: rgba(138, 130, 130, 0.43); */
  /* box-shadow: 0px 1px 0px rgba(99, 89, 89, 0.2); */
}

@media (max-width: 992px) {
  .pro p {
    font-size: 14px; /* Adjust font size for tablets */
  }
}

@media (max-width: 768px) {
  li {
    width: 100%;
  }
  .profile {
    width: auto;
  }
  .pro p {
    font-size: 12px; /* Adjust font size for phones */
    width: auto;
  }
}
@media (max-width: 512px) {
  .profile {
    width: auto;
  }
  .pro p {
    font-size: 12px; /* Adjust font size for phones */
    width: auto;
  }
  .pro {
    font-size: 12px; /* Adjust font size for phones */
    width: auto;
    /* display: grid; */
    /* grid-template-columns: auto 1fr 2fr; */
  }
}
</style>

<!-- jQuery -->

