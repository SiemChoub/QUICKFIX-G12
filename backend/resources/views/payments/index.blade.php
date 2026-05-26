<x-app-layout>
    @include('partials.list-chrome')

    <div class="qlist-page">
        <header class="qlist-head">
            <div class="qlist-head__title">
                <span class="qlist-head__icon"><i class='bx bxs-credit-card'></i></span>
                <span>
                    <h1>Payment Management</h1>
                    <p>{{ $allCount }} {{ \Illuminate\Support\Str::plural('payment', $allCount) }} recorded</p>
                </span>
            </div>
            <div class="qlist-head__actions">
                <form method="GET" class="qlist-search" role="search" style="margin:0">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" name="q" value="{{ $searchQ ?? '' }}" placeholder="Search payments…" aria-label="Search payments">
                    @if(!empty($activeStatus))<input type="hidden" name="status" value="{{ $activeStatus }}">@endif
                    @if(!empty($activeMonth))<input type="hidden" name="month" value="{{ $activeMonth }}">@endif
                    @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                </form>
                @can('Payment create')
                    <button type="button" class="qlist-create" data-bs-toggle="modal" data-bs-target="#paymentCreateModal">
                        <i class='bx bx-plus'></i><span>Create Payment</span>
                    </button>
                @endcan
            </div>
        </header>

        @can('Payment access')
        {{-- Stat filter chips + month filter --}}
        <div class="qpay-toolbar">
            <div class="qpay-stats">
                <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}"
                   class="qpay-stat {{ empty($activeStatus) ? 'is-active' : '' }}">
                    <span class="qpay-stat__num">{{ $allCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-list-ul'></i> All</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'done', 'page' => null]) }}"
                   class="qpay-stat qpay-stat--done {{ ($activeStatus ?? '') === 'done' ? 'is-active' : '' }}">
                    <span class="qpay-stat__num">{{ $doneCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-check-circle'></i> Succeeded</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'no', 'page' => null]) }}"
                   class="qpay-stat qpay-stat--no {{ ($activeStatus ?? '') === 'no' ? 'is-active' : '' }}">
                    <span class="qpay-stat__num">{{ $noCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-time-five'></i> Incomplete</span>
                </a>
            </div>

            <div class="dropdown qpay-month">
                <button class="qpay-month__btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-calendar'></i> <span>{{ $activeMonth ?? 'All months' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end qpay-month__menu">
                    <li><a class="dropdown-item {{ empty($activeMonth) ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['month' => null, 'page' => null]) }}">All months</a></li>
                    @foreach ($months as $m)
                        <li><a class="dropdown-item {{ ($activeMonth ?? '') === $m ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['month' => $m, 'page' => null]) }}">{{ $m }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="qpay-list" id="payment-list">
            @forelse ($payments as $i => $payment)
                @php
                    $customer = optional($users->where('id', $payment->fixer_id)->first());
                    $cname    = $customer->name ?? 'Unknown';
                    $parts    = preg_split('/\s+/', trim($cname));
                    $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    $month    = $payment->datepay ? \Carbon\Carbon::parse($payment->datepay)->format('Y-M') : '';
                    $done     = $payment->status !== 'no';
                @endphp
                <div class="qpay-card {{ $done ? 'qpay-card--done' : 'qpay-card--no' }}"
                     style="animation-delay: {{ $i * 45 }}ms">

                    <span class="qpay-avatar">{{ $initials }}</span>

                    <div class="qpay-customer">
                        <span class="qpay-name">{{ $cname }}</span>
                        <span class="qpay-sub"><i class='bx bx-wrench'></i> {{ $payment->number_fixed }} {{ \Illuminate\Support\Str::plural('fix', (int) $payment->number_fixed) }}</span>
                    </div>

                    <div class="qpay-figure">
                        <span class="qpay-figure__lbl">Rate</span>
                        <span class="qpay-figure__val">{{ $payment->amount }}$</span>
                    </div>

                    <div class="qpay-figure qpay-figure--total">
                        <span class="qpay-figure__lbl">Total</span>
                        <span class="qpay-figure__val">{{ $payment->total }}$</span>
                    </div>

                    <div class="qpay-dates">
                        <span><i class='bx bx-calendar'></i> {{ $payment->datepay ? \Carbon\Carbon::parse($payment->datepay)->format('M j, Y') : '—' }}</span>
                        <i class='bx bx-right-arrow-alt'></i>
                        <span><i class='bx bx-calendar-check'></i> {{ $payment->dateline ? \Carbon\Carbon::parse($payment->dateline)->format('M j, Y') : '—' }}</span>
                    </div>

                    <span class="qpay-status">
                        @if($done)
                            <i class='bx bx-check-circle'></i> Succeeded
                        @else
                            <i class='bx bx-time-five'></i> Incomplete
                        @endif
                    </span>

                    @can('Payment edit')
                        <button type="button" class="qlist-act qlist-act--edit"
                            data-bs-toggle="modal" data-bs-target="#paymentEditModal"
                            data-action="{{ route('admin.payments.update', $payment->id) }}"
                            data-amount="{{ $payment->amount }}"
                            data-datepay="{{ $payment->datepay ? \Carbon\Carbon::parse($payment->datepay)->format('Y-m-d') : '' }}"
                            data-dateline="{{ $payment->dateline ? \Carbon\Carbon::parse($payment->dateline)->format('Y-m-d') : '' }}"
                            data-description="{{ $payment->description }}">
                            <i class='bx bx-edit-alt'></i><span>Edit</span>
                        </button>
                    @endcan
                </div>
            @empty
                <div class="qlist-empty">
                    <i class='bx bx-search-alt'></i>
                    <p>No payments match your filters.</p>
                </div>
            @endforelse
        </div>

        @include('booking._pagination', ['paginator' => $payments, 'default' => 20])
        @endcan
    </div>

    {{-- Create modal --}}
    @can('Payment create')
    <div class="modal fade" id="paymentCreateModal" tabindex="-1" aria-labelledby="paymentCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentCreateModalLabel"><i class='bx bxs-credit-card'></i> Create Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.payments.store') }}">
                    @csrf
                    <div class="modal-body qpay-form">
                        <p class="qpay-form__note"><i class='bx bx-info-circle'></i> Generates payslips for every fixer with completed jobs in the chosen pay-date month.</p>
                        @include('payments._form-fields', ['uid' => 'create'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qpay-btn qpay-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qpay-btn qpay-btn--primary"><i class='bx bx-check'></i> Create Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- Edit modal (same form component as Create; filled via JS from the card's data-* attributes) --}}
    @can('Payment edit')
    <div class="modal fade" id="paymentEditModal" tabindex="-1" aria-labelledby="paymentEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content qlist-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentEditModalLabel"><i class='bx bx-edit-alt'></i> Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="paymentEditForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body qpay-form">
                        @include('payments._form-fields', ['uid' => 'edit'])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="qpay-btn qpay-btn--ghost" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="qpay-btn qpay-btn--primary"><i class='bx bx-check'></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <style>
        /* ===== Toolbar ===== */
        .qpay-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.4rem; }
        .qpay-stats { display: flex; gap: .7rem; flex-wrap: wrap; }
        .qpay-stat {
            display: flex; flex-direction: column; align-items: flex-start; gap: .15rem;
            background: #fff; border: 1.5px solid #eef0f4; border-radius: 14px;
            padding: .7rem 1.1rem; cursor: pointer; min-width: 120px;
            text-decoration: none; color: inherit;
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }
        .qpay-stat:hover { color: inherit; }
        .qpay-month__menu .dropdown-item.active { background: #f59e0b; color: #fff; }
        .qpay-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(17,24,39,.07); }
        .qpay-stat__num { font-size: 1.5rem; font-weight: 800; color: #111827; line-height: 1; }
        .qpay-stat__lbl { display: inline-flex; align-items: center; gap: .3rem; font-size: .78rem; font-weight: 600; color: #6b7280; }
        .qpay-stat.is-active { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.14); }
        .qpay-stat--done.is-active { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.16); }
        .qpay-stat--done.is-active .qpay-stat__num { color: #059669; }
        .qpay-stat--no.is-active { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.16); }
        .qpay-stat--no.is-active .qpay-stat__num { color: #d97706; }

        .qpay-month__btn {
            display: inline-flex; align-items: center; gap: .45rem;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: .6rem 1rem;
            font-size: .88rem; font-weight: 600; color: #374151; cursor: pointer;
        }
        .qpay-month__btn:hover { border-color: #f59e0b; }
        .qpay-month__menu { border: 0; border-radius: 12px; box-shadow: 0 12px 32px rgba(0,0,0,.14); max-height: 320px; overflow-y: auto; }
        .qpay-month__menu .dropdown-item { border-radius: 8px; font-size: .85rem; padding: .45rem .8rem; }
        .qpay-month__menu .dropdown-item:active { background: #f59e0b; }

        /* ===== Payment cards ===== */
        .qpay-list { display: flex; flex-direction: column; gap: .6rem; }
        .qpay-card {
            display: flex; align-items: center; gap: 1.1rem;
            background: #fff; border: 1px solid #eef0f4; border-radius: 14px; padding: .85rem 1.2rem;
            position: relative; overflow: hidden; flex-wrap: wrap;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: qpay-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qpay-in { to { opacity: 1; transform: translateY(0); } }
        .qpay-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--c, #94a3b8); }
        .qpay-card:hover { border-color: #e2e5ea; box-shadow: 0 10px 26px rgba(17,24,39,.08); transform: translateY(-2px); }
        .qpay-card--done { --c: #10b981; }
        .qpay-card--no   { --c: #f59e0b; }

        .qpay-avatar {
            width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
            display: grid; place-items: center; font-weight: 700; font-size: .9rem;
            color: #475569; background: #f1f5f9; border: 2px solid var(--c, #94a3b8);
        }
        .qpay-customer { display: flex; flex-direction: column; min-width: 140px; flex: 1; }
        .qpay-name { font-size: .96rem; font-weight: 700; color: #1f2937; }
        .qpay-sub { display: inline-flex; align-items: center; gap: .3rem; font-size: .76rem; color: #9ca3af; margin-top: .1rem; }

        .qpay-figure { display: flex; flex-direction: column; gap: .1rem; min-width: 64px; }
        .qpay-figure__lbl { font-size: .68rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
        .qpay-figure__val { font-size: .95rem; font-weight: 700; color: #374151; }
        .qpay-figure--total .qpay-figure__val { font-size: 1.15rem; font-weight: 800; color: #d97706; }

        .qpay-dates { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: #6b7280; flex-wrap: wrap; }
        .qpay-dates i.bx-right-arrow-alt { color: #cbd5e1; font-size: 1.1rem; }
        .qpay-dates span { display: inline-flex; align-items: center; gap: .3rem; }

        .qpay-status {
            display: inline-flex; align-items: center; gap: .35rem; margin-left: auto;
            font-size: .76rem; font-weight: 700; padding: .35rem .8rem; border-radius: 999px; white-space: nowrap;
        }
        .qpay-card--done .qpay-status { color: #059669; background: #ecfdf5; }
        .qpay-card--no   .qpay-status { color: #d97706; background: #fff7ed; }
        .qpay-status i { font-size: .95rem; }

        /* ===== Create/Edit form (inside modal) ===== */
        .qpay-form { display: flex; flex-direction: column; gap: 1rem; }
        .qpay-form__note {
            display: flex; align-items: center; gap: .4rem; margin: 0;
            font-size: .8rem; color: #b45309; background: #fff7ed; border: 1px solid #fed7aa;
            padding: .55rem .8rem; border-radius: 10px;
        }
        .qpay-field { display: flex; flex-direction: column; gap: .35rem; }
        .qpay-field label { font-size: .82rem; font-weight: 600; color: #374151; }
        .qpay-field input, .qpay-field textarea {
            width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .6rem .8rem;
            font-size: .9rem; color: #111827; outline: 0; background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qpay-field input:focus, .qpay-field textarea:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qpay-field textarea { resize: vertical; }
        .qpay-field__error { color: #e11d48; font-size: .75rem; }
        .qpay-field-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
        .qlist-modal .modal-footer { border-top: 1px solid #f1f5f9; gap: .5rem; }
        .qpay-btn {
            display: inline-flex; align-items: center; gap: .4rem; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 10px; border: 1px solid transparent; cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }
        .qpay-btn i { font-size: 1.1rem; }
        .qpay-btn--ghost { background: #f1f5f9; color: #475569; }
        .qpay-btn--ghost:hover { background: #e2e8f0; }
        .qpay-btn--primary { background: linear-gradient(135deg, #f59e0b, #f97316); color: #fff; box-shadow: 0 6px 16px rgba(245,158,11,.32); }
        .qpay-btn--primary:hover { filter: brightness(1.05); }

        @media (max-width: 720px) {
            .qpay-figure, .qpay-dates { width: 100%; }
            .qpay-status { margin-left: 0; }
            .qpay-field-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 560px) { .qlist-head__actions { width: 100%; } .qlist-search { flex: 1; min-width: 0; } }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fill the Edit modal from the clicked card's data, and point the form at the right record
        const paymentEditModal = document.getElementById('paymentEditModal');
        if (paymentEditModal) {
            paymentEditModal.addEventListener('show.bs.modal', function (event) {
                const b = event.relatedTarget;
                if (!b) return;
                document.getElementById('paymentEditForm').action  = b.dataset.action || '';
                document.getElementById('edit-amount').value       = b.dataset.amount || '';
                document.getElementById('edit-datepay').value      = b.dataset.datepay || '';
                document.getElementById('edit-dateline').value     = b.dataset.dateline || '';
                document.getElementById('edit-description').value  = b.dataset.description || '';
            });
        }
    </script>

    @if(session('showAlertCreate'))
    <script>
        Swal.fire({ title: 'Payment created successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
    @if(session('showAlertEdit'))
    <script>
        Swal.fire({ title: 'Payment edited successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
    @if(session('showAlertNo'))
    <script>
        Swal.fire({ title: 'Nothing fixing for this month!', text: '{{ session("fail") }}', icon: 'warning', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
</x-app-layout>
