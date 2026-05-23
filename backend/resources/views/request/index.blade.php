<x-app-layout>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <div class="container-fluid px-4 py-4">
        @include('booking._tabs')
        <div class="mb-2 d-flex gap-3 align-items-center">
            <button id="immediately" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm" style="padding: 10px 20px; font-size: 1.1rem; border-radius: 10px; transition: all 0.3s ease;">
                <i class='bx bxs-user-voice me-2' style='font-size: 1.5rem;'></i>
                Immediately
            </button>
            <button id="dead" class="btn btn-warning d-flex align-items-center shadow-sm" style="padding: 10px 20px; font-size: 1.1rem; border-radius: 10px; transition: all 0.3s ease;">
                <i class='bx bxs-calendar me-2' style='font-size: 1.5rem;'></i>
                Deadline
            </button>
            <span id='showAll' style="font-size: 1.1rem; cursor: pointer; transition: color 0.3s ease;" class="show-all">Show All</span>
        </div>

        <!-- Customer feedback section -->
        <div class="customer-feedback bg-white p-3 rounded-lg shadow">
            @php $requestCount = $bookings->where('action', 'request')->count(); @endphp
            <div class="title d-flex align-items-center justify-content-between mb-3">
                <h6 class="qf-list-title"><i class='bx bxs-inbox'></i> Booking in Request</h6>
                <span class="qf-count-pill">{{ $requestCount }} {{ \Illuminate\Support\Str::plural('request', $requestCount) }}</span>
            </div>
            <div class="customer-feedback-info d-flex flex-column gap-3 pt-2">
                @can('Request access')
                    @foreach ($bookings->filter(function($booking) {
                        return $booking->action === 'request';
                    }) as $booking)
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
                                    <img src="{{ $customer->profile }}"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($customer->name ?? 'User') }}&background=f59e0b&color=fff&bold=true'"
                                         class="qf-bk-avatar" alt="{{ $customer->name }}">
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
                                    <button class="btn btn-outline-warning btn-sm qf-bk-btn"
                                        data-bs-toggle="modal" data-bs-target="#bookingDetailsModal"
                                        data-booking-image="{{$customer->profile}}"
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

    <style>
        /* Tab buttons lift (scoped so it doesn't recolor Detail / Delete) */
        #immediately:hover, #dead:hover {
            background-color: #ffca2c;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        .show-all { padding: 8px 14px; border-radius: 10px; transition: all .25s ease; }
        .show-all:hover { color: #b45309; background: #fff7e6; }

        /* List header */
        .qf-list-title { font-size: 1rem; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: .4rem; margin: 0; }
        .qf-list-title i { color: #f59e0b; }
        .qf-count-pill { background: rgba(245,158,11,.13); color: #b45309; font-weight: 700; font-size: .75rem; padding: .25rem .7rem; border-radius: 999px; }

        /* Booking rows */
        .qf-booking-card {
            display: flex; align-items: center; gap: 1rem;
            background: #fff; border: 1px solid #eef0f3; border-left: 4px solid #e5e7eb;
            border-radius: 12px; padding: .8rem 1.1rem;
            transition: box-shadow .2s ease, transform .15s ease, border-color .2s ease;
        }
        .qf-booking-card:hover { box-shadow: 0 8px 22px rgba(0,0,0,.08); transform: translateY(-1px); }
        #immediate .qf-booking-card { border-left-color: #f59e0b; }
        #deadline  .qf-booking-card { border-left-color: #3b82f6; }

        .qf-bk-customer { display: flex; align-items: center; gap: .75rem; flex: 1 1 auto; min-width: 0; }
        .qf-bk-avatar { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid #f1f1f1; flex: 0 0 auto; }
        .qf-bk-customer-meta { display: flex; flex-direction: column; min-width: 0; }
        .qf-bk-name { font-weight: 700; font-size: .9rem; color: #1f2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .qf-bk-service { font-size: .76rem; color: #6b7280; display: flex; align-items: center; gap: .3rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .qf-bk-service i { color: #f59e0b; }

        .qf-bk-type { flex: 0 0 150px; }
        .qf-tag { display: inline-flex; align-items: center; gap: .35rem; font-size: .72rem; font-weight: 700; padding: .32rem .7rem; border-radius: 999px; }
        .qf-tag-now { background: rgba(245,158,11,.13); color: #b45309; }
        .qf-tag-deadline { background: rgba(59,130,246,.12); color: #1d4ed8; }

        .qf-bk-date { flex: 0 0 160px; display: flex; align-items: center; gap: .55rem; color: #374151; }
        .qf-bk-date > i { font-size: 1.4rem; color: #9aa1ab; }
        .qf-bk-date-text { display: flex; flex-direction: column; line-height: 1.2; }
        .qf-bk-date-label { font-size: .65rem; color: #9aa1ab; text-transform: uppercase; letter-spacing: .4px; }
        .qf-bk-date-value { font-weight: 600; font-size: .82rem; }

        .qf-bk-actions { flex: 0 0 auto; display: flex; gap: .5rem; }
        .qf-bk-btn { display: inline-flex; align-items: center; gap: .3rem; border-radius: 8px; font-size: .78rem; font-weight: 600; padding: .35rem .75rem; }

        .qf-bk-empty { text-align: center; padding: 3rem 1rem; color: #9aa1ab; font-size: .9rem; }
        .qf-bk-empty i { font-size: 2.6rem; display: block; margin-bottom: .5rem; color: #d1d5db; }

        @media (max-width: 768px) {
            .qf-booking-card { flex-wrap: wrap; }
            .qf-bk-type, .qf-bk-date { flex-basis: auto; }
        }
    </style>

    <script>
        let immediatelyButton = document.querySelector('#immediately');
        let deadButton = document.querySelector('#dead');
        let deadElements = document.querySelectorAll('#deadline');
        let immediateElements = document.querySelectorAll('#immediate');
        let showAll = document.querySelector('#showAll');
        
        showAll.addEventListener('click', function () {
            deadElements.forEach(function (element) {
                element.style.display = 'block';
            });
            immediateElements.forEach(function (element) {
                element.style.display = 'block';
            });
        });

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
