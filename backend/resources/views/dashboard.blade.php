<x-app-layout>
<div class="dashboard-wrapper">
    <main class="flex-1 overflow-x-hidden overflow-y-auto">
        <div class="container-fluid px-3 px-md-4 py-4">

            {{-- ====================== KPI STRIP ====================== --}}
            <div class="kpi-grid">
                {{-- Categories --}}
                <div class="kpi-card kpi-card--amber">
                    <div class="kpi-card__content">
                        <span class="kpi-card__label">Categories</span>
                        <span class="kpi-card__value">{{ count($Categories) }}</span>
                        <span class="kpi-card__hint">Total registered</span>
                    </div>
                    <div class="kpi-card__icon">
                        <i class='bx bxs-category'></i>
                    </div>
                </div>

                {{-- Services --}}
                <div class="kpi-card kpi-card--blue">
                    <div class="kpi-card__content">
                        <span class="kpi-card__label">Services</span>
                        <span class="kpi-card__value">{{ count($Service) }}</span>
                        <span class="kpi-card__hint">Active services</span>
                    </div>
                    <div class="kpi-card__icon">
                        <i class='bx bxs-briefcase-alt-2'></i>
                    </div>
                </div>

                {{-- Revenues --}}
                @php
                    $totals = $payments->where('status', 'done')->pluck('total');
                    $totalSum = $totals->sum();
                    if ($totalSum >= 10000) {
                        $formattedTotal = number_format($totalSum / 1000, 0) . 'k';
                    } else {
                        $formattedTotal = $totalSum;
                    }
                @endphp
                <div class="kpi-card kpi-card--green">
                    <div class="kpi-card__content">
                        <span class="kpi-card__label">Revenues</span>
                        <span class="kpi-card__value">${{ $formattedTotal }}</span>
                        <span class="kpi-card__hint">Completed payouts</span>
                    </div>
                    <div class="kpi-card__icon">
                        <i class='bx bxs-archive-in'></i>
                    </div>
                </div>

                {{-- Users --}}
                <div class="kpi-card kpi-card--purple">
                    <div class="kpi-card__content">
                        <span class="kpi-card__label">Users</span>
                        <span class="kpi-card__value">{{ count($users) }}</span>
                        <span class="kpi-card__hint">Across all roles</span>
                    </div>
                    <div class="kpi-card__icon">
                        <i class='bx bx-user'></i>
                    </div>
                </div>
            </div>

            {{-- ====================== MAIN GRID ====================== --}}
            <div class="row g-3 g-md-4 mt-1">

                {{-- LEFT COLUMN --}}
                <div class="col-12 col-lg-6 d-flex flex-column gap-3 gap-md-4">

                    {{-- Top Service --}}
                    <section class="dash-card">
                        <div class="dash-card__header">
                            <h6 class="dash-card__title">Top Service</h6>
                            <span class="badge bg-warning-subtle text-warning fw-semibold">Most booked</span>
                        </div>
                        <div class="dash-card__body dash-scroll" style="max-height: 300px;">
                            @php
                                $data = [];
                                foreach ($Service as $service) {
                                    $data[$service->id] = [
                                        'id' => $service->id,
                                        'name' => $service->name,
                                        'number' => 0,
                                    ];

                                    $booking_id = $FixingProgress->where('status', 'done')->pluck('booking_id');
                                    $book_service = collect();

                                    foreach ($bookings as $booking) {
                                        if ($booking->type == 'immediately') {
                                            $book_service = $bookin_immediatelies->where('service_id', $service->id);
                                        } else {
                                            $book_service = $bookin_deadlines->where('service_id', $service->id);
                                        }

                                        if ($book_service->isEmpty()) {
                                            if (isset($data[$service->id])) {
                                                $data[$service->id]['number']++;
                                            }
                                        }
                                    }
                                }
                                $dataCollection = collect($data);
                                $filteredData = $dataCollection->filter(fn ($item) => $item['number'] != 0);
                                $sortedData = $filteredData->sortByDesc('number');
                                $topFiveData = $sortedData->take(6);
                            @endphp

                            @forelse ($topFiveData as $item)
                                @php $topservice = $Service->where('id', $item['id'])->first(); @endphp
                                <div class="list-row">
                                    <div class="list-row__main">
                                        <p class="list-row__title">{{ $topservice->name }}</p>
                                        <div class="list-row__meta">
                                            <i class='bx bxs-group'></i><span>+{{ $item['number'] }}</span>
                                        </div>
                                    </div>
                                    <div class="list-row__rating">
                                        <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal" data-bs-target="#topServiceDetailModel"
                                        data-service-image="{{ $topservice->image }}"
                                        data-service-title="{{ $topservice->name }}"
                                        data-service-description="{{ $topservice->description }}"
                                        data-service-category="{{ $topservice->category->name ?? '' }}"
                                        data-service-price="{{ $topservice->price }}"
                                        data-service-stars="3">
                                        View more
                                    </button>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class='bx bx-trophy'></i>
                                    <p>No top service yet</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="dash-card__footer">
                            <a href="{{ route('admin.dashboard.top-services') }}" class="dash-toggle">View all</a>
                        </div>
                    </section>

                    {{-- Low Service --}}
                    <section class="dash-card">
                        <div class="dash-card__header">
                            <h6 class="dash-card__title">Low Service</h6>
                            <span class="badge bg-danger-subtle text-danger fw-semibold">No bookings</span>
                        </div>
                        <div class="dash-card__body dash-scroll" style="max-height: 300px;">
                            @php $mama = 0; @endphp
                            @foreach ($Service as $service)
                                @php
                                    $booking_id = $FixingProgress->where('status', 'done')->pluck('booking_id');
                                    foreach ($bookings as $booking) {
                                        if ($booking->type == 'immediately') {
                                            $book_service = $bookin_immediatelies->where('service_id', $service->id);
                                        } else {
                                            $book_service = $bookin_deadlines->where('service_id', $service->id);
                                        }
                                    }
                                @endphp
                                @if ($book_service->isEmpty())
                                    @php $mama++ @endphp
                                    @if ($mama <= 6)
                                    <div class="list-row">
                                        <div class="list-row__main">
                                            <p class="list-row__title">{{ $service->name }}</p>
                                            <p class="list-row__warn">Nothing booking!</p>
                                        </div>
                                        <button class="btn btn-sm btn-outline-warning"
                                            data-bs-toggle="modal" data-bs-target="#topServiceDetailModel"
                                            data-service-image="{{ $service->image }}"
                                            data-service-title="{{ $service->name }}"
                                            data-service-description="{{ $service->description }}"
                                            data-service-category="{{ $service->category->name ?? '' }}"
                                            data-service-price="{{ $service->price }}"
                                            data-service-stars="0">
                                            <i class="bx bx-info-circle"></i> view more
                                        </button>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                            @if ($mama == 0)
                                <div class="empty-state">
                                    <i class='bx bx-check-circle'></i>
                                    <p>All services have bookings</p>
                                </div>
                            @endif
                        </div>
                        <div class="dash-card__footer">
                            <a href="{{ route('admin.dashboard.low-services') }}" class="dash-toggle">View all</a>
                        </div>
                    </section>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-12 col-lg-6 d-flex flex-column gap-3 gap-md-4">

                    {{-- Chart --}}
                    <section class="dash-card">
                        <div class="dash-card__header">
                            <h6 class="dash-card__title">Services performance</h6>
                            <input type="date" class="form-control form-control-sm date-input" placeholder="Select a date">
                        </div>
                        <div class="dash-card__body">
                            <div class="chart-wrap">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </section>

                    {{-- Top Fixer --}}
                    <section class="dash-card">
                        <div class="dash-card__header">
                            <h6 class="dash-card__title">Top Fixer</h6>
                            <span class="badge bg-info-subtle text-info fw-semibold">Top 3</span>
                        </div>
                        <div class="dash-card__body">
                            @php
                                $topFixers = \App\Models\FixingProgress::selectRaw('fixer_id, count(*) as count')
                                    ->groupBy('fixer_id')
                                    ->orderBy('count', 'desc')
                                    ->limit(6)
                                    ->get();
                            @endphp

                            @if (count($topFixers) == 0)
                                <div class="empty-state">
                                    <i class='bx bx-medal'></i>
                                    <p>No top fixer yet</p>
                                </div>
                            @else
                                <div class="fixer-grid">
                                    @foreach ($topFixers as $top)
                                        @php $fixer = $users->where('id', $top->fixer_id)->first(); @endphp
                                        @if ($fixer)
                                            <div class="fixer-card">
                                                <div class="fixer-card__avatar">
                                                    <img src="{{ $fixer->profile }}" alt="{{ $fixer->name }}">
                                                </div>
                                                <h6 class="fixer-card__name">{{ $fixer->name }}</h6>
                                                <p class="fixer-card__meta">99+ jobs</p>
                                                <div class="fixer-card__stars">
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                    <i class='bx bxs-star'></i>
                                                </div>
                                                <button class="btn btn-sm btn-warning fixer-card__btn detail-button"
                                                    data-bs-toggle="modal" data-bs-target="#userDetailsModal"
                                                    data-user-name="{{ $fixer->name }}"
                                                    data-user-email="{{ $fixer->email }}"
                                                    data-user-phone="{{ $fixer->phone }}"
                                                    data-user-address="{{ $fixer->address }}"
                                                    data-user-profile="{{ $fixer->profile }}"
                                                    data-user-role="{{ $fixer->role }}">
                                                    View more
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="dash-card__footer">
                            <a href="{{ route('admin.dashboard.top-fixers') }}" class="dash-toggle">View all</a>
                        </div>
                    </section>

                    {{-- Customer feedback --}}
                    <section class="dash-card">
                        <div class="dash-card__header">
                            <h6 class="dash-card__title">Customer feedback</h6>
                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">{{ count($feedbacks) }}</span>
                        </div>
                        <div class="dash-card__body dash-scroll" style="max-height: 240px;">
                            @if (count($feedbacks) == 0)
                                <div class="empty-state">
                                    <i class='bx bx-message-square-detail'></i>
                                    <p>No customer feedback yet</p>
                                </div>
                            @endif

                            @foreach ($feedbacks->take(6) as $feedback)
                                @php $user = $users->where('id', $feedback->user_id)->first(); @endphp
                                @if ($user)
                                <div class="feedback-row">
                                    <img src="{{ $user->profile }}" class="feedback-row__avatar" alt="{{ $user->name }}">
                                    <div class="feedback-row__body">
                                        <h6 class="feedback-row__name">{{ $user->name }}</h6>
                                        <p class="feedback-row__text">{{ $feedback->content }}</p>
                                    </div>
                                    <div class="feedback-row__actions">
                                        <button class="btn btn-sm btn-outline-warning"
                                            data-bs-toggle="modal" data-bs-target="#feedbackDetail"
                                            data-feedback-image="{{ $user->profile }}"
                                            data-feedback-name="{{ $user->name }}"
                                            data-feedback-content="{{ $feedback->content }}">
                                            <i class="bx bx-show"></i>
                                        </button>
                                        @can('Feedback delete')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $feedback->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $feedback->id }}" action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="dash-card__footer">
                            <a href="{{ route('admin.dashboard.feedbacks') }}" class="dash-toggle">View all</a>
                        </div>
                    </section>
                </div>

            </div>
        </div>
    </main>
</div>

{{-- ===================================================== --}}
{{-- MODALS                                                --}}
{{-- ===================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

{{-- User detail --}}
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="userDetailsModalLabel"><i class='bx bxs-user'></i> Top fixer Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-7">
                        <div class="user-details-card">
                            <div class="user-details-header d-flex align-items-center gap-2">
                                <i class='bx bxs-user'></i>
                                <h4 class="text-warning mb-0" id="user-name"></h4>
                            </div>
                            <div class="user-details-body mt-3">
                                <p class="d-flex align-items-center gap-2"><i class='bx bxs-envelope'></i> <span>Email: <span id="user-email"></span></span></p>
                                <p class="d-flex align-items-center gap-2"><i class='bx bxs-user-detail'></i> <span><strong>Role:</strong> <span id="user-role"></span></span></p>
                                <p class="d-flex align-items-center gap-2"><i class='bx bxs-map'></i> <span><strong>Address:</strong> <span id="user-address"></span></span></p>
                                <p class="d-flex align-items-center gap-2"><i class='bx bxs-phone'></i> <span><strong>Phone:</strong> <span id="user-phone"></span></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="user-profile-container">
                            <img src="" class="img-fluid rounded" alt="profile" id="user-profile">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="additional-info mt-3">
                    <h5 class="d-flex align-items-center gap-2"><i class='bx bx-info-circle'></i> Additional Information</h5>
                    <p id="user-additional-info">Additional fixer details will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top service detail --}}
<div class="modal fade" id="topServiceDetailModel" tabindex="-1" aria-labelledby="topServiceDetailModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="topServiceDetailModelLabel">Service Detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="service-image-container">
                            <img src="" class="img-fluid rounded" alt="Service Image" id="service-image">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="shadow-sm p-3 rounded text-center bg-light">
                            <h4 class="text-warning" id="service-title"><i class="bx bxs-star"></i> Premium Service</h4>
                            <p id="service-description"></p>
                            <div class="rating mb-2">
                                <p class="mb-1"><i class="bx bxs-star"></i> Stars: <span id="service-stars"></span></p>
                            </div>
                            <div class="service-details">
                                <p class="mb-1"><i class="bx bxs-category"></i> <strong>Category:</strong> <span id="service-category"></span></p>
                                <p class="mb-0"><i class="bx bxs-dollar-circle"></i> <strong>Price:</strong> <span id="service-price"></span>$</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="additional-info mt-3">
                    <h5><i class="bx bx-info-circle"></i> Additional Information</h5>
                    <p id="service-additional-info">Additional service details will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Feedback detail --}}
<div class="modal fade" id="feedbackDetail" tabindex="-1" aria-labelledby="feedbackDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="topfeedbackDetailLabel">Feedback detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-5 text-center">
                        <img src="" class="img-fluid rounded-circle feedback-modal-img" alt="feedback Image" id="feedback-image">
                    </div>
                    <div class="col-md-7">
                        <h4 class="text-warning" id="feedback-name"></h4>
                        <p id="feedback-content"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================================================== --}}
{{-- SCRIPTS                                               --}}
{{-- ===================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Services', 'Fixers', 'Customers', 'Categories'],
            datasets: [{
                label: '# of perform',
                data: [
                    @php echo count($users) @endphp,
                    @php echo count($Service) @endphp,
                    @php echo count($users->where('role', 'fixer')) @endphp,
                    @php echo count($users->where('role', 'customer')) @endphp,
                    @php echo count($Categories) @endphp
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.35)',
                    'rgba(54, 162, 235, 0.35)',
                    'rgba(255, 206, 86, 0.35)',
                    'rgba(75, 192, 192, 0.35)',
                    'rgba(153, 102, 255, 0.35)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    function updateServiceModal(event) {
        var button = event.relatedTarget;
        document.getElementById('service-image').src = button.dataset.serviceImage;
        document.getElementById('service-title').textContent = button.dataset.serviceTitle;
        document.getElementById('service-description').textContent = button.dataset.serviceDescription;
        document.getElementById('service-stars').textContent = button.dataset.serviceStars;
        document.getElementById('service-category').textContent = button.dataset.serviceCategory;
        document.getElementById('service-price').textContent = button.dataset.servicePrice;
    }
    document.getElementById('topServiceDetailModel').addEventListener('show.bs.modal', updateServiceModal);

    document.getElementById('feedbackDetail').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('feedback-image').src = button.dataset.feedbackImage;
        document.getElementById('feedback-name').textContent = button.dataset.feedbackName;
        document.getElementById('feedback-content').textContent = button.dataset.feedbackContent;
    });

    document.getElementById('userDetailsModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('user-name').textContent = button.dataset.userName;
        document.getElementById('user-email').textContent = button.dataset.userEmail;
        document.getElementById('user-role').textContent = button.dataset.userRole;
        document.getElementById('user-address').textContent = button.dataset.userAddress;
        document.getElementById('user-phone').textContent = button.dataset.userPhone;
        document.getElementById('user-profile').src = button.dataset.userProfile;
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

@if (session('showAlertDelete'))
<script>
    Swal.fire({
        title: "User's feedback deleted successfully!",
        text: '{{ session("success") }}',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff9800',
        showCloseButton: true,
    });
</script>
@endif

{{-- ===================================================== --}}
{{-- STYLES                                                --}}
{{-- ===================================================== --}}
<style>
    .dashboard-wrapper {
        margin-top: 60px;
        background: #f1f3f9;
        min-height: calc(100vh - 60px);
    }

    /* ============ KPI STRIP ============ */
    .kpi-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    @media (max-width: 991px) {
        .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 420px) {
        .kpi-grid { grid-template-columns: 1fr; }
    }

    .kpi-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.1rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        border: 1px solid #eef0f5;
        position: relative;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.1);
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 5px;
    }
    .kpi-card--amber::before  { background: #f59e0b; }
    .kpi-card--blue::before   { background: #3b82f6; }
    .kpi-card--green::before  { background: #10b981; }
    .kpi-card--purple::before { background: #8b5cf6; }

    .kpi-card__content { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
    .kpi-card__label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6b7280;
    }
    .kpi-card__value {
        font-size: 1.7rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.1;
    }
    .kpi-card__hint { font-size: 0.72rem; color: #9ca3af; }

    .kpi-card__icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .kpi-card--amber  .kpi-card__icon { background: #fef3c7; color: #f59e0b; }
    .kpi-card--blue   .kpi-card__icon { background: #dbeafe; color: #3b82f6; }
    .kpi-card--green  .kpi-card__icon { background: #d1fae5; color: #10b981; }
    .kpi-card--purple .kpi-card__icon { background: #ede9fe; color: #8b5cf6; }

    /* ============ DASH CARDS ============ */
    .dash-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #eef0f5;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .dash-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.9rem 1.1rem;
        border-bottom: 1px solid #f1f3f9;
    }
    .dash-card__title {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #111827;
    }
    .dash-card__body { padding: 0.9rem 1.1rem; }
    .dash-scroll { overflow-y: auto; }
    .dash-scroll::-webkit-scrollbar { width: 6px; }
    .dash-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    .date-input { max-width: 170px; }

    /* ============ LIST ROW ============ */
    .list-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0.85rem;
        border-radius: 10px;
        background: #f9fafb;
        margin-bottom: 0.5rem;
        transition: background .15s ease, transform .15s ease;
    }
    .list-row:last-child { margin-bottom: 0; }
    .list-row:hover { background: #f3f4f6; transform: translateX(2px); }
    .list-row__main { flex: 1 1 auto; min-width: 0; }
    .list-row__title {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 600;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .list-row__meta {
        font-size: 0.75rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .list-row__warn { font-size: 0.75rem; color: #ef4444; margin: 0; }
    .list-row__rating { color: #f59e0b; font-size: 0.9rem; white-space: nowrap; }

    @media (max-width: 480px) {
        .list-row { flex-wrap: wrap; }
        .list-row__rating { order: 3; }
    }

    /* ============ CHART ============ */
    .chart-wrap { position: relative; height: 260px; width: 100%; }

    /* ============ TOP FIXER ============ */
    .fixer-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.75rem;
    }
    @media (max-width: 480px) {
        .fixer-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    .fixer-card {
        background: #f9fafb;
        border-radius: 12px;
        padding: 0.85rem 0.5rem;
        text-align: center;
        transition: transform .2s ease, box-shadow .2s ease;
        border: 1px solid #f1f3f9;
    }
    .fixer-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
    }
    .fixer-card__avatar {
        width: 56px; height: 56px;
        margin: 0 auto 8px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }
    .fixer-card__avatar img { width: 100%; height: 100%; object-fit: cover; }
    .fixer-card__name {
        font-size: 0.82rem;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fixer-card__meta { font-size: 0.7rem; color: #6b7280; margin: 2px 0 4px; }
    .fixer-card__stars { color: #f59e0b; font-size: 0.85rem; margin-bottom: 6px; }
    .fixer-card__btn { font-size: 0.7rem; padding: 0.2rem 0.55rem; }

    /* ============ FEEDBACK ============ */
    .feedback-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.65rem;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        transition: background .15s ease;
    }
    .feedback-row:hover { background: #f3f4f6; }
    .feedback-row__avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .feedback-row__body { flex: 1 1 auto; min-width: 0; }
    .feedback-row__name {
        font-size: 0.82rem;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }
    .feedback-row__text {
        font-size: 0.72rem;
        color: #6b7280;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .feedback-row__actions { display: flex; gap: 4px; flex-shrink: 0; }

    /* ============ EMPTY STATE ============ */
    .empty-state {
        text-align: center;
        padding: 1.5rem 1rem;
        color: #9ca3af;
    }
    .empty-state i { font-size: 2.2rem; display: block; margin-bottom: 6px; opacity: .7; }
    .empty-state p { margin: 0; font-size: 0.85rem; }

    /* ============ MODAL TWEAKS ============ */
    .feedback-modal-img { max-height: 180px; object-fit: cover; }
    .user-profile-container img {
        width: 100%;
        max-height: 230px;
        object-fit: cover;
    }
    .service-image-container { overflow: hidden; border-radius: 10px; }
    .service-image-container img {
        width: 100%; max-height: 230px; object-fit: cover;
        transition: transform 0.3s ease;
    }
    .service-image-container img:hover { transform: scale(1.05); }
    .modal-content { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* "View all" footer links on dashboard cards */
    .dash-card__footer { display: flex; justify-content: center; padding: .55rem 1.1rem .9rem; }
    .dash-toggle {
        display: inline-block; border: none; background: #fff7ed; color: #b45309;
        font-weight: 600; font-size: .8rem; padding: .45rem 1.15rem; border-radius: 9px;
        cursor: pointer; text-decoration: none; transition: background .15s ease, color .15s ease;
    }
    .dash-toggle:hover { background: #f59e0b; color: #fff; }
</style>
</x-app-layout>
