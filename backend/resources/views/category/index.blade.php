<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.list-chrome')

    <div class="qlist-page">
        <header class="qlist-head">
            <div class="qlist-head__title">
                <span class="qlist-head__icon"><i class='bx bxs-category'></i></span>
                <span>
                    <h1>Category Management</h1>
                    <p>{{ $categories->total() }} {{ \Illuminate\Support\Str::plural('category', $categories->total()) }}</p>
                </span>
            </div>
            <div class="qlist-head__actions">
                <div class="qlist-search">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" id="search-input" placeholder="Search categories…" aria-label="Search categories">
                </div>
                @can('Category create')
                    <button type="button" class="qlist-create" data-bs-toggle="modal" data-bs-target="#categoryCreateModal">
                        <i class='bx bx-plus'></i><span>Create New</span>
                    </button>
                @endcan
            </div>
        </header>

        @can('Category access')
        <div class="qcat-list" id="category-list">
            @foreach ($categories as $i => $category)
                <article class="qcat-row" style="animation-delay: {{ $i * 45 }}ms"
                         data-search="{{ strtolower($category->name . ' ' . $category->description) }}">
                    <div class="qcat-thumb">
                        @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="qcat-thumb__fallback" style="display:none"><i class='bx bxs-category-alt'></i></span>
                        @else
                            <span class="qcat-thumb__fallback"><i class='bx bxs-category-alt'></i></span>
                        @endif
                    </div>
                    <div class="qcat-row__body">
                        <h3 class="qcat-name">{{ $category->name }}</h3>
                        <p class="qcat-desc">{{ $category->description ?: 'No description provided.' }}</p>
                    </div>
                    <div class="qcat-actions">
                        <button type="button" class="qlist-act qlist-act--info"
                            data-bs-toggle="modal" data-bs-target="#categoryDetailsModal"
                            data-category-image="{{ $category->image }}"
                            data-category-title="{{ $category->name }}"
                            data-category-description="{{ $category->description }}">
                            <i class='bx bx-detail'></i><span>Details</span>
                        </button>
                        @can('Category edit')
                            <button type="button" class="qlist-act qlist-act--edit"
                                data-bs-toggle="modal" data-bs-target="#categoryEditModal"
                                data-action="{{ route('admin.categories.update', $category->id) }}"
                                data-name="{{ $category->name }}"
                                data-description="{{ $category->description }}"
                                data-image="{{ $category->image }}">
                                <i class='bx bx-edit-alt'></i><span>Edit</span>
                            </button>
                        @endcan
                        @can('Category delete')
                            <button type="button" class="qlist-act qlist-act--del" onclick="confirmDelete({{ $category->id }})">
                                <i class='bx bx-trash'></i><span>Delete</span>
                            </button>
                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                </article>
            @endforeach
        </div>

        <div class="qlist-empty" id="category-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No categories match your search.</p>
        </div>

        @include('booking._pagination', ['paginator' => $categories, 'default' => 20])
        @endcan
    </div>

    {{-- Details modal --}}
    <div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title"><i class='bx bxs-category'></i> Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="qcat-modal__hero">
                        <div class="qcat-modal__img">
                            <img src="" alt="" id="category-image" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="qcat-modal__imgfallback" style="display:none"><i class='bx bxs-category-alt'></i></span>
                        </div>
                        <h4 id="category-title">—</h4>
                    </div>
                    <p class="qcat-modal__desc" id="category-description">—</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Create modal --}}
    @can('Category create')
    <div class="modal fade" id="categoryCreateModal" tabindex="-1" aria-labelledby="categoryCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryCreateModalLabel"><i class='bx bxs-category'></i> Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body qcat-form">
                        @include('category._form-fields', ['uid' => 'create'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qcat-btn qcat-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qcat-btn qcat-btn--primary"><i class='bx bx-check'></i> Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- Edit modal (same form component as Create; filled via JS from the row's data-* attributes) --}}
    @can('Category edit')
    <div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditModalLabel"><i class='bx bx-edit-alt'></i> Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="categoryEditForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body qcat-form">
                        @include('category._form-fields', ['uid' => 'edit'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qcat-btn qcat-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qcat-btn qcat-btn--primary"><i class='bx bx-check'></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <style>
        .qcat-list { display: flex; flex-direction: column; gap: .7rem; }
        .qcat-row {
            background: #fff; border: 1px solid #eef0f4; border-radius: 14px; padding: .85rem 1rem;
            display: flex; align-items: center; gap: 1rem;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: qcat-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qcat-in { to { opacity: 1; transform: translateY(0); } }
        .qcat-row:hover { border-color: #e2e5ea; box-shadow: 0 10px 24px rgba(17,24,39,.08); transform: translateY(-2px); }

        .qcat-thumb {
            width: 58px; height: 58px; border-radius: 13px; flex-shrink: 0; overflow: hidden;
            background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1px solid #fed7aa;
        }
        .qcat-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .qcat-thumb__fallback { width: 100%; height: 100%; display: grid; place-items: center; font-size: 1.7rem; color: #d97706; }

        .qcat-row__body { flex: 1; min-width: 0; }
        .qcat-name { font-size: 1.02rem; font-weight: 700; color: #1f2937; margin: 0 0 .15rem; }
        .qcat-desc {
            margin: 0; color: #6b7280; font-size: .85rem; line-height: 1.45;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .qcat-actions { display: flex; gap: .45rem; flex-shrink: 0; }

        .qcat-modal__hero { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .qcat-modal__img {
            width: 70px; height: 70px; border-radius: 16px; overflow: hidden; flex-shrink: 0;
            background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1px solid #fed7aa;
        }
        .qcat-modal__img img { width: 100%; height: 100%; object-fit: cover; }
        .qcat-modal__imgfallback { width: 100%; height: 100%; display: grid; place-items: center; font-size: 2rem; color: #d97706; }
        .qcat-modal__hero h4 { margin: 0; font-size: 1.3rem; font-weight: 800; color: #111827; }
        .qcat-modal__desc { color: #4b5563; font-size: .95rem; line-height: 1.6; margin: 0; }

        /* create/edit form (inside modal) */
        .qcat-form { display: flex; flex-direction: column; gap: 1rem; }
        .qcat-field { display: flex; flex-direction: column; gap: .35rem; }
        .qcat-field label { font-size: .82rem; font-weight: 600; color: #374151; }
        .qcat-field input, .qcat-field textarea {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .6rem .8rem;
            font-size: .9rem; color: #111827; outline: 0; background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qcat-field input:focus, .qcat-field textarea:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qcat-field textarea { resize: vertical; }
        .qcat-field__error { color: #e11d48; font-size: .75rem; }
        .qlist-modal .modal-footer { border-top: 1px solid #f1f5f9; gap: .5rem; }
        .qcat-btn {
            display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 10px; border: 1px solid transparent; cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }
        .qcat-btn i { font-size: 1.1rem; }
        .qcat-btn--ghost { background: #f1f5f9; color: #475569; }
        .qcat-btn--ghost:hover { background: #e2e8f0; }
        .qcat-btn--primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 16px rgba(245,158,11,.32); }
        .qcat-btn--primary:hover { filter: brightness(1.05); }

        @media (max-width: 560px) {
            .qcat-row { flex-wrap: wrap; }
            .qcat-actions { width: 100%; }
            .qcat-actions .qlist-act { flex: 1; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?', text: "You won't be able to revert this!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#f43f5e', cancelButtonColor: '#94a3b8', confirmButtonText: 'Yes, delete it!'
            }).then((result) => { if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit(); });
        }

        document.getElementById('categoryDetailsModal').addEventListener('show.bs.modal', function (event) {
            const b = event.relatedTarget;
            document.getElementById('category-title').textContent = b.dataset.categoryTitle;
            document.getElementById('category-description').textContent = b.dataset.categoryDescription || 'No description provided.';
            const img = document.getElementById('category-image');
            const fb  = img.nextElementSibling;
            if (b.dataset.categoryImage) { img.src = b.dataset.categoryImage; img.style.display = ''; fb.style.display = 'none'; }
            else { img.style.display = 'none'; fb.style.display = 'grid'; }
        });

        // Fill the Edit modal from the clicked row's data, and point the form at the right record
        const categoryEditModal = document.getElementById('categoryEditModal');
        if (categoryEditModal) {
            categoryEditModal.addEventListener('show.bs.modal', function (event) {
                const b = event.relatedTarget;
                if (!b) return;
                document.getElementById('categoryEditForm').action = b.dataset.action || '';
                document.getElementById('edit-name').value        = b.dataset.name || '';
                document.getElementById('edit-description').value = b.dataset.description || '';
                // Reset the file input — update() keeps the existing image unless a new file is chosen
                const file = document.getElementById('edit-image');
                if (file) file.value = '';
                // Show the current image (if any) in the thumbnail
                const thumb = document.getElementById('qfThumb_edit-image');
                if (thumb) {
                    if (b.dataset.image) {
                        thumb.innerHTML = '';
                        const im = document.createElement('img');
                        im.src = b.dataset.image; im.alt = b.dataset.name || 'Category image';
                        thumb.appendChild(im);
                    } else {
                        thumb.innerHTML = "<i class='bx bx-image-add'></i>";
                    }
                }
            });
        }

        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('category-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#category-list .qcat-row').forEach(row => {
                    const match = row.dataset.search.includes(q);
                    row.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                if (empty) empty.hidden = shown !== 0;
            });
        })();
    </script>

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'Category {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-app-layout>
