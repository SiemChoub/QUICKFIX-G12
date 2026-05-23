<x-settings-layout title="Edit Role" subtitle="Assign permissions to {{ $role->name }}" icon="bx-shield">
    <x-slot name="actions">
        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-warning d-flex align-items-center">
            <i class="bx bx-arrow-back me-1"></i>
            Back
        </a>
    </x-slot>

    <form method="POST" action="{{ route('admin.roles.update',$role->id) }}" class="space-y-6">
        @csrf
        @method('put')
        <input id="role_name" type="text" name="name" value="{{ old('name',$role->name) }}" hidden />

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($permissions as $permission)
            <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" name="permissions[]"
                    value="{{ $permission->id }}"
                    @if(count($role->permissions->where('id',$permission->id))) checked @endif>
                <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
            </label>
            @endforeach
        </div>

        <div class="text-center pt-4">
            <button type="submit"
                class="inline-flex items-center px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded shadow hover:shadow-lg transition-colors duration-200">
                Update
            </button>
        </div>
    </form>
</x-settings-layout>
