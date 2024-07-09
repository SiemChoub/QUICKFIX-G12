<template>
  <div>
    <!-- <Navbar /> -->
    <div class="container">
      <div class="mb-3 d-flex">
        <div class="row w-full h-auto w-100  rounded-2 p-0 d-flex p-3">
          <!-- <div class="col-sm-12"> -->
            <div class="card border-0 w-100">
              <div class="card-body row d-flex g-3 justify-content-between">
                <div
                  class="cards d-flex flex-column shadow-lg gap-3 justify-content-center align-items-center"
                >
                  <h5 class="card-title">Repaired</h5>
                  <h5
                    class="card-title rounded-3 d-flex border-1 p-2 w-auto align-items-center justify-content-center shadow"
                  >
                    23
                  </h5>
                </div>
                <div
                  class="cards d-flex flex-column shadow-lg gap-3 justify-content-center align-items-center"
                >
                  <h5 class="card-title">Currently</h5>
                  <h5
                    class="card-title rounded-3 d-flex border-1 p-2 w-auto align-items-center justify-content-center shadow"
                  >
                    23
                  </h5>
                </div>
                <div
                  class="cards d-flex flex-column shadow-lg gap-3 justify-content-center align-items-center"
                >
                  <h5 class="card-title">Booked</h5>
                  <h5
                    class="card-title rounded-3 d-flex border-1 p-2 w-auto align-items-center justify-content-center shadow"
                  >
                    23
                  </h5>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </div>
      </div>
      
      <div class="row w-full">
        <div class="col-sm-8">
          <div class="card w-100 ml-2 border-0 p-4">
            <canvas id="myChart"></canvas>
          </div>
        </div>
        <div class="col-sm-4 h-100">
          <div class="card w-100 ml-2 border-0 p-4">
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="mb-0">Calendar</h6>
              <a href="">Show All</a>
            </div>
            <div id="calendar" class="w-100">
              <input type="date" class="form-control" />
            </div>
          </div>
        </div>
        <!-- <div class="col-sm-4">
          <div class="card border-0">
            <div class="card-body">
              <div class="p-3">
                <div class="d-flex align-items-center justify-content-between">
                  <h6 class="mb-0">Calendar</h6>
                  <a href="">Show All</a>
                </div>
                <div id="calendar" class="w-100">
                  <input type="date" class="form-control w-100" />
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
// import Navbar from "../Fixer/Navbar.vue";
import Chart from "chart.js/auto";
export default {
  name: "HistoryView",
  
  data() {
    return {
      items: [
        { id: 1, date: "12, May 2024 12:23 PM" },
        { id: 2, date: "13, May 2024 01:30 PM" },
        { id: 3, date: "14, May 2024 02:45 PM" },
      ],
    };
  },
  mounted() {
    const ctx = document.getElementById("myChart");
    // const ctx = Utils.months({count: 7});
    const myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
          {
            label: "# of Votes",
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)",
            ],
            borderColor: [
              "rgba(255, 99, 132, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)",
            ],
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
    myChart;
  },
};
</script>

<style>
.cards {
  width: 250px;
  height: 120px;
  border-radius: 5px 5px 5px 50px;
  background: #fff;
  border-left: 20px solid orange;
  transition: 0.3s;
  color: #434343;
}
.cards:hover {
  border-left: 5px solid orange;
  background-color: rgb(241, 241, 241);
  color: orange;
}
img {
  width: 16%;
  height: 100%;
  object-fit: cover;
}
#li {
  border-left: 5px solid coral;
}

@media (max-width: 992px) {
  /* .pro p {
    font-size: 14px; 
  } */
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
  .w-full {
    display: flex;
    gap: 12px;
    align-items: center;
  }
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
  }

  #current {
    display: flex;
    flex-wrap: wrap;
    /* background: #000; */
    margin-left: 10px;
  }
  .cards {
    display: flex;
    width: 45%;
    height: 80px;
    padding: 0px;
    border-radius: 10px;
    gap: 0px;
    /* background: #000; */
  }
  .box-shadow {
    border-radius: 10px;
    box-shadow: #434343 px 2px 2px 2px;
  }
  .cards .card-title {
    font-size: 12px;
  }
}
</style>
