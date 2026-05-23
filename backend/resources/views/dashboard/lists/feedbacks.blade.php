<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-4">
        @include('dashboard.lists._header', ['title' => 'Customer Feedback', 'subtitle' => count($feedbacks) . ' total'])

        <div class="card shadow-sm border-0">
            <ul class="list-group list-group-flush">
                @forelse ($feedbacks as $feedback)
                    @php $user = $users->where('id', $feedback->user_id)->first(); @endphp
                    @if ($user)
                        <li class="list-group-item d-flex align-items-center gap-3 py-3">
                            <img src="{{ $user->profile }}" alt="{{ $user->name }}"
                                class="rounded-circle" style="width:44px;height:44px;object-fit:cover;background:#f1f5f9;">
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="fw-semibold mb-0">{{ $user->name }}</h6>
                                <p class="text-muted small mb-0">{{ $feedback->content }}</p>
                            </div>
                            @can('Feedback delete')
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this feedback?');" class="m-0">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                </form>
                            @endcan
                        </li>
                    @endif
                @empty
                    <li class="list-group-item text-center text-muted py-4">No customer feedback yet</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
