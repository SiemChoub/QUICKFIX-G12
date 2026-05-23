<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-4">
        @include('dashboard.lists._header', ['title' => 'Low Services', 'subtitle' => 'All services with no bookings'])

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th class="pe-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $n = 0; @endphp
                        @foreach ($Service as $service)
                            @php
                                foreach ($bookings as $booking) {
                                    if ($booking->type == 'immediately') {
                                        $book_service = $bookin_immediatelies->where('service_id', $service->id);
                                    } else {
                                        $book_service = $bookin_deadlines->where('service_id', $service->id);
                                    }
                                }
                            @endphp
                            @if ($book_service->isEmpty())
                                @php $n++; @endphp
                                <tr>
                                    <td class="ps-3 text-muted">{{ $n }}</td>
                                    <td class="fw-semibold">{{ $service->name }}</td>
                                    <td>{{ $service->category->name ?? '—' }}</td>
                                    <td>${{ $service->price }}</td>
                                    <td class="pe-3"><span class="badge bg-danger-subtle text-danger">Nothing booking!</span></td>
                                </tr>
                            @endif
                        @endforeach
                        @if ($n == 0)
                            <tr><td colspan="5" class="text-center text-muted py-4">All services have bookings</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
