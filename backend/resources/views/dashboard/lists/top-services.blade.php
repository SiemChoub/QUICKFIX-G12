<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-4">
        @include('dashboard.lists._header', ['title' => 'Top Services', 'subtitle' => 'All services ranked by bookings'])

        @php
            $data = [];
            foreach ($Service as $service) {
                $data[$service->id] = ['id' => $service->id, 'number' => 0];
                foreach ($bookings as $booking) {
                    if ($booking->type == 'immediately') {
                        $book_service = $bookin_immediatelies->where('service_id', $service->id);
                    } else {
                        $book_service = $bookin_deadlines->where('service_id', $service->id);
                    }
                    if ($book_service->isEmpty()) {
                        $data[$service->id]['number']++;
                    }
                }
            }
            $sorted = collect($data)->filter(fn ($i) => $i['number'] != 0)->sortByDesc('number');
        @endphp

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th class="pe-3 text-end">Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sorted as $item)
                            @php $s = $Service->where('id', $item['id'])->first(); @endphp
                            <tr>
                                <td class="ps-3 text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $s->name }}</td>
                                <td>{{ $s->category->name ?? '—' }}</td>
                                <td>${{ $s->price }}</td>
                                <td class="pe-3 text-end"><span class="badge bg-warning text-dark">{{ $item['number'] }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No top services yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
