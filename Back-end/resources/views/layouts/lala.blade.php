<x-app-layout>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 py-6">
        <div class="container mx-auto px-4">
            <div class="text-right mb-4">
                @can('Post create')
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-warning btn-sm">New post</a>
                @endcan
            </div>
            <div class="grid grid-cols-1 md:grid-rows-2 lg:grid-rows-3 gap-4">
                @can('Post access')
                    @foreach ($posts as $post)
                        <div class="bg-white shadow-md rounded p-4 flex flex-col">
                            <h3 class="text-lg font-bold mb-2">{{ $post->title }}</h3>
                            <div class="mb-3">
                                @if ($post->publish)
                                    <span class="badge bg-warning text-dark">Publish</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                            <div class="mt-auto flex justify-end">
                                @can('Post edit')
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                @endcan
                                @can('Post delete')
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                @endcan
            </div>
            @can('Post access')
                <div class="text-right mt-6">
                    {{ $posts->links() }}
                </div>
            @endcan
        </div>
    </main>
    <!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</x-app-layout>