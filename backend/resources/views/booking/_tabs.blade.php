{{-- Booking section tabs: Request / In Progress / Done.
     Counts use the globally-shared $bookings and $FixingProgress collections
     (same source the sidebar uses), so this works on all three pages. --}}
@php
    $reqCount  = isset($bookings) ? $bookings->where('action', 'request')->count() : 0;
    $progCount = isset($FixingProgress) ? $FixingProgress->where('action', 'progress')->count() : 0;
    $doneCount = isset($FixingProgress) ? $FixingProgress->where('action', 'done')->count() : 0;
@endphp

<div class="qf-tabs">
    @canany(['Request access', 'Request delete'])
    <a href="{{ route('admin.requests.index') }}"
       class="qf-tab {{ request()->routeIs('admin.requests.*') ? 'is-active' : '' }}">
        <i class='bx bx-receipt'></i>
        <span>Requests</span>
        <span class="qf-tab-count">{{ $reqCount }}</span>
    </a>
    @endcanany

    @canany(['Progress access', 'Progress delete'])
    <a href="{{ route('admin.progresss.index') }}"
       class="qf-tab {{ request()->routeIs('admin.progresss.*') ? 'is-active' : '' }}">
        <i class='bx bx-loader-circle'></i>
        <span>In Progress</span>
        <span class="qf-tab-count">{{ $progCount }}</span>
    </a>
    @endcanany

    @can('Done access')
    <a href="{{ route('admin.dones.index') }}"
       class="qf-tab {{ request()->routeIs('admin.dones.*') ? 'is-active' : '' }}">
        <i class='bx bx-check-circle'></i>
        <span>Done</span>
        <span class="qf-tab-count">{{ $doneCount }}</span>
    </a>
    @endcan
</div>

<style>
    .qf-tabs {
        display: flex; gap: .4rem; flex-wrap: wrap;
        background: #fff; padding: .4rem; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        margin-bottom: 1.2rem;
    }
    .qf-tab {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem; border-radius: 10px;
        color: #6b7280; font-weight: 600; font-size: .9rem; text-decoration: none;
        transition: background .2s ease, color .2s ease, box-shadow .2s ease;
    }
    .qf-tab:hover { background: #f6f7f9; color: #374151; }
    .qf-tab i { font-size: 1.2rem; }
    .qf-tab.is-active {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #1b1f24; box-shadow: 0 4px 12px rgba(245, 158, 11, .3);
    }
    .qf-tab-count {
        background: rgba(0, 0, 0, .08); color: inherit;
        font-size: .7rem; font-weight: 700; padding: .1rem .5rem;
        border-radius: 999px; min-width: 20px; text-align: center;
    }
    .qf-tab.is-active .qf-tab-count { background: rgba(0, 0, 0, .18); }
</style>
