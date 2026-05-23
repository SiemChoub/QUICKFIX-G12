<x-settings-layout title="Roles" subtitle="Roles and their assigned permissions" icon="bx-shield">
    <div class="table-responsive">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-gray-50 font-bold text-sm text-gray-600 border-b border-gray-200 w-2/12">Role Name</th>
                    <th class="py-3 px-4 bg-gray-50 font-bold text-sm text-gray-600 border-b border-gray-200">Permissions</th>
                    <th class="py-3 px-4 bg-gray-50 font-bold text-sm text-gray-600 border-b border-gray-200 text-right w-2/12">Actions</th>
                </tr>
            </thead>
            <tbody>
                @can('Role access')
                    @foreach($roles as $role)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4 px-4 border-b border-gray-200 font-medium text-gray-800">{{ $role->name }}</td>
                            <td class="py-4 px-4 border-b border-gray-200">
                                @foreach($role->permissions as $permission)
                                    <span class="inline-flex items-center justify-center px-3 py-1 mr-2 mb-1 text-xs font-semibold text-white bg-blue-500 rounded-full">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td class="py-4 px-4 border-b border-gray-200 text-right">
                                @can('Role edit')
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center">
                                        <i class="bx bx-cog me-1"></i>
                                        Edit
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @endcan
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('showAlertEdit'))
    <script>
        Swal.fire({
            title: 'Role edited Success!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ff9800',
            showCloseButton: true,
        });
    </script>
    @endif
</x-settings-layout>
