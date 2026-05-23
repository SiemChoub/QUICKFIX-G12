<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.list-chrome')

    @php
        $allCount  = $payments->count();
        $noCount   = $payments->where('status', 'no')->count();
        $doneCount = $allCount - $noCount;
        $months    = $payments->pluck('datepay')->filter()->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-M'))->unique()->values();
    @endphp

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
                <div class="qlist-search">
                    <i class='bx bx-search-alt'></i>
                    <input type="text" id="search-input" placeholder="Search payments…" aria-label="Search payments">
                </div>
                @can('Payment create')
                    <a href="{{ route('admin.payments.create') }}" class="qlist-create">
                        <i class='bx bx-plus'></i><span>Create Payment</span>
                    </a>
                @endcan
            </div>
        </header>

        @can('Payment access')
        {{-- Stat filter chips + month filter --}}
        <div class="qpay-toolbar">
            <div class="qpay-stats">
                <button type="button" class="qpay-stat is-active" data-status="all">
                    <span class="qpay-stat__num">{{ $allCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-list-ul'></i> All</span>
                </button>
                <button type="button" class="qpay-stat qpay-stat--done" data-status="done">
                    <span class="qpay-stat__num">{{ $doneCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-check-circle'></i> Succeeded</span>
                </button>
                <button type="button" class="qpay-stat qpay-stat--no" data-status="no">
                    <span class="qpay-stat__num">{{ $noCount }}</span>
                    <span class="qpay-stat__lbl"><i class='bx bx-time-five'></i> Incomplete</span>
                </button>
            </div>

            <div class="dropdown qpay-month">
                <button class="qpay-month__btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-calendar'></i> <span id="month-label">All months</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end qpay-month__menu">
                    <li><a class="dropdown-item" href="#" data-value="all">All months</a></li>
                    @foreach ($months as $m)
                        <li><a class="dropdown-item" href="#" data-value="{{ $m }}">{{ $m }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="qpay-list" id="payment-list">
            @foreach ($payments as $i => $payment)
                @php
                    $customer = optional($users->where('id', $payment->fixer_id)->first());
                    $cname    = $customer->name ?? 'Unknown';
                    $parts    = preg_split('/\s+/', trim($cname));
                    $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    $month    = $payment->datepay ? \Carbon\Carbon::parse($payment->datepay)->format('Y-M') : '';
                    $done     = $payment->status !== 'no';
                @endphp
                <div class="qpay-card {{ $done ? 'qpay-card--done' : 'qpay-card--no' }}"
                     style="animation-delay: {{ $i * 45 }}ms"
                     data-status="{{ $done ? 'done' : 'no' }}" data-month="{{ $month }}"
                     data-search="{{ strtolower($cname . ' ' . $payment->total . ' ' . $month) }}">

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
                </div>
            @endforeach
        </div>

        <div class="qlist-empty" id="payment-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No payments match your filters.</p>
        </div>
        @endcan
    </div>

    <style>
        /* ===== Toolbar ===== */
        .qpay-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.4rem; }
        .qpay-stats { display: flex; gap: .7rem; flex-wrap: wrap; }
        .qpay-stat {
            display: flex; flex-direction: column; align-items: flex-start; gap: .15rem;
            background: #fff; border: 1.5px solid #eef0f4; border-radius: 14px;
            padding: .7rem 1.1rem; cursor: pointer; min-width: 120px;
            transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
        }
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

        @media (max-width: 720px) {
            .qpay-figure, .qpay-dates { width: 100%; }
            .qpay-status { margin-left: 0; }
        }
        @media (max-width: 560px) { .qlist-head__actions { width: 100%; } .qlist-search { flex: 1; min-width: 0; } }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function () {
            let fStatus = 'all', fMonth = 'all', fQuery = '';
            const cards = () => document.querySelectorAll('#payment-list .qpay-card');
            const empty = document.getElementById('payment-empty');

            function apply() {
                let shown = 0;
                cards().forEach(card => {
                    const okStatus = fStatus === 'all' || card.dataset.status === fStatus;
                    const okMonth  = fMonth === 'all'  || card.dataset.month === fMonth;
                    const okSearch = card.dataset.search.includes(fQuery);
                    const show = okStatus && okMonth && okSearch;
                    card.style.display = show ? '' : 'none';
                    if (show) shown++;
                });
                if (empty) empty.hidden = shown !== 0;
            }

            document.querySelectorAll('.qpay-stat').forEach(btn => btn.addEventListener('click', function () {
                document.querySelectorAll('.qpay-stat').forEach(b => b.classList.remove('is-active'));
                this.classList.add('is-active');
                fStatus = this.dataset.status;
                apply();
            }));

            document.querySelectorAll('.qpay-month__menu .dropdown-item').forEach(item => item.addEventListener('click', function (e) {
                e.preventDefault();
                fMonth = this.dataset.value;
                document.getElementById('month-label').textContent = fMonth === 'all' ? 'All months' : fMonth;
                apply();
            }));

            const input = document.getElementById('search-input');
            if (input) input.addEventListener('input', function () { fQuery = this.value.toLowerCase().trim(); apply(); });
        })();
    </script>

    @if(session('showAlertCreate'))
    <script>
        Swal.fire({ title: 'Payment created successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
    @if(session('showAlertNo'))
    <script>
        Swal.fire({ title: 'Nothing fixing for this month!', text: '{{ session("fail") }}', icon: 'warning', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
</x-app-layout>
