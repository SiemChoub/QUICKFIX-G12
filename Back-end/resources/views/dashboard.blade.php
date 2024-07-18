<x-app-layout>
  <div>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
      <div class="container mx-auto px-6 py-8">
        <div class="product w-100 h-20 d-flex justify-content-around">
          <div class="product-card bg-white w-44 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md hover:scale-110 transition-all duration-300 flex justify-between items-center">
            <div class="content flex flex-col items-start">
              <h6 class="text-lg font-medium text-gray-800 mb-1">Categories</h6>
              <p class="text-gray-600 text-sm">{{count($Categories)}}</p>
            </div>
            <div class="icon">
              <i class='bx bxs-category text-yellow-500 text-3xl hover:text-4xl transition-all duration-400'></i>
            </div>
          </div>
          <div class="product-card bg-white w-44 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md flex justify-between items-center">
            <div class="content flex flex-col items-start">
              <h6 class="text-lg font-medium text-gray-800 mb-1">Services</h6>
              <p class="text-gray-600 text-sm">{{count($Service)}}</p>
            </div>
            <div class="icon">
              <i class='bx bxs-briefcase-alt-2 text-yellow-500 text-3xl'></i>
            </div>
          </div>
          <div class="product-card bg-white w-44 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md hover:scale-110 transition-all duration-300 flex justify-between items-center">
            <div class="content flex flex-col items-start">
              <h6 class="text-lg font-medium text-gray-800 mb-1">Top</h6>
              <p class="text-gray-600 text-sm">Services</p>
            </div>
            <div class="icon">
              <i class='bx bxs-star text-yellow-500 text-3xl hover:text-4xl transition-all duration-400'></i>
            </div>
          </div>
          <div class=" product-card bg-white w-44 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md hover:scale-110 transition-all duration-300 flex justify-between items-center">
            <div class="content flex flex-col items-start">
              <h6 class="text-lg font-medium text-gray-800 mb-1">Top</h6>
              <p class="text-gray-600 text-sm">Fixer</p>
            </div>
            <div class="icon">
              <i class='bx bx-crown text-yellow-500 text-3xl hover:text-4xl transition-all duration-400'></i>
            </div>
          </div>
          <div class=" product-card bg-white w-44 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md hover:scale-110 transition-all duration-300 flex justify-between items-center">
            <div class="content flex flex-col items-start">
              <h6 class="text-lg font-medium text-gray-800 mb-1">Users</h6>
              <p class="text-gray-600 text-sm">{{count($users)}}</p>
            </div>
            <div class="icon">
              <i class='bx bx-user text-yellow-500 text-3xl hover:text-4xl transition-all duration-400'></i>
            </div>
          </div>
        </div>
        <div class="data p-2 pt-4 row">
          <div class="left col-md-6">
            <!-- ----------------top service----------------- -->
            <section id="top-service">
              <div class="top-services bg-white p-3 rounded-lg shadow">
                <div class="title d-flex justify-content-between items-center mb-2">
                  <h6 class="text-lg font-medium text-gray-800 mb-1">Top Service</h6>
                </div>
                <div class="top-service-info p-3 flex flex-col space-y-2" style="height: 300px; overflow-y: scroll;">

                  <!-- ------------------------- -->
                  <div class="top-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                    <div class="title relative">
                      <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                      <div class="d-flex items-center">
                        <img src="https://i.pinimg.com/564x/c8/3f/05/c83f052eb98923de6edab81de2d6465b.jpg" class=" w-9 h-9 rounded-full shadow-md z-10">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;object-fit: cover;">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;object-fit: cover;">+99
                      </div>
                    </div>
                    <div class="evaluation">
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#topServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="999">
                      View more
                    </button>
                  </div>
                  <!-- ---------------------------------- -->
                  <!-- ------------------------- -->
                  <div class="top-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                    <div class="title relative">
                      <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                      <div class="d-flex items-center">
                        <img src="https://i.pinimg.com/564x/c8/3f/05/c83f052eb98923de6edab81de2d6465b.jpg" class=" w-9 h-9 rounded-full shadow-md z-10">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">+99
                      </div>
                    </div>
                    <div class="evaluation">
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#topServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="999">
                      View more
                    </button>
                  </div>
                  <!-- ---------------------------------- -->
                  <!-- ------------------------- -->
                  <div class="top-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                    <div class="title relative">
                      <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                      <div class="d-flex items-center">
                        <img src="https://i.pinimg.com/564x/c8/3f/05/c83f052eb98923de6edab81de2d6465b.jpg" class=" w-9 h-9 rounded-full shadow-md z-10">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">+99
                      </div>
                    </div>
                    <div class="evaluation">
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#topServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="999">
                      View more
                    </button>
                  </div>
                  <!-- ---------------------------------- -->
                  <!-- ------------------------- -->
                  <div class="top-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                    <div class="title relative">
                      <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                      <div class="d-flex items-center">
                        <img src="https://i.pinimg.com/564x/c8/3f/05/c83f052eb98923de6edab81de2d6465b.jpg" class=" w-9 h-9 rounded-full shadow-md z-10">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">+99
                      </div>
                    </div>
                    <div class="evaluation">
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#topServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="999">
                      View more
                    </button>
                  </div>
                  <!-- ---------------------------------- -->
                  <!-- ------------------------- -->
                  <div class="top-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                    <div class="title relative">
                      <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                      <div class="d-flex">
                        <img src="https://i.pinimg.com/564x/c8/3f/05/c83f052eb98923de6edab81de2d6465b.jpg" class=" w-9 h-9 rounded-full shadow-md z-10">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="  w-9 h-9 rounded-full shadow-md z-10" style="margin-left: -20px;">+99
                      </div>
                    </div>
                    <div class="evaluation items-center ">
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                      <i class='bx bxs-star text-yellow-500 text-xl hover:text-4xl transition-all duration-400'></i>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#topServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="999">
                      View more
                    </button>
                  </div>
                  <!-- ---------------------------------- -->
                </div>
              </div>
            </section>
            <!-- ----------------top service end----------------- -->
            <!-- ----------------low service----------------- -->
            <div class="low-services bg-white p-3 rounded-lg shadow mt-4">
              <div class="title">
                <h6 class="text-lg font-medium text-gray-800 mb-1">Low Service</h6>
              </div>
              <div class="low-service-info p-3 flex flex-col space-y-2" style="height: 300px; overflow-y: scroll;">
                <!-- ------------------------- -->
                <div class="low-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                  <div class="title relative">
                    <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                    <p class="text-red-600 text-sm">Nothing booking!</p>
                  </div>
                  <div class="evaluation">
                    <button class="btn btn-outline-warning btn-sm text-center" data-bs-toggle="modal" data-bs-target="#lowServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="0"><i class="bx bx-info-circle"></i>view more</button>
                  </div>
                </div>
                <!-- ---------------------------------- -->
                <!-- ------------------------- -->
                <div class="low-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                  <div class="title relative">
                    <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                    <p class="text-red-600 text-sm">Nothing booking!</p>
                  </div>
                  <div class="evaluation">
                    <button class="btn btn-outline-warning btn-sm " data-bs-toggle="modal" data-bs-target="#lowServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="0"><i class="bx bx-info-circle"></i>view more</button>
                  </div>
                </div>
                <!-- ---------------------------------- -->
                <!-- ------------------------- -->
                <div class="low-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                  <div class="title relative">
                    <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                    <p class="text-red-600 text-sm">Nothing booking!</p>
                  </div>
                  <div class="evaluation">
                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#lowServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="0"><i class="bx bx-info-circle"></i>view more</button>
                  </div>
                </div>
                <!-- ---------------------------------- -->
                <!-- ------------------------- -->
                <div class="low-service-card d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
                  <div class="title relative">
                    <p class="text-gray-800 font-medium text-sm">Air Conditioner Repair</p>
                    <p class="text-red-600 text-sm">Nothing booking!</p>
                  </div>
                  <div class="evaluation">
                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#lowServiceDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="0"><i class="bx bx-info-circle"></i>view more</button>
                  </div>
                </div>
                <!-- ---------------------------------- -->
              </div>
            </div>
            <!-- ----------------low service end----------------- -->
          </div>
          <div class="right col-md-6 p-3 pt-0 flex flex-col space-y-6">
            <div class="service-performent bg-white p-3 rounded-lg shadow" style="height: 270px;">
              <div class="title d-flex align-items-center justify-content-between">
                <h6 class="text-lg font-medium text-gray-800 mb-0">Services performent</h6>
                <div class="date-input">
                  <input type="date" class="form-control" placeholder="Select a date">
                  <i class="bi bi-calendar3"></i>
                </div>
              </div>
              <canvas id="myChart"></canvas>
            </div>
            <div class="top-than bg-white p-3 rounded-lg shadow " style="height:250px;">
              <div class="title">
                <h6 class="text-lg font-medium text-gray-800">Top Fixer</h6>
              </div>
              <div class="topthan-info d-flex justify-content-center">
                <!-- ...................................... -->
                <div class="card-top p-2 shadow-sm mx-2" style="width: 8rem; height: 11rem;">
                  <div class="d-flex justify-content-center">
                    <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="card rounded-circle" alt="..." style="height: 4rem; width: 4rem;object-fit: cover;">
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1" style="font-size:13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">uuuuuuuuuuuuuuuuuuu</h5>
                    <p class="card-text text-muted xs-font mb-2" style="font-size:12px;">99+ stars</p>
                    <div class="evaluation d-flex justify-content-center mb-2">
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                    </div>
                    <button class="btn btn-warning btn-sm btn-sm detail-button d-none"><small>View more</small></button>
                  </div>
                </div>
                <!-- ...................................... -->
                <!-- ...................................... -->
                <div class="card-top p-2 shadow-sm mx-2" style="width: 8rem; height: 11rem;">
                  <div class="d-flex justify-content-center">
                    <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="card rounded-circle" alt="..." style="height: 4rem; width: 4rem;object-fit: cover;">
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1" style="font-size:13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">uuuuuuuuuuuuuuuuuuu</h5>
                    <p class="card-text text-muted xs-font mb-2" style="font-size:12px;">99+ stars</p>
                    <div class="evaluation d-flex justify-content-center mb-2">
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                    </div>
                    <button class="btn btn-warning btn-sm btn-sm detail-button d-none"><small>View more</small></button>
                  </div>
                </div>
                <!-- ...................................... -->
                <!-- ...................................... -->
                <div class="card-top p-2 shadow-sm mx-2" style="width: 8rem; height: 11rem;">
                  <div class="d-flex justify-content-center">
                    <img src="https://i.pinimg.com/564x/68/e3/5f/68e35faf0dc4ff48db6592251a66112f.jpg" class="card rounded-circle" alt="..." style="height: 4rem; width: 4rem;object-fit: cover;">
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title fw-bold mb-1" style="font-size:13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">uuuuuuuuuuuuuuuuuuu</h5>
                    <p class="card-text text-muted xs-font mb-2" style="font-size:12px;">99+ stars</p>
                    <div class="evaluation d-flex justify-content-center mb-2">
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                      <i class='bx bxs-star text-warning fs-6 me-1'></i>
                    </div>
                    <button class="btn btn-warning btn-sm btn-sm detail-button d-none"><small>View more</small></button>
                  </div>
                </div>
                <!-- ...................................... -->

              </div>

            </div>
            <!-- ----------------Customer feedback----------------- -->
            <div class="customer-feedback bg-white p-3 rounded-lg shadow mt-4">
              <div class="title">
                <h6 class="text-lg font-medium text-gray-800 mb-1">Customer feedback</h6>
              </div>
              <div class="customer-feedback-info p-3 flex flex-col gap-3 space-y-2" style="height: 200px; overflow-y: scroll;">
                <!-- ------------------------- -->
                @if ( count ($feedbacks) == 0)
                <div class="feedback mt-12" style="text-align: center;">
                  Nothing Feedback from Customer
                </div>
                
                @endif
                @foreach ($feedbacks as $feedback)
                @php
                $user = $users->where('id',$feedback->user_id)->first()
                @endphp
                <div class="customer-feedback-card d-flex justify-content-between items-center p-2 rounded-lg h-12 shadow-md hover:scale-105 transition-all duration-300">
                  <img src="{{$user->profile}}" class="card rounded-circle" alt="..." style="height: 2rem; width: 2rem;">
                  <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                    <h5 class="card-title fw-bold mb-0" style="font-size:13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$user->name}}</h5>
                    <p class="text-gray-600 text-sm truncate-text" style="font-size:10px;">
                      {{$feedback->content}}
                    </p>
                  </div>
                  <div class="evaluation">
                    <button class="btn btn-outline-warning btn-sm text-center" data-bs-toggle="modal" data-bs-target="#feedbackDetail" data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg" data-service-title="Premium Service" data-service-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat." data-service-stars="0" data-feedback-image="{{ $user->profile }}" data-feedback-name="{{ $user->name }}" data-feedback-content="{{ $feedback->content }}"><i class="bx bx-love"></i>view more</button>
                    @can('Feedback delete')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $feedback->id }})">Delete</button>

                    <!-- JavaScript for confirmation dialog -->
                    <script>
                    function confirmDelete(id) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Perform the delete action by submitting the form
                                document.getElementById(`delete-form-${id}`).submit();
                            }
                        });
                    }
                    </script>

                    <!-- Form for deletion -->
                    <form id="delete-form-{{ $feedback->id }}" action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('delete')
                    </form>
                @endcan

                  </div>
                </div>
                <!-- ---------------------------------- -->
                @endforeach
              </div>
            </div>
            <!-- ---------------- customer feedback end----------------- -->
          </div>
          <div class="data -pr-3 mt-4">
            <iframe class="map bg-white  rounded-lg shadow" style='height:250px;' src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d31273.788411035468!2d104.88050064999999!3d11.5358151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2skh!4v1719023181034!5m2!1sen!2skh" width="930" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

    </main>
  </div>
  </div>
<!-- Example CDN includes for SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- ---------------------top service detail------------------ -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <div class="modal fade" id="lowServiceDetail" tabindex="-1" aria-labelledby="lowServiceDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="lowServiceDetailLabel">Low Service detail</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <img src="" class="img-fluid rounded" alt="Service Image" id="service-image">
            </div>
            <div class="col-md-6">
              <h4 class="text-warning" id="service-title">Premium Service</h4>
              <p id="service-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat.</p>
              <p>Stars: <span id="service-star"></span></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ----------------low service-------------------------------- -->
  <div class="modal fade" id="topServiceDetail" tabindex="-1" aria-labelledby="topServiceDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="topServiceDetailLabel">Top Service detail</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <img src="" class="img-fluid rounded" alt="Service Image" id="service-image">
            </div>
            <div class="col-md-6">
              <h4 class="text-warning" id="service-title">Premium Service</h4>
              <p id="service-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat.</p>
              <p>Stars: <span id="service-star"></span></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ------------end low service detail ------------------------ -->

  <!-- ---------------- feedback-------------------------------- -->
  <div class="modal fade" id="feedbackDetail" tabindex="-1" aria-labelledby="feedbackDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom-width">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="topfeedbackDetailLabel">Feedback detail</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <img src="" class="img-fluid rounded" alt="feedback Image" id="feedback-image">
            </div>
            <div class="col-md-6">
              <h4 class="text-warning" id="feedback-name"></h4>
              <p id="feedback-content"></p>
            </div>
          </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-sm" style="background-color: red;">Delete</button>
        </div> -->
      </div>
    </div>
  </div>

  <!-- ------------ low feedback detail ------------------------ -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
  <script>
    // ......................graph building....................
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Booking', 'Users', 'Love', 'Six', 'Fap', 'Kiss'],
        datasets: [{
          label: '# of perform',
          data: [9, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // -------------detail data--------------------------

    // Get the modal
    var model_topservice = document.getElementById('topServiceDetail');
    var model_lowservice = document.getElementById('lowServiceDetail');

    // Get the button that opens the model_topservice
    var btn_topservice = document.querySelectorAll('[data-bs-target="#topServiceDetail"]');
    var btn_lowservice = document.querySelectorAll('[data-bs-target="#lowServiceDetail"]');

    // When the user clicks the button, update the model_topservice content
    btn_topservice.forEach(function(button) {
      button.addEventListener('click', function() {
        var serviceImage = this.getAttribute('data-service-image');
        var serviceTitle = this.getAttribute('data-service-title');
        var serviceDescription = this.getAttribute('data-service-description');
        var servoceStars = this.getAttribute('data-service-stars');

        model_topservice.querySelector('#service-image').src = serviceImage;
        model_topservice.querySelector('#service-title').textContent = serviceTitle;
        model_topservice.querySelector('#service-description').textContent = serviceDescription;
        model_topservice.querySelector('#service-star').textContent = servoceStars;
      });
    });

    btn_lowservice.forEach(function(button) {
      button.addEventListener('click', function() {
        var serviceImage = this.getAttribute('data-service-image');
        var serviceTitle = this.getAttribute('data-service-title');
        var serviceDescription = this.getAttribute('data-service-description');
        var servoceStars = this.getAttribute('data-service-stars');

        model_lowservice.querySelector('#service-image').src = serviceImage;
        model_lowservice.querySelector('#service-title').textContent = serviceTitle;
        model_lowservice.querySelector('#service-description').textContent = serviceDescription;
        model_lowservice.querySelector('#service-star').textContent = servoceStars;
      });
    });

    /// feedback////

    document.getElementById('feedbackDetail').addEventListener('show.bs.modal', function(event) {

      var button = event.relatedTarget;

      document.getElementById('feedback-image').src = button.dataset.feedbackImage;
      document.getElementById('feedback-name').textContent = button.dataset.feedbackName;
      document.getElementById('feedback-content').textContent = button.dataset.feedbackContent;


    });
  </script>
  @if(session('showAlertDelete'))
<script>
    Swal.fire({
        title: "User's eedback deleted Success!",
        text: '{{ session("success") }}',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff9800',
        showCloseButton: true,
    });
</script>
@endif
  <style>
    .card-top:hover .detail-button {
      display: inline-block !important;
    }

    .card-top {
      width: 8rem;
      height: 11rem;
      transition: all 0.3s ease-in-out;
    }

    .card-top:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .product-card {
      transition: all 0.3s ease-in-out;
    }

    .product-card:hover {
      transform: scale(1.1);
      background-color: #f5f5f5;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .product-card .icon i {
      transition: all 0.1s ease-in-out;
    }

    .product-card:hover .icon i {
      font-size: 2rem;
    }

    /* Custom CSS for modal dialog width */
    .modal-custom-width {
      max-width: 600px;
    }

    .truncate-text {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* Tablet styles */
    @media (max-width: 991px) and (min-width: 768px) {
      .product-card {
        width: 9rem;
        transition: all 0.3s ease-in-out;
      }

      .top-service-card {
        transition: all 0.3s ease-in-out;
      }

      .top-service-card .evaluation i {
        font-size: 0.6rem;
      }

      .top-service-card button {
        font: 0.5em sans-serif;
        margin-top: 4rem;
      }


      .low-service-card button {
        font: 0.5em sans-serif;
      }

      .low-service-card {
        transition: all 0.3s ease-in-out;
      }

      .card-top {
        width: 8rem;
        height: 11rem;
        transition: all 0.3s ease-in-out;
      }

      .topthan-info {
        overflow-y: auto;
        height: 300px !important;
        padding-left: 140px;
      }

      .top-than {
        height: 270px !important;
      }

      .customer-feedback-card button {
        font: 0.5em sans-serif;
      }

      .map {
        width: 650px;
      }

      .bx-menu {
        display: block;
      }

    }

    /* Mobile styles */
    @media (max-width: 320px) and (min-width:568px) {

      .product-card {
        justify-Content: space-around;
        gap: 2rem;
        width: 5rem;
        height: 2rem;
        transition: all 0.1s ease-in-out;
        font-size: 5px;
      }

      .product-card .content h6 {
        font-size: 0.5rem;
        margin: 0;
      }

      .product-card .content p {
        justify-Content: space-between;
        font-size: 0.5rem;
        margin: 0;
        margin-top: -10px;
      }

      .product-card .icon i {
        font-size: 2rem;
        margin-left: -20px;
        font-size: 1.5rem;
      }

      .product-card .icon .bxs-briefcase-alt-2 {
        font-size: 1.5rem;
        margin-left: -20px;
      }

      .product-card .icon .bxs-star {
        font-size: 1.5rem;
        margin-left: -30px;
      }

      .product-card .content {
        margin-left: -15px;
      }

      .product {
        overflow-x: auto;
      }

      .product {
        margin-top: -20px;
      }

      .data {
        margin-top: -40px;
      }

      .top-services {
        width: 290px;
        margin-left: -20px;
      }

      .top-service-card {
        width: 270px;
        transition: all 0.3s ease-in-out;
        margin: 0px;
        margin-left: -20px;
      }

      .top-service-card .evaluation i {
        font-size: 0.9rem;
      }

      .top-service-card button {
        font: 0.5em sans-serif;
        margin-top: 2rem;
      }

      .top-service-card .title .d-flex img {
        width: 1.5rem !important;
        height: 1.5rem !important;
      }

      .top-service-card .title .d-flex {
        font-size: 1rem !important;
      }

      .top-service-info {
        width: 300px;
      }


      .low-services {
        width: 290px;
        margin-left: -20px;
      }

      .low-service-card {
        width: 270px;
        transition: all 0.3s ease-in-out;
        margin: 0px;
        margin-left: -20px;
      }

      .low-service-card button {
        font: 0.5em sans-serif;
        margin-top: 2rem;
      }

      .service-performent {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
        height: 200px;
      }

      .service-performent .title h6 {
        font-size: 15px;
      }

      .top-than {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
      }

      .card-top {
        width: 8rem;
        height: 11rem;
        transition: all 0.3s ease-in-out;
      }

      .topthan-info {
        overflow-y: auto;
        height: 300px !important;
        padding-left: 140px;
      }

      .top-than {
        height: 270px !important;
      }

      .customer-feedback {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
      }

      .customer-feedback-card button {
        font: 0.5em sans-serif;
      }

      .map {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
        height: 10rem !important;
        margin-top: -20px;
      }

    }

    /* Mobile styles */
    @media (max-width: 600px) {


      .product-card {
        justify-Content: space-around;
        gap: 2rem;
        width: 5rem;
        height: 2rem;
        transition: all 0.1s ease-in-out;
        font-size: 5px;
      }

      .product-card .content h6 {
        font-size: 0.5rem;
        margin: 0;
      }

      .product-card .content p {
        justify-Content: space-between;
        font-size: 0.5rem;
        margin: 0;
        margin-top: -10px;
      }

      .product-card .icon i {
        font-size: 2rem;
        margin-left: -20px;
        font-size: 1.5rem;
      }

      .product-card .icon .bxs-briefcase-alt-2 {
        font-size: 1.5rem;
        margin-left: -20px;
      }

      .product-card .icon .bxs-star {
        font-size: 1.5rem;
        margin-left: -30px;
      }

      .product-card .content {
        margin-left: -15px;
      }

      .product {
        overflow-x: auto;
      }

      .product {
        margin-top: -20px;
      }

      .data {
        margin-top: -40px;
      }

      .top-services {
        width: 340px;
        margin-left: -20px;
      }

      .top-service-card {
        width: 310px;
        transition: all 0.3s ease-in-out;
        margin: 0px;
        margin-left: -20px;
      }

      .top-service-card .evaluation i {
        font-size: 0.9rem;
      }

      .top-service-card button {
        font: 0.5em sans-serif;
      }

      .top-service-card .title .d-flex img {
        width: 1.5rem !important;
        height: 1.5rem !important;
      }

      .top-service-card .title .d-flex {
        font-size: 1rem !important;
      }

      .top-service-info {
        width: 300px;
      }


      .low-services {
        width: 340px;
        margin-left: -20px;
      }

      .low-service-card {
        width: 310px;
        transition: all 0.3s ease-in-out;
        margin: 0px;
        margin-left: -20px;
      }

      .low-service-card button {
        font: 0.5em sans-serif;
        margin-top: 2rem;
      }

      .service-performent {
        margin-top: 20px;
        width: 310px;
        margin-left: -20px;
        height: 200px;
      }

      .service-performent .title h6 {
        font-size: 15px;
      }

      .top-than {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
      }

      .card-top {
        width: 8rem;
        height: 11rem;
        transition: all 0.3s ease-in-out;
      }

      .topthan-info {
        overflow-y: auto;
        height: 300px !important;
        padding-left: 140px;
      }

      .top-than {
        height: 270px !important;
      }

      .customer-feedback {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
      }

      .customer-feedback-card button {
        font: 0.5em sans-serif;
      }

      .map {
        margin-top: 20px;
        width: 290px;
        margin-left: -20px;
        height: 10rem !important;
        margin-top: -20px;
      }

    }
  </style>
</x-app-layout>