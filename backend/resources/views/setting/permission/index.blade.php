<x-settings-layout title="Permissions" subtitle="Define the permissions available to roles" icon="bx-key">

    {{-- ===== Panel header actions: search + create ===== --}}
    <x-slot name="actions">
        <div class="qperm-search">
            <i class='bx bx-search-alt'></i>
            <input type="text" id="search-input" placeholder="Search permissions…" aria-label="Search permissions">
        </div>
        @can('Permission create')
            <a href="{{ route('admin.permissions.create') }}" class="qperm-create">
                <i class='bx bx-plus'></i>
                <span>Create New</span>
            </a>
        @endcan
    </x-slot>

    {{-- ===== Permission list ===== --}}
    @can('Permission access')
    <div class="qperm">
        <div class="qperm__bar">
            <span class="qperm__count">
                <i class='bx bx-shield-quarter'></i>
                {{ $permissions->total() }} total
            </span>
            <span class="qperm__hint">Grouped by module &amp; action</span>
        </div>

        <ul class="qperm__list" id="permission-list">
            @foreach ($permissions as $i => $permission)
                @php
                    $parts      = preg_split('/\s+/', trim($permission->name));
                    $actionWord = strtolower(end($parts));
                    $module     = count($parts) > 1 ? implode(' ', array_slice($parts, 0, -1)) : 'General';
                    $type = match (true) {
                        str_contains($actionWord, 'access') || str_contains($actionWord, 'view') || str_contains($actionWord, 'read') || str_contains($actionWord, 'list') => 'view',
                        str_contains($actionWord, 'edit')   || str_contains($actionWord, 'update')                                                                       => 'edit',
                        str_contains($actionWord, 'create') || str_contains($actionWord, 'add')  || str_contains($actionWord, 'store')                                   => 'create',
                        str_contains($actionWord, 'delete') || str_contains($actionWord, 'destroy') || str_contains($actionWord, 'remove')                               => 'delete',
                        default                                                                                                                                          => 'other',
                    };
                    $icon = ['view' => 'bx-show-alt', 'edit' => 'bx-edit-alt', 'create' => 'bx-plus-circle', 'delete' => 'bx-trash', 'other' => 'bx-key'][$type];
                @endphp
                <li class="qperm__card qperm__card--{{ $type }}" data-name="{{ strtolower($permission->name) }}"
                    style="animation-delay: {{ $i * 55 }}ms">
                    <span class="qperm__icon"><i class='bx {{ $icon }}'></i></span>

                    <div class="qperm__meta">
                        <span class="qperm__name">{{ $permission->name }}</span>
                        <span class="qperm__module"><i class='bx bx-folder'></i> {{ ucfirst($module) }}</span>
                    </div>

                    <span class="qperm__tag">{{ ucfirst($actionWord) }}</span>

                    <div class="qperm__actions">
                        @can('Permission edit')
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="qperm__act qperm__act--edit" title="Edit">
                                <i class='bx bx-edit-alt'></i><span>Edit</span>
                            </a>
                        @endcan
                        @can('Permission delete')
                            <button type="button" class="qperm__act qperm__act--del" title="Delete" onclick="confirmDelete({{ $permission->id }})">
                                <i class='bx bx-trash'></i><span>Delete</span>
                            </button>
                            <form id="delete-form-{{ $permission->id }}" action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="qperm__empty" id="permission-empty" hidden>
            <i class='bx bx-search-alt'></i>
            <p>No permissions match your search.</p>
        </div>

        <div class="qperm__footer">
            <span class="qperm__results">Showing {{ $permissions->firstItem() }}–{{ $permissions->lastItem() }} of {{ $permissions->total() }}</span>
            <div class="qperm__pagination">{{ $permissions->links() }}</div>
        </div>
    </div>
    @endcan

    <style>
        /* ===== Header actions ===== */
        .qperm-search {
            display: flex; align-items: center; gap: .5rem;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: .55rem .85rem; min-width: 260px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .qperm-search:focus-within { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .qperm-search i { font-size: 1.15rem; color: #9ca3af; }
        .qperm-search input { border: 0; outline: 0; background: transparent; width: 100%; font-size: .9rem; color: #111827; }
        .qperm-search input::placeholder { color: #9ca3af; }

        .qperm-create {
            display: inline-flex; align-items: center; gap: .4rem;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #fff; font-weight: 600; font-size: .88rem;
            padding: .6rem 1.1rem; border-radius: 12px; text-decoration: none;
            box-shadow: 0 6px 16px rgba(245,158,11,.32);
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
            white-space: nowrap;
        }
        .qperm-create:hover { color: #fff; transform: translateY(-1px); filter: brightness(1.04); box-shadow: 0 8px 20px rgba(245,158,11,.4); }
        .qperm-create i { font-size: 1.2rem; }

        /* ===== List shell ===== */
        .qperm__bar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1rem;
        }
        .qperm__count {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .8rem; font-weight: 700; color: #b45309;
            background: rgba(245,158,11,.12); padding: .35rem .75rem; border-radius: 999px;
        }
        .qperm__count i { font-size: 1rem; }
        .qperm__hint { font-size: .78rem; color: #9ca3af; }

        .qperm__list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: .6rem; }

        /* ===== Permission card ===== */
        .qperm__card {
            display: flex; align-items: center; gap: 1rem;
            background: #fff; border: 1px solid #eef0f4; border-radius: 14px;
            padding: .85rem 1.1rem;
            position: relative; overflow: hidden;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: qperm-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qperm-in { to { opacity: 1; transform: translateY(0); } }
        .qperm__card::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--c, #94a3b8); opacity: .9;
        }
        .qperm__card:hover { border-color: #e2e5ea; box-shadow: 0 10px 26px rgba(17,24,39,.08); transform: translateY(-2px); }

        .qperm__icon {
            flex-shrink: 0; width: 46px; height: 46px; border-radius: 12px;
            display: grid; place-items: center; font-size: 1.45rem;
            color: var(--c, #64748b); background: var(--c-soft, #f1f5f9);
        }
        .qperm__meta { display: flex; flex-direction: column; min-width: 0; flex: 1 1 auto; }
        .qperm__name { font-size: .98rem; font-weight: 700; color: #1f2937; line-height: 1.2; }
        .qperm__module {
            display: inline-flex; align-items: center; gap: .3rem;
            font-size: .75rem; color: #9ca3af; margin-top: .15rem;
        }
        .qperm__module i { font-size: .85rem; }

        .qperm__tag {
            flex-shrink: 0; font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
            color: var(--c, #475569); background: var(--c-soft, #f1f5f9);
            padding: .3rem .7rem; border-radius: 999px;
        }

        .qperm__actions { display: flex; align-items: center; gap: .45rem; flex-shrink: 0; }
        .qperm__act {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .8rem; font-weight: 600; padding: .45rem .8rem; border-radius: 9px;
            border: 1px solid transparent; cursor: pointer; text-decoration: none;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .qperm__act i { font-size: 1rem; }
        .qperm__act--edit { color: #b45309; background: rgba(245,158,11,.1); }
        .qperm__act--edit:hover { color: #fff; background: #f59e0b; }
        .qperm__act--del { color: #e11d48; background: rgba(244,63,94,.08); }
        .qperm__act--del:hover { color: #fff; background: #f43f5e; }

        /* ===== Type accents ===== */
        .qperm__card--view   { --c: #3b82f6; --c-soft: #eff6ff; }
        .qperm__card--edit   { --c: #f59e0b; --c-soft: #fff7ed; }
        .qperm__card--create { --c: #10b981; --c-soft: #ecfdf5; }
        .qperm__card--delete { --c: #f43f5e; --c-soft: #fff1f2; }
        .qperm__card--other  { --c: #64748b; --c-soft: #f1f5f9; }

        /* ===== Empty + footer ===== */
        .qperm__empty { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
        .qperm__empty i { font-size: 2.4rem; }
        .qperm__empty p { margin: .5rem 0 0; font-size: .9rem; }

        .qperm__footer {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem;
            margin-top: 1.4rem; padding-top: 1.1rem; border-top: 1px solid #f1f3f7;
        }
        .qperm__results { font-size: .82rem; color: #6b7280; }
        .qperm__pagination nav { margin: 0; }
        .qperm__pagination .pagination { margin: 0; gap: 4px; }

        @media (max-width: 640px) {
            .qperm__tag { display: none; }
            .qperm__act span { display: none; }
            .qperm__act { padding: .5rem; }
        }
    </style>

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

        (function () {
            const input = document.getElementById('search-input');
            const empty = document.getElementById('permission-empty');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = this.value.toLowerCase().trim();
                let shown = 0;
                document.querySelectorAll('#permission-list .qperm__card').forEach(card => {
                    const match = card.dataset.name.includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                empty.hidden = shown !== 0;
            });
        })();
    </script>

    @foreach (['showAlertCreate' => 'created', 'showAlertEdit' => 'edited', 'showAlertDelete' => 'deleted'] as $flag => $verb)
        @if(session($flag))
        <script>
            Swal.fire({ title: 'Permission {{ $verb }} successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#f59e0b', showCloseButton: true });
        </script>
        @endif
    @endforeach
</x-settings-layout>
