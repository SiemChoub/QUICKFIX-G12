<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">
        <span class="panel"><i class="bx bxl-bootstrap"></i>Admin Panel</span>
      </a>
      <div class="d-flex align-items-center">
      <div data-bs-toggle="modal" data-bs-target="#messageModal">
        <a class=" nav-link dropdown-toggle" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bx bx-mail-send"></i>
          <span class="badge bg-warning rounded-pill">5</span>
        </a>
      </div>
      <div class="dropdown ms-3">
        <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bx bx-bell"></i>
          <span class="badge bg-danger rounded-pill">18+</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="notificationsDropdown" style="width: 400px; max-height: 400px; overflow-y: auto;">
          <div class="notification-list space-y-2" style="height: 300px; overflow-y: scroll;">
            <a href="#" class="dropdown-item d-flex border border-warning justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 1</h5>
                <p class="text-600 fw-bold text-sm truncate" style="font-size:10px;">This is the first notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
            <a href="#" class="dropdown-item d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 2</h5>
                <p class="text-gray-600 text-sm truncate" style="font-size:10px;">This is the second notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
            <a class="dropdown-item d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 3</h5>
                <p class="text-gray-600 text-sm truncate" style="font-size:10px;">This is the third notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
            <a class="dropdown-item d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 3</h5>
                <p class="text-gray-600 text-sm truncate" style="font-size:10px;">This is the third notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
            <a href="#" class="dropdown-item d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 3</h5>
                <p class="text-gray-600 text-sm truncate" style="font-size:10px;">This is the third notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
            <a href="#" class="dropdown-item d-flex justify-content-between items-center p-2 rounded-lg shadow-md hover:scale-105 transition-all duration-300">
              <div class="title relative w-50 d-flex flex-col align-item-center pt-2">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:13px;">Notification 3</h5>
                <p class="text-gray-600 text-sm truncate" style="font-size:10px;">This is the third notification.</p>
              </div>
              <div class="evaluation">
                <button class="btn btn-outline-warning btn-sm text-center" style="font-size:10px;">
                  <i class="bx bx-info-circle"></i>
                  View Details
                </button>
              </div>
            </a>
          </div>
        </ul>
      </div>
  <div class="dropdown ms-3">
  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  <img src="{{ auth()->user()->profile }}" class="rounded-circle me-2" alt="Profile Picture" style="width: 40px; height: 40px; object-fit: cover;">    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="profileDropdown" style="width: 200px;">
    <li>
      <a href="{{ route('admin.profile') }}" class="dropdown-item d-flex align-items-center py-2 rounded-lg hover:bg-gray-100 transition-colors duration-300">
        <i class="bx bx-user text-warning me-2"></i>
        <span class="text-gray-800">Profile</span>
      </a> 
    </li>
    <li>
      <a href="#" class="dropdown-item d-flex align-items-center py-2 rounded-lg hover:bg-gray-100 transition-colors duration-300">
        <i class="bx bx-cog text-secondary me-2"></i>
        <span class="text-gray-800">Settings</span>
      </a>
    </li>
    <li>
        {{-- <span class="text-gray-800">Logout {{route('admin.logout')}}</span> --}}
        {{-- <form  action="{{route('admin.logout')}}" method="POST"></form> --}}
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
              <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                          this.closest('form').submit();"
              class="dropdown-item d-flex align-items-center py-2 rounded-lg hover:bg-gray-100 transition-colors duration-300">        <i class="bx bx-log-out text-danger me-2">  logout</i>
            </a>
          </form>
      </a>
    </li>
  </ul>
</div>
<i class='bx bx-menu' style='color:#f7f7f7;display:none;'></i>
      </div>
    </div>
  </nav>
</header>
<!-- ---------------------top service detail------------------ -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white h-3">
        <h5 class="modal-title" id="messageModalLabel">Messaging</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- User List -->
          <div class="col-md-4 border-end ">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
              <button class="btn btn-warning" type="button" id="button-addon2"><i class="bx bx-search"></i></button>
            </div>
            <div class="d-flex justify-content-around mb-2">
              <a href="#" class="btn-hover-border-bottom">Show All</a>
              <a href="#" class="btn-hover-border-bottom">Fixer</a>
              <a href="#" class="btn-hover-border-bottom">Customer</a>
            </div>
            <div class="list-group d-flex gap-3" id="userList" style="height: 430px; overflow-y: auto;">
              <!-- Example User List Item -->
                <!-- --------------------------------- -->
                  <div class=" btn message-card rounded-lg p-3 shadow-md hover:scale-105 transition-all">
                    <div class="d-flex items-center">
                      <div class="position-relative">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="rounded-circle" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success border border-light rounded-circle">
                          <span class="visually-hidden">Online</span>
                        </span>
                      </div>
                      <div class="flex-grow-1 text-start ms-3">
                        <h5 class="card-title font-bold mb-1" style="font-size:0.875rem;">Chhaiya Sophorn</h5>
                        <p class="text-gray-600 mb-0 truncate" style="font-size:0.75rem;">Fix lerng kop mg b o jol jit😋</p>
                      </div>
                      <span class="text-white rounded px-2 py-1 ms-3 mr-6" style="font-size:2em;">👷‍♂️</span>
                      <p class="text-gray-600 mb-0" style="font-size:0.75rem;">7/8/2025</p>
                    </div>
                  </div>
                <!-- -------------------------------- -->
                <!-- --------------------------------- -->
                  <div class="btn message-card rounded-lg p-3 shadow-md hover:scale-105 transition-all">
                    <div class="d-flex items-center">
                      <div class="position-relative">
                        <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="rounded-circle" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success border border-light rounded-circle">
                          <span class="visually-hidden">Online</span>
                        </span>
                      </div>
                      <div class="flex-grow-1 text-start ms-3">
                        <h5 class="card-title font-bold mb-1" style="font-size:0.875rem;">Chhaiya Sophorn</h5>
                        <p class="text-gray-600 mb-0 truncate" style="font-size:0.75rem;">Fix lerng kop mg b o jol jit😋</p>
                      </div>
                      <span class="bg-warning text-white rounded px-2 py-1 ms-3 mr-6" style="font-size:0.50rem;">Customer</span>
                      <p class="text-gray-600 mb-0" style="font-size:0.75rem;">7/8/2025</p>
                    </div>
                  </div>
                <!-- -------------------------------- -->
                  <!-- Add more user items here -->
            </div>
          </div>
          <!-- Message Area -->
          <div class="col-md-8">
            <div class="d-flex align-items-center gap-3 p-2">
              <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="rounded-circle" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover;">
              <h5 class="card-title fw-bold mb-0 truncate" style="font-size:20px;">Chhaiya Sophorn</h5>
              <p class="bg-warning text-white text-sm truncate rounded -ml-2" style="font-size:11px;">Fixer</p>
            </div>
            <span class='text-info -mr-9'>Online</span>
            <div class='bg-light mb-3 p-3 d-flex' style="height: 370px; overflow-y: auto; border: 1px solid #ddd;">
            <div id="chatBox" class="d-flex flex-column justify-content-end" style='width:100%'>
              <!-- Conversation history will be appended here -->
               <div class="other d-flex flex-col gap-2">
                  <div class="d-flex align-items-center gap-2">
                    <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="rounded-circle" alt="Profile Image" style="height: 2rem; width: 2rem; object-fit: cover;">
                    <span class='bg-white p-2 rounded-lg'>Hello b</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <img src="https://i.pinimg.com/564x/99/7a/0f/997a0f428eb6e32f37b6ff0c7b863d0f.jpg" class="rounded-circle" alt="Profile Image" style="height: 2rem; width: 2rem; object-fit: cover;">
                    <span class='bg-white p-2 rounded-lg'>Hello b</span>
                  </div>
                </div>
                <!-- ----------------------- -->
                <div class="us d-flex flex-col gap-4">
                  <div class="text-end">
                    <span class='bg-info p-2 rounded-lg'>Hi o</span>
                  </div>
                  <div class="text-end">
                    <span class='bg-info p-2 rounded-lg'>Mean ka ey prozz pov</span>
                  </div>
                </div>
            </div>
            </div>
            <div class="input-group">
              <input type="text" id="messageInput" class="form-control" placeholder="Type a message">
              <div class="input-group-append">
                <button class="btn btn-warning" id="sendMessageButton" type="button">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>

/* Tablet styles */
@media (max-width: 991px) and (min-width: 768px) {

  .bx-menu{
    display:block;
    font: 3em sans-serif;
  }
}

/* Mobile styles */
@media (max-width: 767px) {
  .bx-menu{
    display:block;
    font: 2em sans-serif;
  }
  .navbar-brand{
    display:none;
  }

}

/* ............. */
.btn-hover-border-bottom {
  position: relative;
  padding-bottom: 2px; /* Add some padding to avoid overlap */
  font-size: 0.875rem; /* Adjust font size for smaller text */
  color: inherit;
  text-decoration: none;
}

.btn-hover-border-bottom::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 2px;
  background-color: currentColor;
  transform: scaleX(0);
  transform-origin: bottom right;
  transition: transform 0.2s ease-in-out;
}

.btn-hover-border-bottom:hover::after,
.btn-hover-border-bottom:focus::after {
  transform: scaleX(1);
  transform-origin: bottom left;
}

.message-card:focus, .message-card:active {
    background-color: #f0f0f0; /* Background color when card is focused or active */
    color: #333; /* Text color when card is focused or active */
  }
</style>