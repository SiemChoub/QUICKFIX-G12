<x-app-layout>

    <div class="quser-page">
        {{-- ===== Header / toolbar ===== --}}
        <header class="qlist-head">
            <div class="qlist-head__title">
                <span class="qlist-head__icon"><i class='bx bxs-user-detail'></i></span>
                <span>
                    <h1>User Management</h1>
                    <p>{{ $users->total() }} {{ \Illuminate\Support\Str::plural('user', $users->total()) }} registered</p>
                </span>
            </div>
            <div class="qlist-head__actions">
                <div class="qlist-search">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" id="search-input" placeholder="Search users…" aria-label="Search users">
                </div>
                @can('User create')
                    <button type="button" class="qlist-create" data-bs-toggle="modal" data-bs-target="#userCreateModal">
                        <i class='bx bx-plus'></i><span>Create New</span>
                    </button>
                @endcan
            </div>
        </header>

        {{-- ===== User list ===== --}}
        @can('User access')
        <div class="quser-list" id="user-list">
            @foreach($users as $i => $user)
                @php
                    $r = strtolower($user->role ?? '');
                    $roleType = match (true) {
                        str_contains($r, 'admin')    => 'admin',
                        str_contains($r, 'fixer')    => 'fixer',
                        str_contains($r, 'customer') => 'customer',
                        default                      => 'user',
                    };
                    $parts    = preg_split('/\s+/', trim($user->name ?: 'User'));
                    $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                @endphp
                <div class="quser-card quser-card--{{ $roleType }}"
                     style="animation-delay: {{ $i * 50 }}ms"
                     data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $user->role) }}">

                    <span class="quser-avatar">
                        @if($user->profile)
                            <img src="{{ $user->profile }}" alt="{{ $user->name }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="quser-avatar__fallback" style="display:none">{{ $initials }}</span>
                        @else
                            <span class="quser-avatar__fallback">{{ $initials }}</span>
                        @endif
                    </span>

                    <div class="quser-meta">
                        <span class="quser-name">{{ $user->name }}</span>
                        <span class="quser-email"><i class='bx bx-envelope'></i> {{ $user->email }}</span>
                    </div>

                    <span class="quser-role">{{ ucfirst($user->role) }}</span>

                    <div class="quser-actions">
                        <button type="button" class="qlist-act qlist-act--info"
                            data-bs-toggle="modal" data-bs-target="#userDetailsModal"
                            data-user-name="{{ $user->name }}"
                            data-user-email="{{ $user->email }}"
                            data-user-phone="{{ $user->phone }}"
                            data-user-address="{{ $user->address }}"
                            data-user-profile="{{ $user->profile }}"
                            data-user-role="{{ ucfirst($user->role) }}"
                            data-user-initials="{{ $initials }}">
                            <i class='bx bx-detail'></i><span>Details</span>
                        </button>
                        @can('User edit')
                            <button type="button" class="qlist-act qlist-act--edit"
                                data-bs-toggle="modal" data-bs-target="#userEditModal"
                                data-action="{{ route('admin.users.update', $user->id) }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-phone="{{ $user->phone }}"
                                data-address="{{ $user->address }}"
                                data-role="{{ $user->role }}"
                                data-profile="{{ $user->profile }}"
                                data-initials="{{ $initials }}">
                                <i class='bx bx-edit-alt'></i><span>Edit</span>
                            </button>
                        @endcan
                        @can('User delete')
                            <button type="button" class="qlist-act qlist-act--del" onclick="confirmDelete({{ $user->id }})">
                                <i class='bx bx-trash'></i><span>Delete</span>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <div class="qlist-empty" id="user-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No users match your search.</p>
        </div>

        @include('booking._pagination', ['paginator' => $users, 'default' => 20])
        @endcan
    </div>

    {{-- ===== Details modal ===== --}}
    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel"><i class='bx bxs-user'></i> User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="quser-modal__hero">
                        <span class="quser-modal__avatar">
                            <img src="" alt="" id="user-profile" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span id="user-initials" style="display:none"></span>
                        </span>
                        <div>
                            <h4 id="user-name">—</h4>
                            <span class="quser-modal__role" id="user-role">—</span>
                        </div>
                    </div>
                    <div class="quser-modal__meta">
                        <div><i class='bx bxs-envelope'></i> <span>Email</span> <strong id="user-email">—</strong></div>
                        <div><i class='bx bxs-phone'></i> <span>Phone</span> <strong id="user-phone">—</strong></div>
                        <div class="quser-modal__meta--full"><i class='bx bxs-map'></i> <span>Address</span> <strong id="user-address">—</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Create modal ===== --}}
    @can('User create')
    <div class="modal fade" id="userCreateModal" tabindex="-1" aria-labelledby="userCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="userCreateModalLabel"><i class='bx bxs-user-plus'></i> Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body quser-form">
                        @include('setting.user._form-fields', ['uid' => 'create', 'mode' => 'create', 'roles' => $roles])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="quser-btn quser-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="quser-btn quser-btn--primary"><i class='bx bx-check'></i> Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- ===== Edit modal (same form component as Create; filled via JS from the row's data-* attributes) ===== --}}
    @can('User edit')
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="userEditModalLabel"><i class='bx bx-edit-alt'></i> Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="userEditForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body quser-form">
                        @include('setting.user._form-fields', ['uid' => 'edit', 'mode' => 'edit', 'roles' => $roles])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="quser-btn quser-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="quser-btn quser-btn--primary"><i class='bx bx-check'></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <style>
        .quser-page { padding: 1.75rem 1.5rem 2.5rem; }

        /* ===== Shared list-page chrome (qlist-*) ===== */
        .qlist-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
        .qlist-head__title { display: flex; align-items: center; gap: .9rem; }
        .qlist-head__icon {
            width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 1.7rem; color: #fff;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 6px 16px rgba(245, 158, 11, .35);
        }
        .qlist-head__title h1 { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2; }
        .qlist-head__title p  { font-size: .82rem; color: #9ca3af; margin: 0; }
        .qlist-head__actions { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
        .qlist-search {
            display: flex; align-items: center; gap: .5rem; background: #fff;
            border: 1px solid #e5e7eb; border-radius: 12px; padding: .55rem .85rem; min-width: 240px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qlist-search:focus-within { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qlist-search i { font-size: 1.15rem; color: #9ca3af; }
        .qlist-search input { border: 0; outline: 0; background: transparent; width: 100%; font-size: .9rem; color: #111827; }
        .qlist-search input::placeholder { color: #9ca3af; }
        .qlist-create {
            display: inline-flex; align-items: center; gap: .4rem;
            background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; font-weight: 600; font-size: .88rem;
            padding: .65rem 1.2rem; border-radius: 12px; text-decoration: none;
            box-shadow: 0 6px 16px rgba(245,158,11,.32);
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease; white-space: nowrap;
        }
        .qlist-create:hover { color: #fff; transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 8px 20px rgba(245,158,11,.4); }
        .qlist-create i { font-size: 1.2rem; }

        .qlist-act {
            display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
            font-size: .8rem; font-weight: 600; padding: .5rem .85rem; border-radius: 10px;
            border: 1px solid transparent; cursor: pointer; text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }
        .qlist-act i { font-size: 1rem; }
        .qlist-act--info { color: #0ea5e9; background: rgba(14,165,233,.1); }
        .qlist-act--info:hover { color: #fff; background: #0ea5e9; }
        .qlist-act--edit { color: #b45309; background: rgba(245,158,11,.12); }
        .qlist-act--edit:hover { color: #fff; background: #f59e0b; }
        .qlist-act--del  { color: #e11d48; background: rgba(244,63,94,.09); }
        .qlist-act--del:hover  { color: #fff; background: #f43f5e; }

        .qlist-empty { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
        .qlist-empty i { font-size: 2.4rem; }
        .qlist-empty p { margin: .5rem 0 0; font-size: .9rem; }
        .qlist-footer { margin-top: 1.6rem; display: flex; justify-content: flex-end; }
        .qlist-footer .pagination { margin: 0; }

        /* ===== User cards ===== */
        .quser-list { display: flex; flex-direction: column; gap: .6rem; }
        .quser-card {
            display: flex; align-items: center; gap: 1rem;
            background: #fff; border: 1px solid #eef0f4; border-radius: 14px; padding: .8rem 1.1rem;
            position: relative; overflow: hidden;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: quser-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes quser-in { to { opacity: 1; transform: translateY(0); } }
        .quser-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--c, #94a3b8); }
        .quser-card:hover { border-color: #e2e5ea; box-shadow: 0 10px 26px rgba(17,24,39,.08); transform: translateY(-2px); }

        .quser-avatar { position: relative; width: 46px; height: 46px; flex-shrink: 0; }
        .quser-avatar img, .quser-avatar__fallback {
            width: 46px; height: 46px; border-radius: 50%; object-fit: cover;
            border: 2px solid var(--c, #94a3b8);
        }
        .quser-avatar__fallback {
            display: grid; place-items: center; font-weight: 700; font-size: .95rem;
            color: var(--c, #475569); background: var(--c-soft, #f1f5f9);
        }
        .quser-meta { display: flex; flex-direction: column; min-width: 0; flex: 1 1 auto; }
        .quser-name { font-size: .98rem; font-weight: 700; color: #1f2937; line-height: 1.2; }
        .quser-email { display: inline-flex; align-items: center; gap: .3rem; font-size: .78rem; color: #9ca3af; margin-top: .15rem; }
        .quser-email i { font-size: .9rem; }
        .quser-role {
            flex-shrink: 0; font-size: .72rem; font-weight: 700; text-transform: capitalize;
            color: var(--c, #475569); background: var(--c-soft, #f1f5f9);
            padding: .3rem .8rem; border-radius: 999px;
        }
        .quser-actions { display: flex; align-items: center; gap: .45rem; flex-shrink: 0; }

        /* Role accents */
        .quser-card--admin    { --c: #8b5cf6; --c-soft: #f5f3ff; }
        .quser-card--fixer    { --c: #f59e0b; --c-soft: #fff7ed; }
        .quser-card--customer { --c: #10b981; --c-soft: #ecfdf5; }
        .quser-card--user     { --c: #64748b; --c-soft: #f1f5f9; }

        /* ===== Modal ===== */
        .qlist-modal { border: 0; border-radius: 18px; overflow: hidden; }
        .qlist-modal .modal-header { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; border: 0; }
        .qlist-modal .modal-title { font-weight: 700; display: flex; align-items: center; gap: .5rem; }
        .quser-modal__hero { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.2rem; }
        .quser-modal__avatar { position: relative; width: 64px; height: 64px; flex-shrink: 0; }
        .quser-modal__avatar img, .quser-modal__avatar span {
            width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #f59e0b;
        }
        .quser-modal__avatar span { display: grid; place-items: center; font-weight: 700; font-size: 1.3rem; color: #b45309; background: #fff7ed; }
        .quser-modal__hero h4 { margin: 0; font-size: 1.2rem; font-weight: 800; color: #111827; }
        .quser-modal__role { font-size: .78rem; font-weight: 700; color: #6b7280; background: #f1f5f9; padding: .2rem .7rem; border-radius: 999px; text-transform: capitalize; }
        .quser-modal__meta { display: grid; grid-template-columns: 1fr 1fr; gap: .7rem; }
        .quser-modal__meta div {
            display: flex; align-items: center; gap: .4rem; flex-wrap: wrap;
            background: #f8fafc; border-radius: 10px; padding: .7rem .85rem; font-size: .85rem; color: #6b7280;
        }
        .quser-modal__meta--full { grid-column: 1 / -1; }
        .quser-modal__meta i { font-size: 1.1rem; color: #f59e0b; }
        .quser-modal__meta strong { color: #1f2937; width: 100%; word-break: break-word; }

        /* ===== Create/Edit form (inside modal) ===== */
        .quser-form { display: flex; flex-direction: column; gap: 1rem; }
        .quser-field { display: flex; flex-direction: column; gap: .35rem; }
        .quser-field label { font-size: .82rem; font-weight: 600; color: #374151; }
        .quser-field input, .quser-field select {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .6rem .8rem;
            font-size: .9rem; color: #111827; outline: 0; background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .quser-field input:focus, .quser-field select:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .quser-field__error { color: #e11d48; font-size: .75rem; }
        .quser-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .quser-form__avatar { display: flex; align-items: center; gap: 1rem; }
        .quser-form__avatar-img {
            width: 76px; height: 76px; border-radius: 50%; object-fit: cover;
            border: 3px solid #f59e0b; box-shadow: 0 4px 12px rgba(0,0,0,.1); background: #f3f4f6; flex-shrink: 0;
        }
        .quser-form__avatar-body { display: flex; flex-direction: column; gap: .25rem; }
        .quser-form__avatar-body label { font-size: .82rem; font-weight: 600; color: #374151; }
        .quser-form__file { font-size: .85rem; color: #4b5563; }
        .quser-form__file::file-selector-button {
            margin-right: .6rem; padding: .4rem .8rem; border: 0; border-radius: 8px;
            background: #ffc107; color: #1b1f24; font-weight: 600; font-size: .82rem; cursor: pointer;
            transition: filter .15s ease;
        }
        .quser-form__file::file-selector-button:hover { filter: brightness(.95); }
        .quser-form__hint { font-size: .72rem; color: #9ca3af; margin: 0; }
        .quser-form__showpass { display: inline-flex; align-items: center; gap: .4rem; font-size: .82rem; color: #4b5563; cursor: pointer; }
        .qlist-modal .modal-footer { border-top: 1px solid #f1f5f9; gap: .5rem; }
        .quser-btn {
            display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 10px; border: 1px solid transparent; cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }
        .quser-btn i { font-size: 1.1rem; }
        .quser-btn--ghost { background: #f1f5f9; color: #475569; }
        .quser-btn--ghost:hover { background: #e2e8f0; }
        .quser-btn--primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 16px rgba(245,158,11,.32); }
        .quser-btn--primary:hover { filter: brightness(1.05); }

        @media (max-width: 560px) {
            .qlist-head__actions { width: 100%; }
            .qlist-search { flex: 1; min-width: 0; }
            .quser-role { display: none; }
            .qlist-act span { display: none; }
            .quser-modal__meta { grid-template-columns: 1fr; }
            .quser-field-row { grid-template-columns: 1fr; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?', text: "You won't be able to revert this!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#f43f5e', cancelButtonColor: '#94a3b8', confirmButtonText: 'Yes, delete it!'
            }).then((result) => { if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit(); });
        }

        document.getElementById('userDetailsModal').addEventListener('show.bs.modal', function (event) {
            const b = event.relatedTarget;
            document.getElementById('user-name').textContent    = b.dataset.userName;
            document.getElementById('user-role').textContent    = b.dataset.userRole;
            document.getElementById('user-email').textContent   = b.dataset.userEmail || '—';
            document.getElementById('user-phone').textContent   = b.dataset.userPhone || '—';
            document.getElementById('user-address').textContent = b.dataset.userAddress || '—';
            const img = document.getElementById('user-profile');
            const fb  = document.getElementById('user-initials');
            fb.textContent = b.dataset.userInitials || '';
            if (b.dataset.userProfile) { img.src = b.dataset.userProfile; img.style.display = ''; fb.style.display = 'none'; }
            else { img.style.display = 'none'; fb.style.display = 'grid'; }
        });

        // Fill the Edit modal from the clicked row's data, and point the form at the right record
        const userEditModal = document.getElementById('userEditModal');
        if (userEditModal) {
            userEditModal.addEventListener('show.bs.modal', function (event) {
                const b = event.relatedTarget;
                if (!b) return;
                document.getElementById('userEditForm').action = b.dataset.action || '';
                document.getElementById('edit-name').value    = b.dataset.name || '';
                document.getElementById('edit-email').value   = b.dataset.email || '';
                document.getElementById('edit-phone').value   = b.dataset.phone || '';
                document.getElementById('edit-address').value = b.dataset.address || '';
                const sel = document.getElementById('edit-role');
                if (sel) sel.value = b.dataset.role || '';
                // Reset the file input — update() keeps the existing photo unless a new file is chosen
                const file = document.getElementById('edit-profile');
                if (file) file.value = '';
                // Show the current photo (or a generated avatar) in the preview
                const prev = document.getElementById('edit-profile-preview');
                if (prev) {
                    prev.src = b.dataset.profile
                        || ('https://ui-avatars.com/api/?name=' + encodeURIComponent(b.dataset.name || 'User') + '&background=f59e0b&color=fff&bold=true');
                }
            });
        }

        // Live profile-photo preview for any file input flagged with data-preview (create + edit modals)
        document.querySelectorAll('input[type=file][data-preview]').forEach(function (inp) {
            inp.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;
                const prev = document.getElementById(inp.dataset.preview);
                if (prev) prev.src = URL.createObjectURL(file);
            });
        });

        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('user-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#user-list .quser-card').forEach(card => {
                    const match = card.dataset.search.includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                if (empty) empty.hidden = shown !== 0;
            });
        })();
    </script>

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('userCreateModal');
            if (el) new bootstrap.Modal(el).show();
        });
    </script>
    @endif

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'User {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-app-layout>
