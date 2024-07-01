<!-- resources/views/profile.blade.php -->

<x-app-layout>
  <!-- Bootstrap and Font Awesome CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <style>
      body {
          background-color: #f8f9fa;
      }

      .card-custom {
          border: none;
          border-radius: 15px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .hover-zoom:hover {
          transform: scale(1.05);
          transition: transform 0.3s;
      }

      .hover-glow:hover {
          box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
          transition: box-shadow 0.3s;
      }

      .hover-fade:hover {
          opacity: 0.9;
          transition: opacity 0.3s;
      }

      .btn-custom {
          border-radius: 30px;
          transition: all 0.3s;
      }

      .btn-custom:hover {
          transform: translateY(-2px);
      }

      .card-header-custom {
          background-color: #343a40;
          color: #ffffff;
          border-top-left-radius: 15px;
          border-top-right-radius: 15px;
          padding: 15px 20px;
          font-size: 1.25rem;
      }

      .card-body-custom {
          padding: 30px 20px;
      }

      .img-thumbnail-custom {
          border-radius: 15px;
          cursor: pointer;
      }

      .icon-button {
          font-size: 1.25rem;
      }
  </style>

  <!-- Main content -->
  <main class="flex-1">
      <div class="container mt-4">
          <!-- Back button -->
          <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-custom me-2 hover-fade">
              <i class="bx bx-arrow-back me-2"></i>Back
          </a>
          
          <!-- Welcome message -->
          <div class="text-center mb-3">
              <h5 class="text-primary display-7 font-weight-bold">
                  Welcome, {{ auth()->user()->name }}!
              </h5>
          </div>
          
          <div class="row">
              <!-- Profile Image Section -->
              <div class="col-lg-4 mb-4">
                  <div class="card card-custom hover-glow">
                      <div class="card-body text-center d-flex flex-column justify-content-center">
                          <div class="mb-3 d-flex flex-col">
                              @php
                                  // Check if the authenticated user has a profile image
                                  $profileImage = auth()->user()->profile;
                                  $defaultImage = 'https://static.vecteezy.com/system/resources/thumbnails/037/336/395/small_2x/user-profile-flat-illustration-avatar-person-icon-gender-neutral-silhouette-profile-picture-free-vector.jpg';
                              @endphp

                              <img src="{{ $profileImage ? asset($profileImage) : asset($defaultImage) }}" 
                                   alt="Profile Image" 
                                   class="img-thumbnail img-thumbnail-custom" 
                                   style="height: 270px;"
                                   id="profileImage"> <!-- Add id for updating image -->
                               
                              <!-- Camera icon for selecting new profile image -->
                              <div class="img d-flex justify-content-center">
                                  <img src="https://i.pinimg.com/originals/61/54/18/61541805b3069740ecd60d483741e5bb.jpg" 
                                       alt="camera" 
                                       onclick="document.getElementById('thumbnailprev').click()" 
                                       class="img-thumbnail img-thumbnail-custom hover-zoom" 
                                       style="height: 50px;margin-top:-40px;">
                              </div>

                              <!-- Hidden file input for uploading new profile image -->
                              <input type="file" id="thumbnailprev" style="display: none;" onchange="displaySelectedImage(this)">
                          </div>
                      </div>
                  </div>
              </div>
              
              <!-- Profile Information Section -->
              <div class="col-lg-8">
                  <div class="card card-custom hover-glow">
                      <div class="card-header card-header-custom">Profile Information</div>
                      <div class="card-body card-body-custom">
                          <div class="row mb-3">
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">Role:</label>
                                  <span>{{ auth()->user()->role }}</span>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">User Name:</label>
                                  <span>{{ auth()->user()->name }}</span>
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">Email:</label>
                                  <span>{{ auth()->user()->email }}</span>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">Phone Number:</label>
                                  <span>{{ auth()->user()->phone }}</span>
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">Create Date:</label>
                                  <span>{{ auth()->user()->created_at->format('Y-m-d') }}</span>
                              </div>
                          </div>
                          <div class="row mb-3">
                              <div class="col-md-6">
                                  <label class="form-label fw-bold">Create Time:</label>
                                  <span>{{ auth()->user()->created_at->format('H:i:s') }}</span>
                              </div>
                          </div>
                          <div class="d-flex justify-content-end mt-4">
                              <!-- Edit Information Button -->
                              <button type="button" class="btn btn-warning btn-custom hover-fade" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                  <i class="fas fa-edit icon-button"></i> Edit Information
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Edit Profile Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="updateForm" ref="form">
                          <div class="mb-3">
                              <label for="username" class="form-label">User Name:</label>
                              <input type="text" class="form-control" id="username" value="{{ auth()->user()->name }}">
                          </div>
                          <div class="mb-3">
                              <label for="phone" class="form-label">Phone Number:</label>
                              <input type="tel" class="form-control" id="phone" value="{{ auth()->user()->phone }}">
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-custom hover-fade" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary btn-custom hover-fade" id="updateBtn" onclick="updateUser(1)">Update</button>
                  </div>
              </div>
          </div>
      </div>
  </main>

  <!-- Bootstrap JavaScript Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Your custom scripts -->
  <script>
      function showFileInput() {
          document.getElementById('thumbnailprev').click();
      }

      function displaySelectedImage(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  document.getElementById('profileImage').src = e.target.result;
              }
              reader.readAsDataURL(input.files[0]); // Convert to base64 string
          }
      }

      function updateUser(userId) {
          // Your update logic here
          console.log('Updating user with ID:', userId);
      }
  </script>
</x-app-layout>
