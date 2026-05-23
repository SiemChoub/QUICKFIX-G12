<x-settings-layout title="Roles" subtitle="Roles and their assigned permissions" icon="bx-shield">
    <div class="qrole-list">
        @can('Role access')
            @foreach($roles as $i => $role)
                @php
                    $perms = $role->permissions;
                    $extra = max(0, $perms->count() - 12);
                @endphp
                <div class="qrole-card" style="animation-delay: {{ $i * 55 }}ms">
                    <div class="qrole-head">
                        <span class="qrole-icon"><i class='bx bxs-shield-alt-2'></i></span>
                        <div class="qrole-meta">
                            <span class="qrole-name">{{ ucfirst($role->name) }}</span>
                            <span class="qrole-count">{{ $perms->count() }} {{ \Illuminate\Support\Str::plural('permission', $perms->count()) }}</span>
                        </div>
                        @can('Role edit')
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="qrole-edit">
                                <i class='bx bx-cog'></i><span>Edit</span>
                            </a>
                        @endcan
                    </div>

                    <div class="qrole-perms">
                        @forelse($perms as $j => $permission)
                            <span class="qrole-chip {{ $j >= 12 ? 'qrole-chip--hidden' : '' }}">{{ $permission->name }}</span>
                        @empty
                            <span class="qrole-empty">No permissions assigned</span>
                        @endforelse
                        @if($extra > 0)
                            <button type="button" class="qrole-chip qrole-chip--more"
                                    data-extra="{{ $extra }}" onclick="toggleRolePerms(this)">+{{ $extra }} more</button>
                        @endif
                    </div>
                </div>
            @endforeach
        @endcan
    </div>

    <style>
        .qrole-list { display: flex; flex-direction: column; gap: .8rem; }
        .qrole-card {
            border: 1px solid #eef0f4; border-radius: 14px; padding: 1.1rem 1.25rem;
            background: #fff; transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
            opacity: 0; transform: translateY(8px);
            animation: qrole-in .45s cubic-bezier(.16,.84,.44,1) forwards;
        }
        @keyframes qrole-in { to { opacity: 1; transform: translateY(0); } }
        .qrole-card:hover { border-color: #e2e5ea; box-shadow: 0 10px 26px rgba(17,24,39,.07); transform: translateY(-2px); }

        .qrole-head { display: flex; align-items: center; gap: .9rem; }
        .qrole-icon {
            width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 1.5rem; color: #fff;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 4px 12px rgba(99,102,241,.3);
        }
        .qrole-meta { display: flex; flex-direction: column; flex: 1; min-width: 0; }
        .qrole-name { font-size: 1.05rem; font-weight: 700; color: #1f2937; text-transform: capitalize; }
        .qrole-count { font-size: .78rem; color: #9ca3af; }
        .qrole-edit {
            display: inline-flex; align-items: center; gap: .35rem; flex-shrink: 0;
            font-size: .82rem; font-weight: 600; color: #b45309; background: rgba(245,158,11,.12);
            padding: .5rem .9rem; border-radius: 10px; text-decoration: none; transition: background .15s ease, color .15s ease;
        }
        .qrole-edit:hover { color: #fff; background: #f59e0b; }
        .qrole-edit i { font-size: 1.05rem; }

        .qrole-perms { display: flex; flex-wrap: wrap; gap: .4rem; margin-top: .9rem; padding-top: .9rem; border-top: 1px dashed #eef0f4; }
        .qrole-chip {
            font-size: .73rem; font-weight: 600; color: #4f46e5; background: #eef2ff;
            padding: .25rem .65rem; border-radius: 8px;
        }
        .qrole-chip--more {
            color: #6b7280; background: #f1f5f9; cursor: pointer; border: none;
            font-family: inherit; transition: background .15s ease, color .15s ease;
        }
        .qrole-chip--more:hover { background: #e2e8f0; color: #4f46e5; }
        .qrole-chip--hidden { display: none; }
        .qrole-perms.is-expanded .qrole-chip--hidden { display: inline-block; }
        .qrole-empty { font-size: .82rem; color: #9ca3af; font-style: italic; }
    </style>

    <script>
        function toggleRolePerms(btn) {
            const perms = btn.closest('.qrole-perms');
            const expanded = perms.classList.toggle('is-expanded');
            btn.textContent = expanded ? 'Show less' : ('+' + btn.dataset.extra + ' more');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('showAlertEdit'))
    <script>
        Swal.fire({ title: 'Role edited successfully!', text: '{{ session("success") }}', icon: 'success', confirmButtonText: 'OK', confirmButtonColor: '#ff9800', showCloseButton: true });
    </script>
    @endif
</x-settings-layout>
