<x-app-layout>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <div class="container-fluid px-4 py-4">
        @include('booking._tabs')
        @include('booking._card_styles')
        <div class="mb-2 d-flex gap-3 align-items-center">
            @php
                $count = 0;
                foreach ($FixingProgress as $booking) {
                    if ($booking['action'] == 'done') {
                        $count++;
                    }
                }
            @endphp
            <div class="ml-8 d-flex align-items-center">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M7.646 12.354a.5.5 0 0 0 .708 0L13 7.707V9.5a.5.5 0 0 0 1 0V6a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h1.793l-4.147 4.146a.5.5 0 0 0 0 .708z"/>
                    <path d="M4.5 0A3.5 3.5 0 0 1 8 3.5 3.5 3.5 0 0 1 4.5 7 3.5 3.5 0 0 1 1 3.5 3.5 3.5 0 0 1 4.5 0zM12 3.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                </svg>
                Successfully fixing: 
                <span class="fixing-count ml-1" title="Successfully fixing">{{$count}}
                </span>        
            </div>
            </div>

        <!-- Customer feedback section -->
        <div class="customer-feedback bg-white p-3 rounded-lg shadow">
            <div class="title d-flex align-items-center justify-content-between mb-3">
                <h6 class="qf-list-title"><i class='bx bx-check-circle'></i> Successfully Services</h6>
                <span class="qf-count-pill">{{ $items->total() }} done</span>
            </div>
            <div class="customer-feedback-info d-flex flex-column gap-3 pt-2">
                @can('Done access')
                    @foreach($items as $ha)
                        @php
                            $booking = $bookings->where('id', $ha->booking_id)->first();
                        @endphp
                        @if (!empty($booking))
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

                                if (isset($service_id) || $service_id != null) {
                                    $service_name = $services->where('id', $service_id)->pluck('name')->first();
                                }
                            @endphp
                            <div id="{{ $booking->type == 'immediately' ? 'immediate' : 'deadline' }}" class="qf-booking-item">
                                <div class="qf-booking-card">
                                    {{-- Customer --}}
                                    <div class="qf-bk-customer">
                                        <img src="{{ $customer->profile ?? '' }}"
                                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($customer->name ?? 'User') }}&background=f59e0b&color=fff&bold=true'"
                                             class="qf-bk-avatar" alt="{{ $customer->name ?? '' }}">
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

                                    {{-- Fixer --}}
                                    <div class="qf-bk-fixer">
                                        @if ($fixer)
                                            <img src="{{ $fixer->profile ?? '' }}"
                                                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($fixer->name ?? 'Fixer') }}&background=0ea5e9&color=fff&bold=true'"
                                                 class="qf-bk-avatar-sm" alt="{{ $fixer->name }}">
                                        @else
                                            <span class="qf-bk-fixer-icon"><i class='bx bx-user'></i></span>
                                        @endif
                                        <div class="qf-bk-fixer-meta">
                                            <span class="qf-bk-fixer-label">Fixer</span>
                                            <span class="qf-bk-fixer-name">{{ $fixer_name }}</span>
                                        </div>
                                    </div>

                                    {{-- Date --}}
                                    <div class="qf-bk-date">
                                        <i class='bx bx-calendar-check'></i>
                                        <span class="qf-bk-date-text">
                                            <span class="qf-bk-date-label">Date</span>
                                            <span class="qf-bk-date-value">{{ $booking_date ? \Illuminate\Support\Carbon::parse($booking_date)->format('d M Y') : '—' }}</span>
                                        </span>
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <span class="qf-status qf-status-done"><i class='bx bx-check-circle'></i> Completed</span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="qf-bk-actions">
                                        <a href="{{ route('admin.dones.show', $booking->id) }}" class="btn btn-outline-warning btn-sm qf-bk-btn">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if ($items->total() === 0)
                        <div class="qf-bk-empty">
                            <i class='bx bx-check-circle'></i>
                            <div>No completed bookings yet</div>
                        </div>
                    @endif
                @endcan
            </div>

            @include('booking._pagination', ['paginator' => $items, 'default' => 20])
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <style>
    .fixing-count {
        display: inline-block;
        position: relative;
        padding: 5px 10px;
        background-color: #28a745; /* Success color */
        color: #fff; /* White text */
        border-radius: 20px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .fixing-count .icon {
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
        animation: pulse 1s infinite alternate;
    }

    .fixing-count:hover {
        background-color: #218838; /* Darker shade for hover */
    }

    @keyframes pulse {
        from {
            transform: scale(1);
        }
        to {
            transform: scale(1.1);
        }
    }
    </style>

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
