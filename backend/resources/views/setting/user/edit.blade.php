<x-app-layout>
  <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100" style="margin-top:90px"> 
    <div class="container mx-auto px-4 mt-4 py-1 pb-16">
      <div class="flex justify-between items-center mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-warning shadow flex items-center border -mt-2 mb-1 border-none hover:bg-warning-600 transition-colors">
          <i class="bx bx-arrow-back mr-2 animate-pulse"></i>
          Back
        </a>
        <h1 class="text-xl text-warning shadow p-1 ">EDIT USER</h1>
      </div>
      <div class=" shadow-md rounded p-3 pt-2">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class='shadow bg-white p-7 border around mb-4'>
            <div class="space-y-3">
              <div class="qf-profile-upload">
                <img id="profilePreview"
                     src="{{ $user->profile ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f59e0b&color=fff&bold=true' }}"
                     onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f59e0b&color=fff&bold=true'"
                     alt="Profile photo" class="qf-profile-upload__img">
                <div class="qf-profile-upload__body">
                  <label for="profile" class="text-gray-700 font-medium text-sm">Profile photo</label>
                  <input id="profile" type="file" name="profile" accept="image/*" class="qf-profile-upload__input">
                  <p class="qf-profile-upload__hint">JPG or PNG, up to 2 MB. Leave empty to keep the current photo.</p>
                  @error('profile')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>
              </div>
              <div>
                <label for="name" class="text-gray-700 font-medium text-sm">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter name" class="w-full px-3 py-1 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 text-sm" />
              </div>
              <div>
                <label for="email" class="text-gray-700 font-medium text-sm">email</label>
                <input id="email" type="text" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email" class="w-full px-3 py-1 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 text-sm" />
              </div>
              <div class="grid grid-cols-3 gap-3">
              <div>
                <label for="phone" class="text-gray-700 font-medium text-sm">phone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter phone" class="w-full px-3 py-1 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 text-sm" />
              </div>
              <div>
                <label for="address" class="text-gray-700 font-medium text-sm">address</label>
                <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Enter address" class="w-full px-3 py-1 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 text-sm" />
              </div>
                <div class="form-group">
                <label for="role" class="block text-gray-700 font-medium mb-1 text-sm">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="">Select a Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{$user->role == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-6">
            <button type="submit" class="bg-warning shadow hover:bg-warning-600 font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-warning-500 focus:ring-opacity-50 transition-colors">
              <svg class="w-4 h-4 mr-2 inline-block animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script>
  (function () {
    const input = document.getElementById('profile');
    const preview = document.getElementById('profilePreview');
    if (input && preview) {
      input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) preview.src = URL.createObjectURL(file);
      });
    }
  })();
</script>
  <style>
    .qf-profile-upload { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .qf-profile-upload__img {
      width: 84px; height: 84px; border-radius: 50%; object-fit: cover;
      border: 3px solid #ffc107; box-shadow: 0 4px 12px rgba(0, 0, 0, .1); background: #f3f4f6;
    }
    .qf-profile-upload__body { display: flex; flex-direction: column; gap: .25rem; }
    .qf-profile-upload__input { font-size: .85rem; color: #4b5563; }
    .qf-profile-upload__input::file-selector-button {
      margin-right: .6rem; padding: .4rem .8rem; border: 0; border-radius: 8px;
      background: #ffc107; color: #1b1f24; font-weight: 600; font-size: .82rem; cursor: pointer;
      transition: filter .15s ease;
    }
    .qf-profile-upload__input::file-selector-button:hover { filter: brightness(.95); }
    .qf-profile-upload__hint { font-size: .72rem; color: #9ca3af; margin: 0; }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.2);
      }
    }

    .animate-pulse {
      animation: pulse 1s ease-in-out infinite;
    }
  </style>
</x-app-layout>