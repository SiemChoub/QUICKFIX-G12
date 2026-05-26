<x-app-layout>
  @php
    $u = auth()->user();
    $fallbackAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=f59e0b&color=fff&bold=true&size=256';
  @endphp

  <div class="qf-pp">
    {{-- Top bar --}}
    <div class="qf-pp-top">
      <a href="{{ route('admin.dashboard') }}" class="qf-pp-back"><i class='bx bx-arrow-back'></i> Back</a>
      <div class="qf-pp-heading">
        <h1>My Profile</h1>
        <p>Welcome back, {{ $u->name }}</p>
      </div>
    </div>

    <div class="qf-pp-grid">
      {{-- Avatar card --}}
      <div class="qf-pp-card qf-pp-avatar-card">
        <div class="qf-pp-avatar-wrap">
          <img id="profilePreview"
               src="{{ $u->profile ?: $fallbackAvatar }}"
               onerror="this.onerror=null;this.src='{{ $fallbackAvatar }}';"
               class="qf-pp-avatar" alt="{{ $u->name }}">
          <button type="button" class="qf-pp-cam" onclick="showFileInput()" title="Change photo">
            <i class='bx bx-camera'></i>
          </button>
        </div>
        <input type="file" id="thumbnailprev" accept="image/*" hidden>

        <h2 class="qf-pp-name">{{ $u->name }}</h2>
        <span class="qf-pp-role">{{ ucfirst($u->role) }}</span>

        <button id="saveProfileBtn" class="qf-pp-save" onclick="updateUserProfile({{ $u->id }})" disabled>
          <i class='bx bx-save'></i> <span>Save photo</span>
        </button>
        <p class="qf-pp-hint" id="saveHint">Tap the camera to choose a new photo</p>
      </div>

      {{-- Info card --}}
      <div class="qf-pp-card qf-pp-info-card">
        <div class="qf-pp-info-head">
          <span><i class='bx bx-id-card'></i> Profile Information</span>
          <button type="button" class="qf-pp-edit" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class='bx bx-edit'></i> Edit
          </button>
        </div>
        <div class="qf-pp-info-body">
          <dl class="qf-pp-fields">
            <div><dt><i class='bx bxs-user-detail'></i> Role</dt><dd>{{ ucfirst($u->role) }}</dd></div>
            <div><dt><i class='bx bx-user'></i> User name</dt><dd>{{ $u->name }}</dd></div>
            <div><dt><i class='bx bx-envelope'></i> Email</dt><dd>{{ $u->email }}</dd></div>
            <div><dt><i class='bx bx-phone'></i> Phone number</dt><dd>{{ $u->phone ?: '—' }}</dd></div>
            <div><dt><i class='bx bx-calendar'></i> Created date</dt><dd>{{ $u->created_at->format('d M Y') }}</dd></div>
            <div><dt><i class='bx bx-time-five'></i> Created time</dt><dd>{{ $u->created_at->format('H:i:s') }}</dd></div>
          </dl>
        </div>
      </div>
    </div>

    {{-- Edit modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content qf-pp-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class='bx bx-edit'></i> Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="updateForm">
              <div class="qf-pp-field">
                <label for="username">User name</label>
                <input type="text" id="username" value="{{ $u->name }}" placeholder="Your name">
              </div>
              <div class="qf-pp-field">
                <label for="email">Email</label>
                <input type="email" id="email" value="{{ $u->email }}" placeholder="Your email">
              </div>
              <div class="qf-pp-field">
                <label for="phone">Phone number</label>
                <input type="tel" id="phone" value="{{ $u->phone }}" placeholder="Your phone number">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="qf-btn qf-btn-ghost" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="qf-btn qf-btn-primary" id="updateBtn" onclick="updateUser({{ $u->id }})">
              <i class='bx bx-check'></i> Update
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .qf-pp { max-width: 1000px; margin: 0 auto; padding: 1.5rem 1rem 2.5rem; }

    /* Top bar */
    .qf-pp-top { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .qf-pp-back {
      display: inline-flex; align-items: center; gap: .4rem;
      padding: .5rem .9rem; border-radius: 10px;
      background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff;
      font-weight: 600; font-size: .9rem; text-decoration: none;
      box-shadow: 0 4px 12px rgba(245, 158, 11, .28);
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .qf-pp-back:hover { transform: translateY(-1px); color: #fff; box-shadow: 0 6px 16px rgba(245, 158, 11, .36); }
    .qf-pp-heading h1 { margin: 0; font-size: 1.4rem; font-weight: 700; color: #1b1f24; line-height: 1.1; }
    .qf-pp-heading p { margin: 0; color: #6b7280; font-size: .88rem; }

    /* Layout */
    .qf-pp-grid { display: grid; grid-template-columns: 320px 1fr; gap: 1.25rem; align-items: start; }
    .qf-pp-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 18px rgba(0, 0, 0, .06); overflow: hidden; }

    /* Avatar card */
    .qf-pp-avatar-card { padding: 1.75rem 1.25rem; text-align: center; }
    .qf-pp-avatar-wrap { position: relative; width: 150px; height: 150px; margin: 0 auto .9rem; }
    .qf-pp-avatar {
      width: 150px; height: 150px; border-radius: 50%; object-fit: cover;
      border: 4px solid #fff; box-shadow: 0 0 0 3px #f59e0b, 0 8px 20px rgba(0, 0, 0, .12);
    }
    .qf-pp-cam {
      position: absolute; right: 6px; bottom: 6px;
      width: 40px; height: 40px; border-radius: 50%; border: 3px solid #fff;
      background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff;
      display: grid; place-items: center; font-size: 1.15rem; cursor: pointer;
      box-shadow: 0 4px 10px rgba(245, 158, 11, .4); transition: transform .15s ease;
    }
    .qf-pp-cam:hover { transform: scale(1.08); }
    .qf-pp-name { margin: 0; font-size: 1.2rem; font-weight: 700; color: #1b1f24; }
    .qf-pp-role {
      display: inline-block; margin-top: .35rem; padding: .2rem .8rem; border-radius: 999px;
      background: #fef3c7; color: #b45309; font-size: .75rem; font-weight: 700; text-transform: capitalize;
    }
    .qf-pp-save {
      display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
      width: 100%; margin-top: 1.25rem; padding: .7rem 1rem; border: 0; border-radius: 11px;
      background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; font-weight: 600;
      cursor: pointer; transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
      box-shadow: 0 6px 16px rgba(245, 158, 11, .3);
    }
    .qf-pp-save:hover:not(:disabled) { transform: translateY(-1px); filter: brightness(1.05); }
    .qf-pp-save:disabled { opacity: .45; cursor: not-allowed; box-shadow: none; }
    .qf-pp-hint { margin: .6rem 0 0; font-size: .75rem; color: #9ca3af; }

    /* Info card */
    .qf-pp-info-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 1rem 1.25rem; background: linear-gradient(90deg, #1f2937, #111827); color: #fff;
      font-weight: 700; font-size: 1.05rem;
    }
    .qf-pp-info-head > span { display: inline-flex; align-items: center; gap: .5rem; }
    .qf-pp-info-head > span i { color: #fbbf24; font-size: 1.25rem; }
    .qf-pp-edit {
      display: inline-flex; align-items: center; gap: .4rem;
      padding: .4rem .85rem; border: 0; border-radius: 9px;
      background: #f59e0b; color: #fff; font-weight: 600; font-size: .85rem; cursor: pointer;
      transition: filter .15s ease, transform .15s ease;
    }
    .qf-pp-edit:hover { filter: brightness(1.07); transform: translateY(-1px); }
    .qf-pp-info-body { padding: 1.5rem 1.25rem; }
    .qf-pp-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem 1.5rem; margin: 0; }
    .qf-pp-fields > div { display: flex; flex-direction: column; gap: .2rem; min-width: 0; }
    .qf-pp-fields dt {
      display: flex; align-items: center; gap: .4rem;
      font-size: .72rem; text-transform: uppercase; letter-spacing: .04em; font-weight: 700; color: #9ca3af;
    }
    .qf-pp-fields dt i { color: #f59e0b; font-size: 1rem; }
    .qf-pp-fields dd { margin: 0; font-size: .95rem; font-weight: 600; color: #1b1f24; word-break: break-word; }

    /* Modal */
    .qf-pp-modal { border: 0; border-radius: 16px; overflow: hidden; }
    .qf-pp-modal .modal-header { background: #f8fafc; border-bottom: 1px solid #eef0f3; }
    .qf-pp-modal .modal-title { display: inline-flex; align-items: center; gap: .5rem; font-weight: 700; color: #1b1f24; }
    .qf-pp-modal .modal-title i { color: #f59e0b; }
    .qf-pp-field { margin-bottom: 1rem; }
    .qf-pp-field label { display: block; font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .3rem; }
    .qf-pp-field input {
      width: 100%; padding: .6rem .85rem; border: 1px solid #d1d5db; border-radius: 10px;
      font-size: .92rem; transition: border-color .15s ease, box-shadow .15s ease;
    }
    .qf-pp-field input:focus { outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, .18); }
    .qf-btn {
      display: inline-flex; align-items: center; gap: .4rem;
      padding: .55rem 1.1rem; border: 0; border-radius: 10px; font-weight: 600; font-size: .9rem; cursor: pointer;
      transition: transform .15s ease, filter .15s ease;
    }
    .qf-btn-primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; }
    .qf-btn-primary:hover { transform: translateY(-1px); filter: brightness(1.05); }
    .qf-btn-ghost { background: #eef0f3; color: #374151; }
    .qf-btn-ghost:hover { background: #e2e6ea; }

    @media (max-width: 820px) {
      .qf-pp-grid { grid-template-columns: 1fr; }
      .qf-pp-fields { grid-template-columns: 1fr; }
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function showFileInput() {
      document.getElementById('thumbnailprev').click();
    }

    // Live preview + enable the save button once a new photo is chosen.
    document.getElementById('thumbnailprev').addEventListener('change', function () {
      var file = this.files && this.files[0];
      if (!file) return;
      document.getElementById('profilePreview').src = URL.createObjectURL(file);
      var btn = document.getElementById('saveProfileBtn');
      btn.disabled = false;
      document.getElementById('saveHint').textContent = 'New photo selected — click “Save photo” to apply';
    });

    function updateUserProfile(userId) {
      var fileInput = document.getElementById('thumbnailprev');
      var file = fileInput.files[0];
      if (!file) { alert('Please choose a photo first.'); return; }

      var formData = new FormData();
      formData.append('profile', file);

      $.ajax({
        url: '/admin/update/profile/' + userId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function (response) {
          window.location.reload();
        },
        error: function () {
          alert('Failed to update profile picture');
        }
      });
    }

    function updateUser(userId) {
      var userData = {
        name: $('#username').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        _token: '{{ csrf_token() }}'
      };

      $.ajax({
        url: '/admin/update/' + userId,
        type: 'PUT',
        data: userData,
        success: function () {
          var modalEl = document.getElementById('exampleModal');
          var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
          modal.hide();
          window.location.reload();
        },
        error: function (xhr) {
          console.error('Error updating information:', xhr.responseText);
          var msg = 'Failed to update information';
          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            msg = Object.values(xhr.responseJSON.errors).map(function (e) { return e[0]; }).join('\n');
          }
          alert(msg);
        }
      });
    }
  </script>
</x-app-layout>
