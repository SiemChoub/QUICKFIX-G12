<x-app-layout>
    <div class="container-fluid px-3 px-md-4 py-4">
        @include('dashboard.lists._header', ['title' => 'Top Fixers', 'subtitle' => 'All fixers ranked by completed jobs'])

        @php
            $topFixers = \App\Models\FixingProgress::selectRaw('fixer_id, count(*) as count')
                ->groupBy('fixer_id')
                ->orderBy('count', 'desc')
                ->get();
        @endphp

        @if (count($topFixers) == 0)
            <div class="card shadow-sm border-0"><div class="card-body text-center text-muted py-5">No fixers yet</div></div>
        @else
            <div class="row g-3">
                @foreach ($topFixers as $top)
                    @php $fixer = $users->where('id', $top->fixer_id)->first(); @endphp
                    @if ($fixer)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0 h-100 text-center">
                                <div class="card-body">
                                    <img src="{{ $fixer->profile }}" alt="{{ $fixer->name }}"
                                        class="rounded-circle mb-2" style="width:64px;height:64px;object-fit:cover;background:#f1f5f9;">
                                    <h6 class="fw-bold mb-0">{{ $fixer->name }}</h6>
                                    <p class="text-muted small mb-1">{{ $top->count }} {{ \Illuminate\Support\Str::plural('job', $top->count) }}</p>
                                    <div class="text-warning">
                                        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
