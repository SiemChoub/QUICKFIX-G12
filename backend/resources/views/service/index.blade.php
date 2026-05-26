<x-app-layout>
    @include('partials.list-chrome')

    <div class="qlist-page">
        <header class="qlist-head">
            <div class="qlist-head__title">
                <span class="qlist-head__icon"><i class='bx bxs-wrench'></i></span>
                <span>
                    <h1>Service Management</h1>
                    <p>{{ $services->total() }} {{ \Illuminate\Support\Str::plural('service', $services->total()) }}</p>
                </span>
            </div>
            <div class="qlist-head__actions">
                <div class="qlist-search">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" id="search-input" placeholder="Search services…" aria-label="Search services">
                </div>
                @can('Service create')
                    <button type="button" class="qlist-create" data-bs-toggle="modal" data-bs-target="#serviceCreateModal">
                        <i class='bx bx-plus'></i><span>Create New</span>
                    </button>
                @endcan
            </div>
        </header>

        @can('Service access')
        <div class="qsvc-list" id="service-list">
            @foreach ($services as $i => $service)
                @php $cat = optional($service->category)->name ?? 'Uncategorized'; @endphp
                <article class="qsvc-row" style="animation-delay: {{ $i * 45 }}ms"
                         data-search="{{ strtolower($service->name . ' ' . $service->description . ' ' . $service->price . ' ' . $cat) }}">
                    <div class="qsvc-thumb">
                        @if($service->image)
                            <img src="{{ $service->image }}" alt="{{ $service->name }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="qsvc-thumb__fallback" style="display:none"><i class='bx bxs-wrench'></i></span>
                        @else
                            <span class="qsvc-thumb__fallback"><i class='bx bxs-wrench'></i></span>
                        @endif
                    </div>
                    <div class="qsvc-row__body">
                        <h3 class="qsvc-name">{{ $service->name }}</h3>
                        <span class="qsvc-cat"><i class='bx bx-category'></i> {{ $cat }}</span>
                        <p class="qsvc-desc">{{ $service->description ?: 'No description provided.' }}</p>
                    </div>
                    <span class="qsvc-price">{{ $service->price }}$</span>
                    <div class="qsvc-actions">
                        <button type="button" class="qlist-act qlist-act--info"
                            data-bs-toggle="modal" data-bs-target="#serviceDetailsModal"
                            data-service-image="{{ $service->image }}"
                            data-service-title="{{ $service->name }}"
                            data-service-description="{{ $service->description }}"
                            data-service-category="{{ $cat }}"
                            data-service-price="{{ $service->price }}">
                            <i class='bx bx-detail'></i><span>Details</span>
                        </button>
                        @can('Service edit')
                            <button type="button" class="qlist-act qlist-act--edit"
                                data-bs-toggle="modal" data-bs-target="#serviceEditModal"
                                data-action="{{ route('admin.services.update', $service->id) }}"
                                data-name="{{ $service->name }}"
                                data-description="{{ $service->description }}"
                                data-price="{{ $service->price }}"
                                data-category="{{ $service->category_id }}"
                                data-image="{{ $service->image }}">
                                <i class='bx bx-edit-alt'></i><span>Edit</span>
                            </button>
                        @endcan
                        @can('Service delete')
                            <button type="button" class="qlist-act qlist-act--del" onclick="confirmDelete({{ $service->id }})">
                                <i class='bx bx-trash'></i><span>Delete</span>
                            </button>
                            <form id="delete-form-{{ $service->id }}" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                </article>
            @endforeach
        </div>

        <div class="qlist-empty" id="service-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No services match your search.</p>
        </div>

        @include('booking._pagination', ['paginator' => $services, 'default' => 20])
        @endcan
    </div>

    {{-- Details modal --}}
    <div class="modal fade" id="serviceDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title"><i class='bx bxs-wrench'></i> Service Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="qsvc-modal">
                        <div class="qsvc-modal__img">
                            <img src="" alt="" id="service-image" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="qsvc-modal__imgfallback" style="display:none"><i class='bx bxs-wrench'></i></span>
                        </div>
                        <div class="qsvc-modal__info">
                            <h4 id="service-title">—</h4>
                            <div class="qsvc-modal__tags">
                                <span class="qsvc-modal__price"><i class='bx bxs-dollar-circle'></i> <span id="service-price">0</span>$</span>
                                <span class="qsvc-modal__cat"><i class='bx bx-category'></i> <span id="service-category">—</span></span>
                            </div>
                            <p id="service-description">—</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create modal --}}
    @can('Service create')
    <div class="modal fade" id="serviceCreateModal" tabindex="-1" aria-labelledby="serviceCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceCreateModalLabel"><i class='bx bxs-wrench'></i> Create Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body qsvc-form">
                        @include('service._form-fields', ['uid' => 'create', 'categories' => $categories])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qsvc-btn qsvc-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qsvc-btn qsvc-btn--primary"><i class='bx bx-check'></i> Create Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- Edit modal (same form component as Create; filled via JS from the row's data-* attributes) --}}
    @can('Service edit')
    <div class="modal fade" id="serviceEditModal" tabindex="-1" aria-labelledby="serviceEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceEditModalLabel"><i class='bx bx-edit-alt'></i> Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="serviceEditForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body qsvc-form">
                        @include('service._form-fields', ['uid' => 'edit', 'categories' => $categories])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qsvc-btn qsvc-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qsvc-btn qsvc-btn--primary"><i class='bx bx-check'></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <style>
        .qsvc-list { display: flex; flex-direction: column; gap: .7rem; }
        .qsvc-row {
            background: #fff; border: 1px solid #eef0f4; border-radius: 14px; padding: .85rem 1rem;
            display: flex; align-items: center; gap: 1rem;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: qsvc-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qsvc-in { to { opacity: 1; transform: translateY(0); } }
        .qsvc-row:hover { border-color: #e2e5ea; box-shadow: 0 10px 24px rgba(17,24,39,.08); transform: translateY(-2px); }

        .qsvc-thumb {
            width: 58px; height: 58px; border-radius: 13px; flex-shrink: 0; overflow: hidden;
            background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1px solid #fed7aa;
        }
        .qsvc-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .qsvc-thumb__fallback { width: 100%; height: 100%; display: grid; place-items: center; font-size: 1.7rem; color: #fbbf24; }

        .qsvc-row__body { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: .25rem; }
        .qsvc-name { font-size: 1.02rem; font-weight: 700; color: #1f2937; margin: 0; }
        .qsvc-cat {
            display: inline-flex; align-items: center; gap: .3rem; align-self: flex-start;
            font-size: .72rem; font-weight: 600; color: #0369a1; background: #e0f2fe; padding: .2rem .6rem; border-radius: 999px;
        }
        .qsvc-desc {
            margin: 0; color: #6b7280; font-size: .84rem; line-height: 1.4;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .qsvc-price {
            flex-shrink: 0; background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff;
            font-weight: 800; font-size: .9rem; padding: .35rem .85rem; border-radius: 999px;
            box-shadow: 0 4px 12px rgba(245,158,11,.35);
        }
        .qsvc-actions { display: flex; gap: .45rem; flex-shrink: 0; }

        /* modal */
        .qsvc-modal { display: flex; gap: 1.2rem; flex-wrap: wrap; }
        .qsvc-modal__img { width: 200px; height: 160px; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg,#fff7ed,#ffedd5); flex-shrink: 0; }
        .qsvc-modal__img img { width: 100%; height: 100%; object-fit: cover; }
        .qsvc-modal__imgfallback { width: 100%; height: 100%; display: grid; place-items: center; font-size: 3rem; color: #fbbf24; }
        .qsvc-modal__info { flex: 1; min-width: 200px; }
        .qsvc-modal__info h4 { font-size: 1.3rem; font-weight: 800; color: #111827; margin: 0 0 .6rem; }
        .qsvc-modal__tags { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: .8rem; }
        .qsvc-modal__price { display: inline-flex; align-items: center; gap: .3rem; font-weight: 700; color: #b45309; background: #fff7ed; padding: .3rem .7rem; border-radius: 999px; font-size: .85rem; }
        .qsvc-modal__cat { display: inline-flex; align-items: center; gap: .3rem; font-weight: 600; color: #0369a1; background: #e0f2fe; padding: .3rem .7rem; border-radius: 999px; font-size: .85rem; }
        .qsvc-modal__info p { color: #4b5563; font-size: .92rem; line-height: 1.55; margin: 0; }

        /* create form (inside modal) */
        .qsvc-form { display: flex; flex-direction: column; gap: 1rem; }
        .qsvc-field { display: flex; flex-direction: column; gap: .35rem; }
        .qsvc-field label { font-size: .82rem; font-weight: 600; color: #374151; }
        .qsvc-field input, .qsvc-field textarea, .qsvc-field select {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .6rem .8rem;
            font-size: .9rem; color: #111827; outline: 0; background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qsvc-field input:focus, .qsvc-field textarea:focus, .qsvc-field select:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qsvc-field textarea { resize: vertical; }
        .qsvc-field__error { color: #e11d48; font-size: .75rem; }
        .qsvc-field__note { font-size: .82rem; color: #6b7280; margin: 0; }
        .qsvc-field__note a { color: #b45309; font-weight: 600; }
        .qsvc-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .qlist-modal .modal-footer { border-top: 1px solid #f1f5f9; gap: .5rem; }
        .qsvc-btn {
            display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 10px; border: 1px solid transparent; cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }
        .qsvc-btn i { font-size: 1.1rem; }
        .qsvc-btn--ghost { background: #f1f5f9; color: #475569; }
        .qsvc-btn--ghost:hover { background: #e2e8f0; }
        .qsvc-btn--primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 16px rgba(245,158,11,.32); }
        .qsvc-btn--primary:hover { filter: brightness(1.05); }

        @media (max-width: 560px) {
            .qsvc-row { flex-wrap: wrap; }
            .qsvc-price { order: -1; }
            .qsvc-actions { width: 100%; }
            .qsvc-actions .qlist-act { flex: 1; }
            .qsvc-field-row { grid-template-columns: 1fr; }
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

        document.getElementById('serviceDetailsModal').addEventListener('show.bs.modal', function (event) {
            const b = event.relatedTarget;
            document.getElementById('service-title').textContent       = b.dataset.serviceTitle;
            document.getElementById('service-description').textContent = b.dataset.serviceDescription || 'No description provided.';
            document.getElementById('service-category').textContent    = b.dataset.serviceCategory;
            document.getElementById('service-price').textContent       = b.dataset.servicePrice;
            const img = document.getElementById('service-image');
            const fb  = img.nextElementSibling;
            if (b.dataset.serviceImage) { img.src = b.dataset.serviceImage; img.style.display = ''; fb.style.display = 'none'; }
            else { img.style.display = 'none'; fb.style.display = 'grid'; }
        });

        // Fill the Edit modal from the clicked row's data, and point the form at the right record
        const serviceEditModal = document.getElementById('serviceEditModal');
        if (serviceEditModal) {
            serviceEditModal.addEventListener('show.bs.modal', function (event) {
                const b = event.relatedTarget;
                if (!b) return;
                document.getElementById('serviceEditForm').action = b.dataset.action || '';
                document.getElementById('edit-name').value        = b.dataset.name || '';
                document.getElementById('edit-description').value = b.dataset.description || '';
                document.getElementById('edit-price').value       = b.dataset.price || '';
                const sel = document.getElementById('edit-category_id');
                if (sel) sel.value = b.dataset.category || '';
                // Reset the file input — update() keeps the existing image unless a new file is chosen
                const file = document.getElementById('edit-image');
                if (file) file.value = '';
                // Show the current image (if any) in the thumbnail
                const thumb = document.getElementById('qfThumb_edit-image');
                if (thumb) {
                    if (b.dataset.image) {
                        thumb.innerHTML = '';
                        const im = document.createElement('img');
                        im.src = b.dataset.image; im.alt = b.dataset.name || 'Service image';
                        thumb.appendChild(im);
                    } else {
                        thumb.innerHTML = "<i class='bx bx-image-add'></i>";
                    }
                }
            });
        }

        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('service-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#service-list .qsvc-row').forEach(row => {
                    const match = row.dataset.search.includes(q);
                    row.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                if (empty) empty.hidden = shown !== 0;
            });
        })();
    </script>

    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('serviceCreateModal');
            if (el) new bootstrap.Modal(el).show();
        });
    </script>
    @endif

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'Service {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-app-layout>
