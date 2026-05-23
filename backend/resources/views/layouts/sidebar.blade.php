<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

@php
    $pendingBookings = 0;
    foreach ($bookings as $booking) {
        if ($booking['action'] == 'progress' || $booking['action'] == 'request') {
            $pendingBookings++;
        }
    }
    $payedCount    = $payments->where('status', 'done')->count();

    $isBookingActive = request()->routeIs('admin.requests.*')
        || request()->routeIs('admin.progresss.*')
        || request()->routeIs('admin.dones.*');
@endphp

<aside
    :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="qf-sidebar fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">

    {{-- Brand --}}
    <div class="qf-sidebar__brand">
        <a href="{{ route('admin.dashboard') }}" class="qf-brand">
            <span class="qf-brand__mark">
                <i class='bx bxs-wrench'></i>
            </span>
            <span class="qf-brand__text">
                <strong>QUICK</strong><span>FIX</span>
            </span>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="qf-nav">

        <p class="qf-nav__section">Main</p>

        <a href="{{ route('admin.dashboard') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.dashboard') ? 'is-active' : '' }}">
            <i class='bx bx-grid-alt qf-nav__icon'></i>
            <span class="qf-nav__label">Dashboard</span>
        </a>

        @canany(['Request access', 'Request delete', 'Progress access', 'Progress delete', 'Done access'])
        <a href="{{ route('admin.requests.index') }}"
           class="qf-nav__item {{ $isBookingActive ? 'is-active' : '' }}">
            <i class='bx bx-calendar-check qf-nav__icon'></i>
            <span class="qf-nav__label">Bookings</span>
            @if ($pendingBookings > 0)
                <span class="qf-badge">{{ $pendingBookings > 99 ? '99+' : $pendingBookings }}</span>
            @endif
        </a>
        @endcanany

        @canany(['Payment access', 'Payment create', 'Payment edit'])
        <a href="{{ route('admin.payments.index') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.payments.index') ? 'is-active' : '' }}">
            <i class='bx bx-credit-card qf-nav__icon'></i>
            <span class="qf-nav__label">Payment</span>
            @if ($payedCount > 0)
                <span class="qf-badge">{{ $payedCount > 99 ? '99+' : $payedCount }}</span>
            @endif
        </a>
        @endcanany

        <p class="qf-nav__section">Access Control</p>

        @canany(['User access', 'User add', 'User edit', 'User delete'])
        <a href="{{ route('admin.users.index') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.users.index') ? 'is-active' : '' }}">
            <i class='bx bx-user qf-nav__icon'></i>
            <span class="qf-nav__label">User</span>
        </a>
        @endcanany

        <p class="qf-nav__section">Catalog</p>

        @canany(['Category access', 'Category add', 'Category edit', 'Category delete'])
        <a href="{{ route('admin.categories.index') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.categories.index') ? 'is-active' : '' }}">
            <i class='bx bx-category qf-nav__icon'></i>
            <span class="qf-nav__label">Categories</span>
        </a>
        @endcanany

        @canany(['Service access', 'Service add', 'Service edit', 'Service delete'])
        <a href="{{ route('admin.services.index') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.services.index') ? 'is-active' : '' }}">
            <i class='bx bx-briefcase qf-nav__icon'></i>
            <span class="qf-nav__label">Services</span>
        </a>
        @endcanany

        @canany(['Discount access', 'Discount add', 'Discount edit', 'Discount delete'])
        <a href="{{ route('admin.discounts.index') }}"
           class="qf-nav__item {{ Route::currentRouteNamed('admin.discounts.index') ? 'is-active' : '' }}">
            <i class='bx bx-purchase-tag qf-nav__icon'></i>
            <span class="qf-nav__label">Discount</span>
        </a>
        @endcanany

        @canany([
            'Mail access', 'Mail edit',
            'Role access', 'Role add', 'Role edit', 'Role delete',
            'Permission access', 'Permission add', 'Permission edit', 'Permission delete',
        ])
        <p class="qf-nav__section">System</p>

        <a href="{{ route('admin.mail.index') }}"
           class="qf-nav__item {{ request()->routeIs('admin.mail.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'is-active' : '' }}">
            <i class='bx bx-cog qf-nav__icon'></i>
            <span class="qf-nav__label">Setting</span>
        </a>
        @endcanany
    </nav>

    {{-- Footer profile --}}
    @auth
    <div class="qf-sidebar__footer">
        <div class="qf-user">
            <div class="qf-user__avatar">
                @if (Auth::user()->profile)
                    <img src="{{ asset('storage/' . Auth::user()->profile) }}"
                         onerror="this.onerror=null;this.src='{{ asset(Auth::user()->profile) }}';"
                         alt="{{ Auth::user()->name }}">
                @else
                    <i class='bx bxs-user-circle'></i>
                @endif
            </div>
            <div class="qf-user__info">
                <span class="qf-user__name">{{ Auth::user()->name }}</span>
                <span class="qf-user__role">{{ ucfirst(Auth::user()->role ?? 'admin') }}</span>
            </div>
        </div>
    </div>
    @endauth
</aside>

<style>
    .qf-sidebar {
        background: linear-gradient(180deg, #111827 0%, #0b1220 100%);
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 16px rgba(0, 0, 0, 0.18);
        overflow: hidden;
    }

    /* ----- Brand ----- */
    .qf-sidebar__brand {
        padding: 1.1rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }
    .qf-brand {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        text-decoration: none;
        color: #fff;
    }
    .qf-brand:hover { color: #fff; }
    .qf-brand__mark {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        border-radius: 10px;
        display: grid; place-items: center;
        color: #fff;
        font-size: 1.4rem;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.35);
    }
    .qf-brand__text {
        font-size: 1.15rem;
        letter-spacing: 0.5px;
        line-height: 1;
    }
    .qf-brand__text strong { color: #fff; }
    .qf-brand__text span   { color: #f59e0b; font-weight: 700; }

    /* ----- Nav ----- */
    .qf-nav {
        flex: 1 1 auto;
        overflow-y: auto;
        padding: 0.5rem 0.6rem 1rem;
    }
    .qf-nav::-webkit-scrollbar { width: 5px; }
    .qf-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 3px; }

    .qf-nav__section {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6b7280;
        padding: 0.85rem 0.85rem 0.4rem;
        margin: 0;
    }

    .qf-nav__item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.6rem 0.85rem;
        border-radius: 9px;
        color: #cbd5e1;
        font-size: 0.88rem;
        font-weight: 500;
        text-decoration: none;
        transition: background .15s ease, color .15s ease, transform .15s ease;
        margin-bottom: 2px;
        width: 100%;
        background: transparent;
        border: 0;
        text-align: left;
        position: relative;
    }
    .qf-nav__item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }
    .qf-nav__item.is-active {
        background: linear-gradient(90deg, rgba(245, 158, 11, 0.18), rgba(245, 158, 11, 0.04));
        color: #fbbf24;
    }
    .qf-nav__item.is-active::before {
        content: '';
        position: absolute;
        left: -0.6rem;
        top: 8px;
        bottom: 8px;
        width: 3px;
        background: #f59e0b;
        border-radius: 0 3px 3px 0;
    }

    .qf-nav__icon { font-size: 1.2rem; flex-shrink: 0; }
    .qf-nav__label { flex: 1 1 auto; }
    .qf-nav__chev {
        font-size: 1.1rem;
        transition: transform .2s ease;
    }
    .qf-nav__chev--open { transform: rotate(180deg); }

    /* ----- Sub menu ----- */
    .qf-submenu {
        list-style: none;
        margin: 4px 0 6px;
        padding: 0 0 0 1.2rem;
        border-left: 1px dashed rgba(255, 255, 255, 0.08);
        margin-left: 1rem;
    }
    .qf-subnav__item {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.45rem 0.7rem;
        border-radius: 7px;
        color: #94a3b8;
        font-size: 0.82rem;
        text-decoration: none;
        transition: background .15s ease, color .15s ease;
        margin-bottom: 2px;
    }
    .qf-subnav__item:hover {
        background: rgba(255, 255, 255, 0.04);
        color: #fff;
    }
    .qf-subnav__item.is-active {
        color: #fbbf24;
        background: rgba(245, 158, 11, 0.1);
    }
    .qf-subnav__icon { font-size: 1rem; flex-shrink: 0; }

    /* ----- Badge ----- */
    .qf-badge {
        background: #f59e0b;
        color: #111827;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 999px;
        line-height: 1.2;
        margin-left: auto;
    }
    .qf-badge--sm { font-size: 0.6rem; padding: 1px 6px; }

    /* ----- Footer ----- */
    .qf-sidebar__footer {
        padding: 0.75rem 0.85rem 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }
    .qf-user {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.5rem 0.6rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.04);
    }
    .qf-user__avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: #1f2937;
        display: grid; place-items: center;
        color: #6b7280;
        font-size: 1.6rem;
        flex-shrink: 0;
    }
    .qf-user__avatar img { width: 100%; height: 100%; object-fit: cover; }
    .qf-user__info { display: flex; flex-direction: column; min-width: 0; }
    .qf-user__name {
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .qf-user__role {
        color: #9ca3af;
        font-size: 0.7rem;
        text-transform: capitalize;
    }
</style>
