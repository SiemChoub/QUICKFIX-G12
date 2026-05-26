<x-app-layout>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <div class="container-fluid px-4 py-4">
        @include('booking._tabs')
        @include('booking._card_styles')

        <!-- Customer feedback section -->
        <div class="customer-feedback bg-white p-3 rounded-lg shadow">
            <div class="title d-flex align-items-center justify-content-between mb-3">
                <h6 class="qf-list-title"><i class='bx bx-loader-circle'></i> Booking in Progress</h6>
                <span class="qf-count-pill">{{ $items->total() }} {{ \Illuminate\Support\Str::plural('booking', $items->total()) }}</span>
            </div>
            <div class="customer-feedback-info d-flex flex-column gap-3 pt-2">
                @can('Progress access')
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
                                    $deadline = 'Fix now';
                                    $customer_message = $immediatelys->where('id', $booking->booking_type_id)->pluck('message')->first();
                                    $customer_imagesend = $immediatelys->where('id', $booking->booking_type_id)->pluck('image')->first();
                                    $service_id = $immediatelys->where('id', $booking->booking_type_id)->pluck('service_id')->first();
                                } elseif ($booking->type == 'deadline') {
                                    $customer_message = $deadlines->where('id', $booking->booking_type_id)->pluck('message')->first();
                                    $customer_imagesend = $deadlines->where('id', $booking->booking_type_id)->pluck('image')->first();
                                    $deadline = $deadlines->where('id', $booking->booking_type_id)->pluck('date')->first();
                                    $service_id = $deadlines->where('id', $booking->booking_type_id)->pluck('service_id')->first();
                                }
                                $booking_date = $booking->created_at;
                                if (isset($service_id) && $service_id != null) {
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
                                        <i class='bx bx-calendar-event'></i>
                                        <span class="qf-bk-date-text">
                                            <span class="qf-bk-date-label">Started</span>
                                            <span class="qf-bk-date-value">{{ $booking_date ? \Illuminate\Support\Carbon::parse($booking_date)->format('d M Y') : '—' }}</span>
                                        </span>
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <span class="qf-status qf-status-progress"><i class='bx bx-loader-circle bx-spin'></i> In progress</span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="qf-bk-actions">
                                        <a href="{{ route('admin.progresss.show', $booking->id) }}" class="btn btn-outline-warning btn-sm qf-bk-btn">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        @can('Request delete')
                                            <button type="button" class="btn btn-danger btn-sm qf-bk-btn" onclick="confirmDelete({{ $booking->id }})">
                                                <i class="bx bx-trash"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $booking->id }}" action="{{ route('admin.progresss.destroy', $booking->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if ($items->total() === 0)
                        <div class="qf-bk-empty">
                            <i class='bx bx-loader-circle'></i>
                            <div>No bookings in progress</div>
                        </div>
                    @endif
                @endcan
            </div>

            @include('booking._pagination', ['paginator' => $items, 'default' => 20])
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
