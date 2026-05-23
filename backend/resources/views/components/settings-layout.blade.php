@props([
    'title' => 'Settings',
    'subtitle' => null,
    'icon' => 'bx-cog',
])

<x-app-layout>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="qf-settings-page">
    <div class="qf-settings">

        {{-- Settings sub-sidebar --}}
        <aside class="qf-settings__nav">
            <div class="qf-settings__nav-head">
                <span class="qf-settings__nav-mark"><i class='bx bx-cog'></i></span>
                <span>
                    <strong>Settings</strong>
                    <small>Manage access &amp; system</small>
                </span>
            </div>

            <nav class="qf-settings__menu">
                @canany(['Mail access', 'Mail edit'])
                <a href="{{ route('admin.mail.index') }}"
                   class="qf-settings__link {{ request()->routeIs('admin.mail.*') ? 'is-active' : '' }}">
                    <i class='bx bx-envelope'></i>
                    <span>Mail / General</span>
                </a>
                @endcanany

                @canany(['Role access', 'Role add', 'Role edit', 'Role delete'])
                <a href="{{ route('admin.roles.index') }}"
                   class="qf-settings__link {{ request()->routeIs('admin.roles.*') ? 'is-active' : '' }}">
                    <i class='bx bx-shield'></i>
                    <span>Roles</span>
                </a>
                @endcanany

                @canany(['Permission access', 'Permission add', 'Permission edit', 'Permission delete'])
                <a href="{{ route('admin.permissions.index') }}"
                   class="qf-settings__link {{ request()->routeIs('admin.permissions.*') ? 'is-active' : '' }}">
                    <i class='bx bx-key'></i>
                    <span>Permissions</span>
                </a>
                @endcanany
            </nav>
        </aside>

        {{-- Content panel --}}
        <section class="qf-settings__panel">
            <header class="qf-settings__panel-head">
                <div class="qf-settings__panel-title">
                    <i class='bx {{ $icon }}'></i>
                    <span>
                        <h1>{{ $title }}</h1>
                        @if ($subtitle)
                            <p>{{ $subtitle }}</p>
                        @endif
                    </span>
                </div>
                @isset($actions)
                    <div class="qf-settings__panel-actions">{{ $actions }}</div>
                @endisset
            </header>

            <div class="qf-settings__panel-body">
                {{ $slot }}
            </div>
        </section>
    </div>
</div>

<style>
    .qf-settings-page {
        padding: 1.75rem 1.5rem 2.5rem;
        background: #eef1f5;
        min-height: 100%;
    }
    .qf-settings {
        display: grid;
        grid-template-columns: 250px minmax(0, 1fr);
        gap: 1.5rem;
        width: 100%;
        align-items: start;
    }

    /* ---- Settings sub-sidebar ---- */
    .qf-settings__nav {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1rem 0.85rem;
        box-shadow: 0 6px 20px rgba(17, 24, 39, 0.05);
        position: sticky;
        top: 1.5rem;
    }
    .qf-settings__nav-head {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.35rem 0.55rem 0.9rem;
        border-bottom: 1px solid #f1f3f7;
        margin-bottom: 0.6rem;
    }
    .qf-settings__nav-mark {
        width: 40px; height: 40px;
        border-radius: 11px;
        display: grid; place-items: center;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #fff; font-size: 1.35rem;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        flex-shrink: 0;
    }
    .qf-settings__nav-head strong { display: block; font-size: 0.95rem; color: #111827; line-height: 1.2; }
    .qf-settings__nav-head small  { display: block; font-size: 0.7rem; color: #9ca3af; }

    .qf-settings__menu { display: flex; flex-direction: column; gap: 2px; }
    .qf-settings__link {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.62rem 0.7rem;
        border-radius: 10px;
        color: #4b5563;
        font-size: 0.88rem;
        font-weight: 500;
        text-decoration: none;
        transition: background .15s ease, color .15s ease;
        position: relative;
    }
    .qf-settings__link i { font-size: 1.2rem; flex-shrink: 0; }
    .qf-settings__link:hover { background: #f6f7f9; color: #111827; }
    .qf-settings__link.is-active {
        background: linear-gradient(90deg, rgba(245, 158, 11, 0.14), rgba(245, 158, 11, 0.03));
        color: #b45309;
        font-weight: 600;
    }
    .qf-settings__link.is-active::before {
        content: '';
        position: absolute;
        left: 0; top: 8px; bottom: 8px;
        width: 3px; border-radius: 0 3px 3px 0;
        background: #f59e0b;
    }

    /* ---- Content panel ---- */
    .qf-settings__panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(17, 24, 39, 0.05);
        overflow: hidden;
    }
    .qf-settings__panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #f1f3f7;
        background: #fcfcfd;
    }
    .qf-settings__panel-title { display: flex; align-items: center; gap: 0.8rem; }
    .qf-settings__panel-title > i {
        font-size: 1.5rem; color: #f59e0b;
        width: 44px; height: 44px;
        display: grid; place-items: center;
        background: rgba(245, 158, 11, 0.12);
        border-radius: 12px;
        flex-shrink: 0;
    }
    .qf-settings__panel-title h1 { font-size: 1.2rem; font-weight: 700; color: #111827; margin: 0; line-height: 1.25; }
    .qf-settings__panel-title p  { font-size: 0.8rem; color: #9ca3af; margin: 0; }
    .qf-settings__panel-actions { display: flex; align-items: center; gap: 0.6rem; }
    .qf-settings__panel-body { padding: 1.5rem; }

    @media (max-width: 860px) {
        .qf-settings { grid-template-columns: 1fr; }
        .qf-settings__nav { position: static; }
    }
</style>
</x-app-layout>
