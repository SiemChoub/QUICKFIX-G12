<x-app-layout>

    @php
        // Render a value or an em-dash when empty. Keeps every field row consistent.
        $show = fn ($v) => filled($v) ? $v : '—';
        $date = function ($v, $f = 'd M Y, H:i') {
            if (blank($v)) return '—';
            try { return \Illuminate\Support\Carbon::parse($v)->format($f); }
            catch (\Throwable $e) { return (string) $v; }
        };
        $avatar = fn ($u, $bg) => $u && filled($u->profile)
            ? $u->profile
            : 'https://ui-avatars.com/api/?name=' . urlencode($u?->name ?? 'User') . "&background={$bg}&color=fff&bold=true";
    @endphp

    <div class="container-fluid px-4 py-4 qf-detail">
        {{-- Header --}}
        <div class="qf-detail-head">
            <a href="{{ $context['back'] }}" class="qf-back">
                <i class='bx bx-arrow-back'></i> Back to {{ $context['tab'] }}
            </a>
            <div class="qf-detail-title">
                <h4 class="mb-0"><i class='bx {{ $context['icon'] }}'></i> Booking Detail <span class="qf-id">#{{ $booking->id }}</span></h4>
                <div class="qf-badges">
                    @if ($booking->type === 'immediately')
                        <span class="qf-tag qf-tag-now"><i class='bx bxs-user-voice'></i> Immediately</span>
                    @else
                        <span class="qf-tag qf-tag-deadline"><i class='bx bxs-calendar'></i> Deadline</span>
                    @endif
                    <span class="qf-tag qf-tag-status">{{ ucfirst($progress?->action ?? $booking->action) }}</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Customer --}}
            <div class="col-lg-6">
                <div class="qf-card h-100">
                    <div class="qf-card-head"><i class='bx bxs-user'></i> Customer</div>
                    <div class="qf-card-body">
                        <div class="qf-person">
                            <img src="{{ $avatar($customer, 'f59e0b') }}"
                                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($customer?->name ?? 'User') }}&background=f59e0b&color=fff&bold=true'"
                                 class="qf-person-avatar" alt="customer">
                            <div>
                                <div class="qf-person-name">{{ $show($customer?->name ?? null) }}</div>
                                <div class="qf-person-sub">{{ $show($customer?->email ?? null) }}</div>
                            </div>
                        </div>
                        <dl class="qf-fields">
                            <div><dt><i class='bx bxs-user-detail'></i> Role</dt><dd>{{ $show($customer?->role ?? null) }}</dd></div>
                            <div><dt><i class='bx bxs-phone'></i> Phone</dt><dd>{{ $show($customer?->phone ?? null) }}</dd></div>
                            <div><dt><i class='bx bxs-map'></i> Address</dt><dd>{{ $show($customer?->address ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-briefcase'></i> Career</dt><dd>{{ $show($customer?->career ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-map-pin'></i> Location</dt><dd>{{ $show($customer?->location ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-calendar-plus'></i> Joined</dt><dd>{{ $date($customer?->created_at ?? null) }}</dd></div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Fixer --}}
            <div class="col-lg-6">
                <div class="qf-card h-100">
                    <div class="qf-card-head"><i class='bx bxs-wrench'></i> Fixer</div>
                    <div class="qf-card-body">
                        @if ($fixer)
                            <div class="qf-person">
                                <img src="{{ $avatar($fixer, '0ea5e9') }}"
                                     onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($fixer->name ?? 'Fixer') }}&background=0ea5e9&color=fff&bold=true'"
                                     class="qf-person-avatar" alt="fixer">
                                <div>
                                    <div class="qf-person-name">{{ $show($fixer->name) }}</div>
                                    <div class="qf-person-sub">{{ $show($fixer->email) }}</div>
                                </div>
                            </div>
                            <dl class="qf-fields">
                                <div><dt><i class='bx bxs-user-detail'></i> Role</dt><dd>{{ $show($fixer->role) }}</dd></div>
                                <div><dt><i class='bx bxs-phone'></i> Phone</dt><dd>{{ $show($fixer->phone) }}</dd></div>
                                <div><dt><i class='bx bxs-map'></i> Address</dt><dd>{{ $show($fixer->address) }}</dd></div>
                                <div><dt><i class='bx bx-briefcase'></i> Career</dt><dd>{{ $show($fixer->career) }}</dd></div>
                                <div><dt><i class='bx bx-map-pin'></i> Location</dt><dd>{{ $show($fixer->location) }}</dd></div>
                                <div><dt><i class='bx bx-calendar-plus'></i> Joined</dt><dd>{{ $date($fixer->created_at) }}</dd></div>
                            </dl>
                        @else
                            <div class="qf-empty"><i class='bx bx-user-x'></i> No fixer assigned to this booking yet.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Service --}}
            <div class="col-lg-6">
                <div class="qf-card h-100">
                    <div class="qf-card-head"><i class='bx bxs-star'></i> Service</div>
                    <div class="qf-card-body">
                        @if ($service)
                            <div class="qf-service">
                                @if (filled($service->image))
                                    <img src="{{ $service->image }}" class="qf-service-img" alt="{{ $service->name }}">
                                @endif
                                <div class="qf-service-meta">
                                    <div class="qf-person-name">{{ $show($service->name) }}</div>
                                    <div class="qf-price"><i class='bx bx-dollar'></i> {{ filled($service->price) ? number_format($service->price, 2) : '—' }}</div>
                                </div>
                            </div>
                            <dl class="qf-fields">
                                <div class="qf-field-wide"><dt><i class='bx bx-text'></i> Description</dt><dd>{{ $show($service->description) }}</dd></div>
                                <div><dt><i class='bx bx-category'></i> Category ID</dt><dd>{{ $show($service->category_id) }}</dd></div>
                                <div><dt><i class='bx bx-hash'></i> Service ID</dt><dd>{{ $show($service->id) }}</dd></div>
                            </dl>
                        @else
                            <div class="qf-empty"><i class='bx bx-wrench'></i> No service selected for this booking.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Request / Schedule details --}}
            <div class="col-lg-6">
                <div class="qf-card h-100">
                    <div class="qf-card-head"><i class='bx bx-detail'></i> Request Details</div>
                    <div class="qf-card-body">
                        <dl class="qf-fields">
                            <div class="qf-field-wide"><dt><i class='bx bxs-message-rounded-dots'></i> Message</dt><dd>{{ $show($detail?->message ?? null) }}</dd></div>
                            <div>
                                <dt><i class='bx bxs-calendar-check'></i> {{ $booking->type === 'immediately' ? 'Deadline' : 'Scheduled date' }}</dt>
                                <dd>{{ $booking->type === 'immediately' ? 'Fix now' : $date($detail?->date ?? null, 'd M Y') }}</dd>
                            </div>
                            <div><dt><i class='bx bx-purchase-tag'></i> Promotion ID</dt><dd>{{ $show($detail?->promotion_id ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-current-location'></i> Latitude</dt><dd>{{ $show($detail?->latitude ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-current-location'></i> Longitude</dt><dd>{{ $show($detail?->longitude ?? null) }}</dd></div>
                            <div><dt><i class='bx bx-calendar'></i> Requested at</dt><dd>{{ $date($detail?->created_at ?? null) }}</dd></div>
                        </dl>
                        @if ($detail && filled($detail?->latitude) && filled($detail?->longitude))
                            <a class="qf-map-link" target="_blank" rel="noopener"
                               href="https://www.google.com/maps?q={{ $detail?->latitude }},{{ $detail?->longitude }}">
                                <i class='bx bx-map'></i> Open location in Google Maps
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Booking meta --}}
            <div class="col-12">
                <div class="qf-card">
                    <div class="qf-card-head"><i class='bx bx-info-circle'></i> Booking Information</div>
                    <div class="qf-card-body">
                        <dl class="qf-fields qf-fields-grid">
                            <div><dt>Booking ID</dt><dd>#{{ $booking->id }}</dd></div>
                            <div><dt>Type</dt><dd>{{ ucfirst($booking->type) }}</dd></div>
                            <div><dt>Booking status</dt><dd>{{ ucfirst($show($booking->action)) }}</dd></div>
                            <div><dt>Detail record ID</dt><dd>{{ $show($booking->booking_type_id) }}</dd></div>
                            @if ($progress)
                                <div><dt>Progress status</dt><dd>{{ ucfirst($show($progress->action)) }}</dd></div>
                                <div><dt>Progress updated</dt><dd>{{ $date($progress->updated_at) }}</dd></div>
                            @endif
                            <div><dt>Created at</dt><dd>{{ $date($booking->created_at) }}</dd></div>
                            <div><dt>Updated at</dt><dd>{{ $date($booking->updated_at) }}</dd></div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .qf-detail { max-width: 1100px; }
        .qf-detail-head { margin-bottom: 1.1rem; }
        .qf-back {
            display: inline-flex; align-items: center; gap: .4rem;
            color: #6b7280; text-decoration: none; font-weight: 600; font-size: .9rem;
            margin-bottom: .6rem; transition: color .15s ease;
        }
        .qf-back:hover { color: #f59e0b; }
        .qf-detail-title {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: .6rem;
        }
        .qf-detail-title h4 { color: #1b1f24; font-weight: 700; display: flex; align-items: center; gap: .5rem; }
        .qf-detail-title h4 i { color: #f59e0b; }
        .qf-id { color: #9ca3af; font-weight: 600; }
        .qf-badges { display: flex; gap: .4rem; flex-wrap: wrap; }

        .qf-tag {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .3rem .7rem; border-radius: 999px;
            font-size: .78rem; font-weight: 700;
        }
        .qf-tag-now      { background: #fef3c7; color: #b45309; }
        .qf-tag-deadline { background: #e0f2fe; color: #0369a1; }
        .qf-tag-status   { background: #1b1f24; color: #fff; }

        .qf-card {
            background: #fff; border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            overflow: hidden;
        }
        .qf-card-head {
            display: flex; align-items: center; gap: .5rem;
            padding: .85rem 1.1rem; font-weight: 700; color: #1b1f24;
            border-bottom: 1px solid #f1f1f3;
        }
        .qf-card-head i { color: #f59e0b; font-size: 1.15rem; }
        .qf-card-body { padding: 1.1rem; }

        .qf-person { display: flex; align-items: center; gap: .9rem; margin-bottom: 1rem; }
        .qf-person-avatar { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #f59e0b; }
        .qf-person-name { font-weight: 700; color: #1b1f24; font-size: 1.02rem; }
        .qf-person-sub { color: #6b7280; font-size: .85rem; word-break: break-all; }

        .qf-fields { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem 1.2rem; margin: 0; }
        .qf-fields-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
        .qf-fields > div { display: flex; flex-direction: column; gap: .15rem; }
        .qf-field-wide { grid-column: 1 / -1; }
        .qf-fields dt {
            display: flex; align-items: center; gap: .35rem;
            font-size: .72rem; text-transform: uppercase; letter-spacing: .03em;
            color: #9ca3af; font-weight: 700;
        }
        .qf-fields dt i { color: #f59e0b; font-size: .95rem; }
        .qf-fields dd { margin: 0; color: #1b1f24; font-weight: 600; font-size: .92rem; word-break: break-word; }

        .qf-service { display: flex; align-items: center; gap: .9rem; margin-bottom: 1rem; }
        .qf-service-img { width: 72px; height: 72px; border-radius: 10px; object-fit: cover; }
        .qf-price { color: #16a34a; font-weight: 700; }

        .qf-empty { color: #9ca3af; font-weight: 600; display: flex; align-items: center; gap: .5rem; padding: 1rem 0; }
        .qf-empty i { font-size: 1.3rem; }

        .qf-map-link {
            display: inline-flex; align-items: center; gap: .4rem; margin-top: .9rem;
            color: #0369a1; font-weight: 600; font-size: .88rem; text-decoration: none;
        }
        .qf-map-link:hover { text-decoration: underline; }

        @media (max-width: 540px) {
            .qf-fields { grid-template-columns: 1fr; }
        }
    </style>
</x-app-layout>
