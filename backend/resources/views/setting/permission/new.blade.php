<x-settings-layout title="New Permission" subtitle="Create a new permission" icon="bx-key">
    <x-slot name="actions">
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-warning d-flex align-items-center">
            <i class="bx bx-arrow-back me-1"></i>
            Back
        </a>
    </x-slot>

    <form method="POST" action="{{ route('admin.permissions.store')}}">
        @csrf
        @method('post')
        <div class="flex flex-col space-y-2 max-w-lg">
            <label for="role_name" class="text-gray-700 select-none font-medium">Permission Name</label>
            <input
                id="role_name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter permission"
                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200"
            />
        </div>
        <div class="text-center mt-12">
            <button type="submit" class="bg-warning shadow hover:bg-yellow-600 font-medium py-2 px-4 rounded-md focus:outline-none transition-colors">Submit</button>
        </div>
    </form>
</x-settings-layout>
