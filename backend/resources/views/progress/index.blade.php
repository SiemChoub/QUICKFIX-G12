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
                                        <button class="btn btn-outline-warning btn-sm qf-bk-btn"
                                            data-bs-toggle="modal" data-bs-target="#bookingDetailsModal"
                                            @if(isset($customer->profile))
                                                data-booking-image="{{$customer->profile}}"
                                            @endif
                                            data-booking-stars="{{$service_name}}"
                                            data-booking-type="{{$booking->type}}"
                                            data-booking-date="{{$booking_date}}"
                                            data-booking-deadline="{{$deadline}}"
                                            data-booking-fixname="{{$fixer_name}}"
                                            data-booking-customername="{{$customer->name}}"
                                            data-booking-customeremail="{{$customer->email}}"
                                            data-booking-customerphone="{{$customer->phone}}"
                                            data-booking-customeraddress="{{$customer->address}}"
                                            @if($fixer)
                                                data-booking-fixername="{{$fixer->name}}"
                                                data-booking-fixeremail="{{$fixer->email}}"
                                                data-booking-fixerphone="{{$fixer->phone}}"
                                                data-booking-fixeraddress="{{$fixer->address}}"
                                            @else
                                                data-booking-fixername="No fixer selected !!"
                                                data-booking-fixeremail="none"
                                                data-booking-fixerphone="none"
                                                data-booking-fixeraddress="none"
                                            @endif
                                            @if($customer_message  || $customer_imagesend)
                                                data-booking-customermessage="{{$customer_message}}"
                                                data-booking-customerimage="{{$customer_imagesend}}"
                                                data-booking-nomessage="There are message!!"
                                            @else
                                                data-booking-nomessage="No message!!"
                                            @endif
                                            data-booking-additional-info="This is additional information about the booking.">
                                            <i class="bx bx-show"></i> Detail
                                        </button>
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

    <!-- Booking detail modal -->
    <div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="margin-left:350px">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="bookingDetailsModalLabel">Booking Detail</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id='close'></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-5" id='image-customer'style='display:none'>
                        <div class="service-image-container" style="height: 230px;">
                            <img src="" class="img-fluid rounded" style="object-fit: cover;width:100%;height:100%"  alt="Base64 Image" id="booking-customerSendImage"> 
                            <span class="bg-warning p-2 border rounded-lg text-white" id='booking-customerMessage'></span>
                        </div>
                        <div class="btn mt-5 text-center " id='back'>
                           <i class="bx bx-arrow-back mr-2 animate-pulse"></i>
                            Back 
                        </div>   
                    </div>
                    <!-- ---------------------customer profile------------------------ -->
                        <div class="col-md-5"  id='profile-customer'>
                            <div class="booking-image-container" style="height: 230px;">
                                <div class="d-flex align-items-center gap-3  ">
                                    <img src="" class="card rounded-circle" alt="..." style="height: 5rem; width: 5rem;" alt="Booking Image" id="booking-image">
                                    <div>
                                        <h5 id='booking-customerName'></h5>
                                        <span class="text-gray-600 text-sm" style="font-size: 12px;" id='booking-customerEmail'></span>
                                    </div>
                                </div>
                                <div class="user-details-body mt-4">
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-user-detail'></i>
                                        <span class="ms-2"><strong>Role: </strong> <span id="user-role">Custommer</span></span>
                                    </div>
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-map'></i>
                                        <span class="ms-2 mt-3"><strong>Address:</strong> <span  id='booking-customerAddress'></span></span>
                                    </div>
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-phone'></i>
                                        <span class="ms-2 mt-3"><strong>Phone:</strong> <span id='booking-customerPhone'></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="btn mt-3 text-center " id='customer_message'>
                            Custommer Message
                            </div>
                            <i class='bx bxs-message-rounded-dots bx-tada text-yellow-300 text-3xl -ml-3' ></i>
                        </div>
                        <!-- --------------------------------customer profile end------------------------------- -->
                        <!-- --------------------------------fixer profile ------------------------------- -->
                        <div class="col-md-5"  id='profile-fixer' style='display:none'>
                            <div class="booking-image-container" style="height: 230px;">
                                <div class="d-flex align-items-center gap-3  ">
                                    <img src="" class="card rounded-circle" alt="..." style="height: 5rem; width: 5rem;" alt="Booking Image" id="booking-profile">
                                    <div>
                                        <h5 id='booking-fixerName'></h5>
                                        <span class="text-gray-600 text-sm" style="font-size: 12px;" id='booking-fixerEmail'></span>
                                    </div>
                                </div>
                                <div class="user-details-body mt-4">
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-user-detail'></i>
                                        <span class="ms-2"><strong>Role: </strong> <span id="user-role">Fixer</span></span>
                                    </div>
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-map'></i>
                                        <span class="ms-2 mt-3"><strong>Address:</strong> <span  id='booking-fixerAddress'></span></span>
                                    </div>
                                    <div class="user-details d-flex align-items-center">
                                        <i class='bx bxs-phone'></i>
                                        <span class="ms-2 mt-3"><strong>Phone:</strong> <span id='booking-fixerPhone'></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="btn  text-center " id='backs'>
                           <i class="bx bx-arrow-back mr-2 animate-pulse"></i>
                            Back 
                        </div>  
                        </div>
                        <div class="col-md-7 mt-4" id='booking-info' >
                            <div class="shadow p-2 " style='background-color: #f8f9fa;'>
                                <h4 class="text-warning" id="booking-type">
                                </h4>
                                <div class="rating mb-3">
                                    <p><i class='bx bxs-star'></i> <strong>Service: </strong> <span id="booking-stars"></span></p>
                                </div>  
                                <div class="booking-details">
                                    <p><i class='bx bxs-calendar'></i> <strong>Booking date: </strong><span id="booking-date"></span></p>
                                    <p><i class='bx bxs-calendar-check'></i> <strong>Deadline: </strong><span id="booking-deadline"></span></p>
                                    <p><i class='bx bxs-user'></i> <strong>Fixer: </strong><span id="booking-fixName"></span><span class="btn text-center" id='fixer_view'><i class="bx bx-right-arrow-alt animate-pulse "style='font-size: 2rem;'></i></span></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="additional-info m-3">
                        <h5><i class='bx bx-info-circle'></i> Additional Information</h5>
                    </div>
                </div>
            </div>
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

        let close = document.querySelector('#close');
        let back = document.querySelector('#back');
        let backs = document.querySelector('#backs');
        let customer_message = document.querySelector('#customer_message');
        let image_customer = document.querySelector('#image-customer');
        let profile_customer = document.querySelector('#profile-customer');
        let profile_fixer = document.querySelector('#profile-fixer');
        let booking_info = document.querySelector('#booking-info');
        let fixer_view = document.querySelector('#fixer_view');

        backs.addEventListener('click', function () {
            profile_fixer.style.display='none';
            booking_info.style.display = 'block';
        });
        close.addEventListener('click', function () {
            profile_fixer.style.display='none';
            booking_info.style.display = 'block';
        });
        back.addEventListener('click', function () {
            image_customer.style.display='none';
            profile_customer.style.display = 'block';
        });
        close.addEventListener('click', function () {
            image_customer.style.display='none';
            profile_customer.style.display = 'block';
        });
        customer_message.addEventListener('click', function () {
            image_customer.style.display='block';
            profile_customer.style.display = 'none';
        });

        fixer_view.addEventListener('click', function () {
            profile_fixer.style.display='block';
            booking_info.style.display = 'none';
        });

    document.getElementById('bookingDetailsModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('booking-image').src = button.dataset.bookingImage;
        document.getElementById('booking-customerSendImage').src = button.dataset.bookingCustomerimage;
        document.getElementById('customer_message').textContent = button.dataset.bookingNomessage;
        document.getElementById('booking-stars').textContent = button.dataset.bookingStars;
        document.getElementById('booking-type').textContent = button.dataset.bookingType;
        document.getElementById('booking-date').textContent = button.dataset.bookingDate;
        document.getElementById('booking-deadline').textContent = button.dataset.bookingDeadline;
        document.getElementById('booking-fixName').textContent = button.dataset.bookingFixname;
        document.getElementById('booking-customerName').textContent = button.dataset.bookingCustomername;
        document.getElementById('booking-customerEmail').textContent = button.dataset.bookingCustomeremail; 
        document.getElementById('booking-customerPhone').textContent = button.dataset.bookingCustomerphone; 
        document.getElementById('booking-customerAddress').textContent = button.dataset.bookingCustomeraddress; 
        document.getElementById('booking-customerMessage').textContent = button.dataset.bookingCustomermessage; 
        document.getElementById('booking-fixerName').textContent = button.dataset.bookingFixername;
        document.getElementById('booking-fixerEmail').textContent = button.dataset.bookingFixeremail; 
        document.getElementById('booking-fixerPhone').textContent = button.dataset.bookingFixerphone; 
        document.getElementById('booking-fixerAddress').textContent = button.dataset.bookingFixeraddress; 
        document.getElementById('booking-customerMessage').textContent = button.dataset.bookingCustomermessage; 
        document.getElementById('booking-additional-info').textContent = button.dataset.bookingAdditionalInfo;
    });

    </script>
</x-app-layout>
