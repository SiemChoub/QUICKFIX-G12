<x-app-layout>
  <div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
      <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Welcome: {{ auth()->user()->name }}</h3>
        <div class="left">
          <div class="image-container">
            <img src="https://i.pinimg.com/564x/58/b6/52/58b6528f3b6c1b77a119f9efc2ef8f61.jpg" alt="Your Image">
            <div class="img">
              <img src="https://i.pinimg.com/originals/61/54/18/61541805b3069740ecd60d483741e5bb.jpg" alt="camera" onclick=showFileInput()>
            </div>
            <input type="file" id="thumbnailprev" style="display: none;">
            <h1 id="hi"></h1>
          </div>
        </div>
        <div class="right">
          <div class="left2">
            <div class="info">

              <label>Id:</label>
              <span class="info-value">{{ auth()->user()->id }}</span>
              <label>Role:</label>
              <span class="info-value">{{ auth()->user()->role }}</span>
            </div>
            <div class="info">
              <label>User Name:</label>
              <span class="info-value">{{ auth()->user()->name }}</span>
            </div>
            <div class="info">
              <label>Email:</label>
              <span class="info-value">{{ auth()->user()->email }}</span>
            </div>
            <div class="info">
              <label>Phone Number:</label>
              <span class="info-value">{{auth()->user()->phone}} </span>
            </div>
            <div class="info">
              <label>Create Date:</label>
              <span class="info-value">{{ auth()->user()->created_at->format('Y-m-d') }}</span>
            </div>
            <div class="info">
              <label>Create Time:</label>
              <span class="info-value">{{ auth()->user()->created_at->format('H:i:s') }}</span>
            </div>
          </div>
          <!-- Modal -->
          <button type="button" class="btn" style="background-color: gray;"><a href="{{route('admin.dashboard')}}">Back</a></button>
          <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#exampleModal">
            Edit information
          </button>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title" id="exampleModalLabel">Edit Profile</h1>
                </div>
                <div class="modal-body">
                  <form id="updateForm" ref="form">
                    <div class="mb-3">
                      <label for="role" class="form-label">Role:</label>
                      <select class="form-control" id="role">
                        <option value="User" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="Admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Fixer" {{ $user->role == 'fixer' ? 'selected' : '' }}>Fixer</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="username" class="form-label">User Name:</label>
                      <input type="text" class="form-control" id="username" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="mb-3">
                      <label for="phone" class="form-label">Phone Number:</label>
                      <input type="tel" class="form-control" id="phone" value="{{auth()->user()->phone}}">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <div type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</div>
                  <div type="button" style="background-color: orange;" class="btn" id="updateBtn" onclick="updateUser(1)">Update</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </div>
  </main>
  </div>
</x-app-layout>

<script>
  function showFileInput() {
    var fileInput = document.getElementById("thumbnailprev");
    fileInput.click();
    fileInput.addEventListener("change", function() {
      var fileName = fileInput.value.split("\\").pop();
      document.getElementById("hi").textContent = fileName;
    });
    
    
  }
  function updateUser(id) {
    console.log(id);
    console.log("Updating user");
    // var id = document.getElementById("id").value;
  var role = document.getElementById("role").value;
  var username = document.getElementById("username").value;
  var phone = document.getElementById("phone").value;
  var body ={
    role: role,
    name: username,
    phone: phone,
    
  }
  console.log(body);
  // var formData = new FormData();
  // formData.append('role', role);
  // formData.append('name', username);
  // formData.append('email', email);
  // formData.append('phone', phone);
  // console.log("Data",formData);
  fetch(`/admin/update/${id}`, {
      method: 'PUT',
      body: body,
    })
    .then(function(response) {
      if (response.ok) {
        return response.json();
      }
      throw new Error('Network response was not ok.');
    })
    .then(function(data) {
      // Handle the success response
      console.log('User updated successfully:', data);
      // Optionally, you can show a success message or redirect to another page
      window.location.reload(); // Reload the page to reflect the updated user information
    })
    .catch(function(error) {
      // Handle errors
      console.error('Error updating user:', error);
    });
}
</script>
<style>
  .left {
    background-color: #D9D9D9;
    float: left;
    width: 40%;
    height: 380px;
  }

  .image-container {
    position: relative;
    display: inline-block;
  }

  .img {
    position: absolute;
    bottom: 30px;
    right: 0;
    width: 22%;
    height: 22%;
    margin-right: 33%;
  }

  .right button {
    border: 1px solid orange;
    padding: 5px 10px;
    margin-top: 55%;
    background: orange;
    border-radius: 5px;
  }

  .right {
    background-color: #D9D9D9;
    padding-top: 10px;
    float: right;
    width: 60%;
    height: 380px;
  }

  .left img {
    max-width: 50%;
    height: auto;
    display: block;
    margin-left: 80px;
    margin-top: 70px;
    border-radius: 15px;
    cursor: pointer;
  }

  .left2 {
    float: left;
    width: 50%;
    height: 100%;
    padding-top: 7%;
  }

  .left2 label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  .info {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .exampleModal {
    height: auto;
  }

  .info label {
    width: 120px;
    margin-top: 5px;
  }

  .info-value {
    flex: 1;
    text-align: start;
    margin-left: 10px;
  }

  .right2 {
    background: #000;
  }
</style>