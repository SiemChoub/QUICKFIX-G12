<x-app-layout>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <div class="container-fluid px-4 py-4">
        @include('booking._tabs')
        @include('booking._card_styles')

        <!-- Customer feedback section -->
        <div class="customer-feedback bg-white p-3 rounded-lg shadow">
            @php $requestCount = $bookings->where('action', 'request')->count(); @endphp
            <div class="title d-flex align-items-center justify-content-between mb-3">
                <h6 class="qf-list-title"><i class='bx bxs-inbox'></i> Booking in Request</h6>
                <span class="qf-count-pill">{{ $requestCount }} {{ \Illuminate\Support\Str::plural('request', $requestCount) }}</span>
            </div>
            <div class="customer-feedback-info d-flex flex-column gap-3 pt-2">
                @can('Request access')
                    @foreach ($requests as $booking)
                        @php
                            $service_name = 'No Service selected';
                            $customer = $users->where('id', $booking->user_id)->first();
                            $fixer = $users->where('id', $booking->fixer_id)->first();
                            if($booking->fixer_id != null){
                                $fixer_id = $booking->fixer_id;
                                $fixer_name = $users->where('id', $fixer_id)->pluck('name')->first();
                            }else{
                                $fixer_name = 'No Fixer selected';
                            }

                            if ($booking->type == 'immediately') {
                                $booking_date = $immediatelys->where('id', $booking->booking_type_id)->pluck('created_at')->first();
                                $deadline = 'Fix now';
                                $customer_message = $immediatelys->where('id', $booking->booking_type_id)->pluck('message')->first();
                                $customer_imagesend = $immediatelys->where('id', $booking->booking_type_id)->pluck('image')->first();
                                $service_id = $immediatelys->where('id', $booking->booking_type_id)->pluck('service_id')->first();
                            } elseif ($booking->type == 'deadline') {
                                $customer_message = $deadlines->where('id', $booking->booking_type_id)->pluck('message')->first();
                                $customer_imagesend = $deadlines->where('id', $booking->booking_type_id)->pluck('image')->first();
                                $booking_date = $deadlines->where('id', $booking->booking_type_id)->pluck('created_at')->first();
                                $deadline = $deadlines->where('id', $booking->booking_type_id)->pluck('date_todo')->first();
                                $service_id = $deadlines->where('id', $booking->booking_type_id)->pluck('service_id')->first();
                            }

                            if (isset($service_id) && $service_id != null) {
                                $service_name = $services->where('id', $service_id)->pluck('name')->first();
                            }
                        @endphp
                        <div id="{{ $booking->type == 'immediately' ? 'immediate' : 'deadline' }}" class="qf-booking-item">
                            <div class="qf-booking-card">
                                {{-- Customer --}}
                                <div class="qf-bk-customer">
                                    <img src="{{ $customer?->profile ?: 'https://ui-avatars.com/api/?name=' . urlencode($customer?->name ?? 'User') . '&background=f59e0b&color=fff&bold=true' }}"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($customer?->name ?? 'User') }}&background=f59e0b&color=fff&bold=true'"
                                         class="qf-bk-avatar" alt="{{ $customer?->name ?? 'User' }}">
                                    <div class="qf-bk-customer-meta">
                                        <span class="qf-bk-name">{{ $customer->name ?? 'Unknown user' }}</span>
                                        <span class="qf-bk-service"><i class='bx bx-wrench'></i> {{ $service_name }}</span>
                                    </div>
                                </div>

                                {{-- Type --}}
                                <div class="qf-bk-type">
                                    @if ($booking->type == 'immediately')
                                        <span class="qf-tag qf-tag-now"><i class='bx bxs-user-voice'></i> Immediately</span>
                                    @else
                                        <span class="qf-tag qf-tag-deadline"><i class='bx bxs-calendar'></i> Deadline</span>
                                    @endif
                                </div>

                                {{-- Requested date --}}
                                <div class="qf-bk-date">
                                    <i class='bx bx-calendar-event'></i>
                                    <span class="qf-bk-date-text">
                                        <span class="qf-bk-date-label">Requested</span>
                                        <span class="qf-bk-date-value">{{ $booking_date ? \Illuminate\Support\Carbon::parse($booking_date)->format('d M Y') : '—' }}</span>
                                    </span>
                                </div>

                                {{-- Actions --}}
                                <div class="qf-bk-actions">
                                    <a href="{{ route('admin.requests.show', $booking->id) }}" class="btn btn-outline-warning btn-sm qf-bk-btn">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                    @can('Request delete')
                                        <button type="button" class="btn btn-danger btn-sm qf-bk-btn" onclick="confirmDelete({{ $booking->id }})">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $booking->id }}" action="{{ route('admin.requests.destroy', $booking->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($requestCount === 0)
                        <div class="qf-bk-empty">
                            <i class='bx bx-calendar-x'></i>
                            <div>No booking requests right now</div>
                        </div>
                    @endif
                @endcan
            </div>

            @include('booking._pagination', ['paginator' => $requests, 'default' => 20])
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

    @if(session('showAlertDelete'))
        <script>
            Swal.fire({
                title: 'Booking deleted successfully!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ff9800',
                showCloseButton: true,
            });
        </script>
    @endif


    <script>
        let immediatelyButton = document.querySelector('#immediately');
        let deadButton = document.querySelector('#dead');
        let deadElements = document.querySelectorAll('#deadline');
        let immediateElements = document.querySelectorAll('#immediate');

        immediatelyButton.addEventListener('click', function () {
            deadElements.forEach(function (element) {
                element.style.display = 'none';
            });
            immediateElements.forEach(function (element) {
                element.style.display = 'block';
            });
        });

        deadButton.addEventListener('click', function () {
            deadElements.forEach(function (element) {
                element.style.display = 'block';
            });
            immediateElements.forEach(function (element) {
                element.style.display = 'none';
            });
        });



    </script>
</x-app-layout>
