{{-- Booking section tabs: Request / In Progress / Done, with the
     Immediately / Deadline filter buttons on the same row (start & end).
     Counts use the globally-shared $bookings and $FixingProgress collections
     (same source the sidebar uses), so this works on all three pages.
     The #immediately / #dead buttons are wired up by per-page scripts. --}}
@php
    $reqCount  = isset($bookings) ? $bookings->where('action', 'request')->count() : 0;
    $progCount = isset($FixingProgress) ? $FixingProgress->where('action', 'progress')->count() : 0;
    $doneCount = isset($FixingProgress) ? $FixingProgress->where('action', 'done')->count() : 0;
@endphp

<div class="qf-tabs">
    <div class="qf-tabs__group">
        <span class="qf-tab-slider" aria-hidden="true"></span>
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

    <div class="qf-tabs__filters">
        <button id="immediately" type="button" class="qf-filter-btn">
            <i class='bx bxs-user-voice'></i>
            <span>Immediately</span>
        </button>
        <button id="dead" type="button" class="qf-filter-btn">
            <i class='bx bxs-calendar'></i>
            <span>Deadline</span>
        </button>
    </div>
</div>

<style>
    .qf-tabs {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
        background: #fff; padding: .4rem; border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        margin-bottom: 1.2rem;
    }
    .qf-tabs__group { display: flex; gap: .4rem; flex-wrap: wrap; position: relative; }

    /* Sliding pill that animates behind the tabs */
    .qf-tab-slider {
        position: absolute; top: 0; left: 0; height: 100%; width: 0;
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        border-radius: 10px; box-shadow: 0 4px 12px rgba(245, 158, 11, .3);
        z-index: 0; opacity: 0;
        transition: left .32s cubic-bezier(.4, 0, .2, 1), width .32s cubic-bezier(.4, 0, .2, 1),
                    top .25s ease, height .25s ease, opacity .2s ease;
    }

    .qf-tab {
        position: relative; z-index: 1;
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem; border-radius: 10px;
        color: #6b7280; font-weight: 600; font-size: .9rem; text-decoration: none;
        transition: color .2s ease;
    }
    .qf-tab:hover { color: #1b1f24; }
    .qf-tab i { font-size: 1.2rem; }
    .qf-tab.is-active { color: #1b1f24; }
    .qf-tab-count {
        background: rgba(0, 0, 0, .08); color: inherit;
        font-size: .7rem; font-weight: 700; padding: .1rem .5rem;
        border-radius: 999px; min-width: 20px; text-align: center;
    }
    .qf-tab.is-active .qf-tab-count { background: rgba(0, 0, 0, .18); }

    /* Filter buttons at the end of the row */
    .qf-tabs__filters { display: flex; gap: .5rem; padding-right: .2rem; }
    .qf-filter-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .58rem 1.05rem; border: 0; border-radius: 10px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #fff; font-weight: 600; font-size: .88rem; cursor: pointer;
        box-shadow: 0 4px 12px rgba(245, 158, 11, .28);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .qf-filter-btn:hover { transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 6px 16px rgba(245, 158, 11, .36); }
    .qf-filter-btn i { font-size: 1.15rem; }

    @media (max-width: 720px) {
        .qf-tabs { justify-content: flex-start; }
        .qf-tabs__filters { width: 100%; }
        .qf-filter-btn { flex: 1; justify-content: center; }
    }
</style>

<script>
    (function () {
        const group = document.querySelector('.qf-tabs__group');
        if (!group) return;
        const slider = group.querySelector('.qf-tab-slider');
        const tabs = group.querySelectorAll('.qf-tab');
        if (!slider || !tabs.length) return;

        const moveTo = (el) => {
            if (!el) return;
            slider.style.width = el.offsetWidth + 'px';
            slider.style.height = el.offsetHeight + 'px';
            slider.style.left = el.offsetLeft + 'px';
            slider.style.top = el.offsetTop + 'px';
            slider.style.opacity = '1';
        };
        const reset = () => moveTo(group.querySelector('.qf-tab.is-active') || tabs[0]);

        requestAnimationFrame(reset);
        window.addEventListener('load', reset);
        window.addEventListener('resize', reset);
        tabs.forEach((t) => t.addEventListener('mouseenter', () => moveTo(t)));
        group.addEventListener('mouseleave', reset);
    })();
</script>
