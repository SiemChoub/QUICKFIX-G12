<x-app-layout fade>

    <div class="qdisc-page">
        {{-- ===== Header / toolbar ===== --}}
        <header class="qdisc-head">
            <div class="qdisc-head__title">
                <span class="qdisc-head__icon"><i class='bx bxs-discount'></i></span>
                <span>
                    <h1>Discount Management</h1>
                    <p>{{ $discounts->total() }} {{ \Illuminate\Support\Str::plural('discount', $discounts->total()) }} configured</p>
                </span>
            </div>

            <div class="qdisc-head__actions">
                <div class="qdisc-search">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" id="search-input" placeholder="Search discounts…" aria-label="Search discounts">
                </div>
                @can('Discount create')
                    <button type="button" class="qdisc-create" data-bs-toggle="modal" data-bs-target="#discountCreateModal">
                        <i class='bx bx-plus'></i>
                        <span>Create New</span>
                    </button>
                @endcan
            </div>
        </header>

        {{-- ===== Discount cards ===== --}}
        @can('Discount access')
        <div class="qdisc-grid" id="discount-list">
            @foreach ($discounts as $i => $discount)
                @php
                    $start = $discount->start_date ? \Carbon\Carbon::parse($discount->start_date) : null;
                    $end   = $discount->end_date   ? \Carbon\Carbon::parse($discount->end_date)   : null;
                    $now   = now();
                    if ($start && $now->lt($start))      { $status = 'upcoming'; $statusLabel = 'Upcoming'; }
                    elseif ($end && $now->gt($end))      { $status = 'expired';  $statusLabel = 'Expired'; }
                    else                                 { $status = 'active';   $statusLabel = 'Active'; }
                @endphp
                <article class="qdisc-card qdisc-card--{{ $status }}"
                         style="animation-delay: {{ $i * 60 }}ms"
                         data-search="{{ strtolower($discount->discount . '% ' . $discount->description . ' ' . $discount->start_date . ' ' . $discount->end_date) }}">

                    <div class="qdisc-card__top">
                        <div class="qdisc-percent">
                            <span class="qdisc-percent__num">{{ $discount->discount }}</span>
                            <span class="qdisc-percent__sym">% OFF</span>
                        </div>
                        <span class="qdisc-status qdisc-status--{{ $status }}">
                            <i class='bx bxs-circle'></i> {{ $statusLabel }}
                        </span>
                    </div>

                    <p class="qdisc-card__desc" title="{{ $discount->description }}">{{ $discount->description }}</p>

                    <div class="qdisc-card__dates">
                        <div class="qdisc-date">
                            <span class="qdisc-date__label"><i class='bx bx-calendar'></i> Start</span>
                            <span class="qdisc-date__val">{{ $start ? $start->format('M j, Y') : '—' }}</span>
                        </div>
                        <i class='bx bx-right-arrow-alt qdisc-date__arrow'></i>
                        <div class="qdisc-date">
                            <span class="qdisc-date__label"><i class='bx bx-calendar-check'></i> End</span>
                            <span class="qdisc-date__val">{{ $end ? $end->format('M j, Y') : '—' }}</span>
                        </div>
                    </div>

                    <div class="qdisc-card__actions">
                        <button type="button" class="qdisc-act qdisc-act--info"
                            data-bs-toggle="modal" data-bs-target="#discountDetailsModal"
                            data-discount-title="{{ $discount->discount }}%"
                            data-discount-description="{{ $discount->description }}"
                            data-discount-start_date="{{ $start ? $start->format('M j, Y · g:i A') : '—' }}"
                            data-discount-end_date="{{ $end ? $end->format('M j, Y · g:i A') : '—' }}"
                            data-discount-status="{{ $statusLabel }}">
                            <i class='bx bx-detail'></i><span>Details</span>
                        </button>
                        @can('Discount edit')
                            <button type="button" class="qdisc-act qdisc-act--edit"
                                data-bs-toggle="modal" data-bs-target="#discountEditModal"
                                data-action="{{ route('admin.discounts.update', $discount->id) }}"
                                data-discount="{{ $discount->discount }}"
                                data-description="{{ $discount->description }}"
                                data-start="{{ $start ? $start->format('Y-m-d') : '' }}"
                                data-end="{{ $end ? $end->format('Y-m-d') : '' }}">
                                <i class='bx bx-edit-alt'></i><span>Edit</span>
                            </button>
                        @endcan
                        @can('Discount delete')
                            <button type="button" class="qdisc-act qdisc-act--del" onclick="confirmDelete({{ $discount->id }})">
                                <i class='bx bx-trash'></i><span>Delete</span>
                            </button>
                            <form id="delete-form-{{ $discount->id }}" action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                </article>
            @endforeach
        </div>

        <div class="qdisc-empty" id="discount-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No discounts match your search.</p>
        </div>

        @include('booking._pagination', ['paginator' => $discounts, 'default' => 20])
        @endcan
    </div>

    {{-- ===== Details modal (Bootstrap) ===== --}}
    <div class="modal fade" id="discountDetailsModal" tabindex="-1" aria-labelledby="discountDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qdisc-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountDetailsModalLabel"><i class='bx bxs-discount'></i> Discount Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="qdisc-modal__hero">
                        <span class="qdisc-modal__percent" id="discount-title">25%</span>
                        <span class="qdisc-modal__status" id="discount-status">Active</span>
                    </div>
                    <p class="qdisc-modal__desc" id="discount-description">—</p>
                    <div class="qdisc-modal__meta">
                        <div><i class='bx bxs-calendar'></i> <span>Start</span> <strong id="discount-start_date">—</strong></div>
                        <div><i class='bx bxs-calendar-check'></i> <span>End</span> <strong id="discount-end_date">—</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Create modal (Bootstrap) ===== --}}
    @can('Discount create')
    <div class="modal fade" id="discountCreateModal" tabindex="-1" aria-labelledby="discountCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qdisc-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountCreateModalLabel"><i class='bx bxs-discount'></i> Create Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.discounts.store') }}">
                    @csrf
                    <div class="modal-body qdisc-form">
                        @include('discount._form-fields', ['uid' => 'create'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qdisc-btn qdisc-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qdisc-btn qdisc-btn--primary"><i class='bx bx-check'></i> Create Discount</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- ===== Edit modal (same form component as Create; filled via JS from the row's data-* attributes) ===== --}}
    @can('Discount edit')
    <div class="modal fade" id="discountEditModal" tabindex="-1" aria-labelledby="discountEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content qdisc-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountEditModalLabel"><i class='bx bx-edit-alt'></i> Edit Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="discountEditForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body qdisc-form">
                        @include('discount._form-fields', ['uid' => 'edit'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qdisc-btn qdisc-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qdisc-btn qdisc-btn--primary"><i class='bx bx-check'></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <style>
        .qdisc-page { padding: 1.75rem 1.5rem 2.5rem; }

        /* ===== Header ===== */
        .qdisc-head {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
        }
        .qdisc-head__title { display: flex; align-items: center; gap: .9rem; }
        .qdisc-head__icon {
            width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 1.7rem; color: #fff;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 6px 16px rgba(245, 158, 11, .35);
        }
        .qdisc-head__title h1 { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0; line-height: 1.2; }
        .qdisc-head__title p  { font-size: .82rem; color: #9ca3af; margin: 0; }
        .qdisc-head__actions { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }

        .qdisc-search {
            display: flex; align-items: center; gap: .5rem;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: .55rem .85rem; min-width: 240px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qdisc-search:focus-within { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qdisc-search i { font-size: 1.15rem; color: #9ca3af; }
        .qdisc-search input { border: 0; outline: 0; background: transparent; width: 100%; font-size: .9rem; color: #111827; }
        .qdisc-search input::placeholder { color: #9ca3af; }

        .qdisc-create {
            display: inline-flex; align-items: center; gap: .4rem;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #fff; font-weight: 600; font-size: .88rem;
            padding: .65rem 1.2rem; border-radius: 12px; text-decoration: none;
            box-shadow: 0 6px 16px rgba(245,158,11,.32);
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
            white-space: nowrap;
        }
        .qdisc-create:hover { color: #fff; transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 8px 20px rgba(245,158,11,.4); }
        .qdisc-create i { font-size: 1.2rem; }

        /* ===== Grid ===== */
        .qdisc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 1.1rem;
        }

        .qdisc-card {
            background: #fff; border: 1px solid #eef0f4; border-radius: 18px;
            padding: 1.25rem 1.3rem; position: relative; overflow: hidden;
            display: flex; flex-direction: column; gap: .9rem;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(10px);
            animation: qdisc-in .5s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qdisc-in { to { opacity: 1; transform: translateY(0); } }
        .qdisc-card::before {
            content: ''; position: absolute; inset: 0 auto 0 0; width: 5px;
            background: var(--c, #94a3b8);
        }
        .qdisc-card:hover { border-color: #e2e5ea; box-shadow: 0 14px 32px rgba(17,24,39,.1); transform: translateY(-3px); }

        .qdisc-card__top { display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem; }
        .qdisc-percent {
            display: inline-flex; align-items: baseline; gap: .3rem;
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border: 1px solid #fed7aa; border-radius: 14px;
            padding: .45rem .85rem;
        }
        .qdisc-percent__num { font-size: 1.85rem; font-weight: 800; color: #d97706; line-height: 1; }
        .qdisc-percent__sym { font-size: .8rem; font-weight: 700; color: #f59e0b; }

        .qdisc-status {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .72rem; font-weight: 700; padding: .3rem .7rem; border-radius: 999px;
            color: var(--c, #475569); background: var(--c-soft, #f1f5f9);
            white-space: nowrap;
        }
        .qdisc-status i { font-size: .55rem; }

        .qdisc-card__desc {
            margin: 0; color: #4b5563; font-size: .9rem; line-height: 1.45;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden; min-height: 2.6em;
        }

        .qdisc-card__dates {
            display: flex; align-items: center; justify-content: space-between; gap: .5rem;
            background: #f8fafc; border-radius: 12px; padding: .7rem .85rem;
        }
        .qdisc-date { display: flex; flex-direction: column; gap: .15rem; min-width: 0; }
        .qdisc-date__label { display: inline-flex; align-items: center; gap: .3rem; font-size: .7rem; color: #9ca3af; font-weight: 600; }
        .qdisc-date__val { font-size: .86rem; font-weight: 700; color: #1f2937; }
        .qdisc-date__arrow { font-size: 1.3rem; color: #cbd5e1; flex-shrink: 0; }

        .qdisc-card__actions { display: flex; gap: .45rem; margin-top: auto; }
        .qdisc-act {
            flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
            font-size: .8rem; font-weight: 600; padding: .5rem .6rem; border-radius: 10px;
            border: 1px solid transparent; cursor: pointer; text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }
        .qdisc-act i { font-size: 1rem; }
        .qdisc-act--info { color: #0ea5e9; background: rgba(14,165,233,.1); }
        .qdisc-act--info:hover { color: #fff; background: #0ea5e9; }
        .qdisc-act--edit { color: #b45309; background: rgba(245,158,11,.12); }
        .qdisc-act--edit:hover { color: #fff; background: #f59e0b; }
        .qdisc-act--del  { color: #e11d48; background: rgba(244,63,94,.09); }
        .qdisc-act--del:hover  { color: #fff; background: #f43f5e; }

        /* ===== Status accents ===== */
        .qdisc-card--active   { --c: #10b981; --c-soft: #ecfdf5; }
        .qdisc-card--upcoming { --c: #3b82f6; --c-soft: #eff6ff; }
        .qdisc-card--expired  { --c: #94a3b8; --c-soft: #f1f5f9; }

        /* ===== Empty + footer ===== */
        .qdisc-empty { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
        .qdisc-empty i { font-size: 2.4rem; }
        .qdisc-empty p { margin: .5rem 0 0; font-size: .9rem; }
        .qdisc-footer { margin-top: 1.6rem; display: flex; justify-content: flex-end; }
        .qdisc-footer .pagination { margin: 0; }

        /* ===== Modal ===== */
        .qdisc-modal { border: 0; border-radius: 18px; overflow: hidden; }
        .qdisc-modal .modal-header { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; border: 0; }
        .qdisc-modal .modal-title { font-weight: 700; display: flex; align-items: center; gap: .5rem; }
        .qdisc-modal__hero { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .qdisc-modal__percent {
            font-size: 2.4rem; font-weight: 800; color: #d97706;
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border: 1px solid #fed7aa; border-radius: 14px; padding: .4rem 1rem;
        }
        .qdisc-modal__status { font-size: .8rem; font-weight: 700; color: #475569; background: #f1f5f9; padding: .35rem .8rem; border-radius: 999px; }
        .qdisc-modal__desc { color: #4b5563; font-size: .95rem; line-height: 1.55; }
        .qdisc-modal__meta { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-top: 1rem; }
        .qdisc-modal__meta div {
            display: flex; align-items: center; gap: .4rem; flex-wrap: wrap;
            background: #f8fafc; border-radius: 10px; padding: .7rem .85rem; font-size: .85rem; color: #6b7280;
        }
        .qdisc-modal__meta i { font-size: 1.1rem; color: #f59e0b; }
        .qdisc-modal__meta strong { color: #1f2937; width: 100%; }

        /* ===== Create form (inside modal) ===== */
        .qdisc-form { display: flex; flex-direction: column; gap: 1rem; }
        .qdisc-field { display: flex; flex-direction: column; gap: .35rem; }
        .qdisc-field label { font-size: .82rem; font-weight: 600; color: #374151; }
        .qdisc-field input, .qdisc-field textarea {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .6rem .8rem;
            font-size: .9rem; color: #111827; outline: 0; background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qdisc-field input:focus, .qdisc-field textarea:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qdisc-field textarea { resize: vertical; }
        .qdisc-field__error { color: #e11d48; font-size: .75rem; }
        .qdisc-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .qdisc-modal .modal-footer { border-top: 1px solid #f1f5f9; gap: .5rem; }
        .qdisc-btn {
            display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 10px; border: 1px solid transparent; cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }
        .qdisc-btn i { font-size: 1.1rem; }
        .qdisc-btn--ghost { background: #f1f5f9; color: #475569; }
        .qdisc-btn--ghost:hover { background: #e2e8f0; }
        .qdisc-btn--primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 16px rgba(245,158,11,.32); }
        .qdisc-btn--primary:hover { filter: brightness(1.05); }

        @media (max-width: 560px) {
            .qdisc-head__actions { width: 100%; }
            .qdisc-search { flex: 1; min-width: 0; }
            .qdisc-act span { display: none; }
            .qdisc-field-row { grid-template-columns: 1fr; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }

        // Populate the details modal from the triggering button's data attributes
        document.getElementById('discountDetailsModal').addEventListener('show.bs.modal', function (event) {
            const b = event.relatedTarget;
            document.getElementById('discount-title').textContent       = b.dataset.discountTitle;
            document.getElementById('discount-status').textContent      = b.dataset.discountStatus;
            document.getElementById('discount-description').textContent = b.dataset.discountDescription;
            document.getElementById('discount-start_date').textContent  = b.dataset.discountStart_date;
            document.getElementById('discount-end_date').textContent    = b.dataset.discountEnd_date;
        });

        // Fill the Edit modal from the clicked row's data, and point the form at the right record
        const discountEditModal = document.getElementById('discountEditModal');
        if (discountEditModal) {
            discountEditModal.addEventListener('show.bs.modal', function (event) {
                const b = event.relatedTarget;
                if (!b) return;
                document.getElementById('discountEditForm').action  = b.dataset.action || '';
                document.getElementById('edit-discount').value      = b.dataset.discount || '';
                document.getElementById('edit-description').value   = b.dataset.description || '';
                document.getElementById('edit-start_date').value    = b.dataset.start || '';
                document.getElementById('edit-end_date').value      = b.dataset.end || '';
            });
        }

        // Live search across cards
        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('discount-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#discount-list .qdisc-card').forEach(card => {
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
            const el = document.getElementById('discountCreateModal');
            if (el) new bootstrap.Modal(el).show();
        });
    </script>
    @endif

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'Discount {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-app-layout>
