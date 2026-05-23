<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a href="{{ route('admin.services.create') }}" class="qlist-create">
                        <i class='bx bx-plus'></i><span>Create New</span>
                    </a>
                @endcan
            </div>
        </header>

        @can('Service access')
        <div class="qsvc-grid" id="service-list">
            @foreach ($services as $i => $service)
                @php $cat = optional($service->category)->name ?? 'Uncategorized'; @endphp
                <article class="qsvc-card" style="animation-delay: {{ $i * 55 }}ms"
                         data-search="{{ strtolower($service->name . ' ' . $service->description . ' ' . $service->price . ' ' . $cat) }}">
                    <div class="qsvc-thumb">
                        @if($service->image)
                            <img src="{{ $service->image }}" alt="{{ $service->name }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="qsvc-thumb__fallback" style="display:none"><i class='bx bxs-wrench'></i></span>
                        @else
                            <span class="qsvc-thumb__fallback"><i class='bx bxs-wrench'></i></span>
                        @endif
                        <span class="qsvc-price">{{ $service->price }}$</span>
                    </div>
                    <div class="qsvc-body">
                        <h3 class="qsvc-name">{{ $service->name }}</h3>
                        <span class="qsvc-cat"><i class='bx bx-category'></i> {{ $cat }}</span>
                        <p class="qsvc-desc">{{ $service->description ?: 'No description provided.' }}</p>
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
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="qlist-act qlist-act--edit">
                                    <i class='bx bx-edit-alt'></i><span>Edit</span>
                                </a>
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
                    </div>
                </article>
            @endforeach
        </div>

        <div class="qlist-empty" id="service-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No services match your search.</p>
        </div>

        <div class="qlist-footer">{{ $services->links() }}</div>
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

    <style>
        .qsvc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.2rem; }
        .qsvc-card {
            background: #fff; border: 1px solid #eef0f4; border-radius: 16px; overflow: hidden;
            display: flex; flex-direction: column;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(10px);
            animation: qsvc-in .5s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qsvc-in { to { opacity: 1; transform: translateY(0); } }
        .qsvc-card:hover { border-color: #e2e5ea; box-shadow: 0 14px 32px rgba(17,24,39,.12); transform: translateY(-3px); }

        .qsvc-thumb { position: relative; height: 140px; background: linear-gradient(135deg, #fff7ed, #ffedd5); }
        .qsvc-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .qsvc-thumb__fallback { width: 100%; height: 100%; display: grid; place-items: center; font-size: 3rem; color: #fbbf24; }
        .qsvc-price {
            position: absolute; bottom: .6rem; right: .6rem;
            background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff;
            font-weight: 800; font-size: .95rem; padding: .3rem .8rem; border-radius: 999px;
            box-shadow: 0 4px 12px rgba(245,158,11,.4);
        }
        .qsvc-body { padding: 1rem 1.1rem 1.1rem; display: flex; flex-direction: column; gap: .5rem; flex: 1; }
        .qsvc-name { font-size: 1.02rem; font-weight: 700; color: #1f2937; margin: 0; }
        .qsvc-cat {
            display: inline-flex; align-items: center; gap: .3rem; align-self: flex-start;
            font-size: .73rem; font-weight: 600; color: #0369a1; background: #e0f2fe; padding: .25rem .65rem; border-radius: 999px;
        }
        .qsvc-desc {
            margin: 0; color: #6b7280; font-size: .85rem; line-height: 1.45; flex: 1;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5em;
        }
        .qsvc-actions { display: flex; gap: .4rem; margin-top: .3rem; }
        .qsvc-actions .qlist-act { flex: 1; padding: .5rem .4rem; }

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

        @media (max-width: 560px) { .qsvc-actions .qlist-act span { display: none; } }
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

        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('service-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#service-list .qsvc-card').forEach(card => {
                    const match = card.dataset.search.includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                if (empty) empty.hidden = shown !== 0;
            });
        })();
    </script>

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'Service {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-app-layout>
