<x-app-layout>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <div class="container  mt-5">
        <div class=" col mb-3 ">
            <div class=" d-flex  justify-content-between -mt-5 mb-3">
                <div class=" mb-2 shadow">
                    @can('Payment create')
                        <a href="{{ route('admin.payments.create') }}" class="btn btn-warning d-flex align-items-center">
                            <i class='bx bxs-plus-circle mr-2' style='font-size:30px'></i>
                            Create New
                        </a>
                    @endcan
                </div>
                <div class=" mb-2 shadow">
                    <span class="btn btn-warning p-2 w-100 d-flex align-items-center">
                        <i class="fas fa-tools mr-2" style="font-size:25px"></i>
                        Fixers: {{ count($users->where('role', 'fixer')) }}
                    </span>
                </div>
                <h4 class='shadow text-center p-2 border around-50'><i class='bx bx-category'></i> CATEGORY MANAGEMENT
                </h4>
                <div class="w-60 bg-white rounded d-flex align-items-center shadow" style="height: 40px;">
                    <div class="input-group h-100">
                        <input type="text" id="search-input" class="form-control border-0 shadow-none h-100"
                            placeholder="Search" aria-label="Search">
                        <div class="input-group-append h-100">
                            <div class="btn bg-warning pt-2 h-100">
                                <i class='bx bx-search-alt'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ------------------------------ month --------------------------- --}}
            @php
                $currentYear = date('Y');
                $years = range($currentYear, $currentYear - 2);
                $months = [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December',
                ];
            @endphp
            <div class="d-flex gap-3 w-30rem">
                <div class="dropdown mb-3 bg-warning p-3 shadow rounded-3" style="width: 150px">
                    <button class="btn border-1 bg-light w-100 dropdown-toggle shadow" type="button" id="yearDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Year
                    </button>
                    <ul class="dropdown-menu w-30rem" aria-labelledby="yearDropdown" id="year-select">
                        <li><a class="dropdown-item" href="#" onclick="filterPayments('all', null)">Select All</a>
                        </li>
                        @foreach ($years as $year)
                            <li><a class="dropdown-item year-item" href="#"
                                    data-year="{{ $year }}">{{ $year }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div id="card-month" class="card p-2 w-20rem" style="display:none;">
                    <ul class="w-100 d-flex flex-column text-danger list-none" id="month-select">
                        <li><a class="dropdown-item" href="#" onclick="filterPayments(null, 'all')">Select All</a>
                        </li>
                        @foreach ($months as $monthNumber => $monthName)
                            <li><a class="dropdown-item month-item" href="#"
                                    data-month="{{ $monthNumber }}">{{ $monthName }}</a></li>
                        @endforeach
                    </ul>
                </div>
                {{-- </div> --}}

                {{-- </div> --}}
                {{-- ---------- Month -----------  --}}
                <div class="mb-3 bg-warning p-3 shadow rounded-3">
                    {{-- <strong>Paid/No</strong> --}}

                    <select class="form-select shadow" aria-label="Select Status" id="status-select"
                        onchange="filterPaymentsPaid('Paid/No')">
                        <option class="bg-dark" value="all">Paid/No</option>
                        <option class="bg-dark" value="all">Select All</option>
                        <option value="no">No</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                {{--  --}}
                {{--  --}}
                <div class="mb-3 bg-warning d-flex align-items-center p-3 mr-0 shadow rounded-3">
                    {{-- <h5>Trash</h5> --}}
                    <div class="trash d-flex align-items-center gap-3">
                        <h5>Trash<i class="fas fa-trash"></i></h5>
                    </div>
                </div>
                {{--  --}}
                {{--  --}}
                <div class="mb-3 bg-warning d-flex align-items-center p-3 mr-0 shadow rounded-3">
                    {{-- <h5>Trash</h5> --}}
                    <div class="show d-flex align-items-center gap-3">
                        <strong id="show-data" style="display: block;">
                            <a class="show-data" href="#" data-year="{{ $year }}" data-month="{{ $monthNumber }}">{{ $year }} / {{ $monthName }}</a>
                            show year / month
                        </strong>
                    </div>
                </div>
                {{--  --}}
                {{--  --}}
                <div class="mb-3 bg-warning d-flex align-items-center p-3 mr-0 shadow rounded-3">
                    {{-- <h5>Trash</h5> --}}
                 
                    <div class=" mb-2 shadow">
                        {{-- @can('Payment edit')
                            <a href="{{ route('admin.payments.edit') }}" class="btn btn-warning d-flex align-items-center">
                                <i class='bx bxs-plus-circle mr-2' style='font-size:30px'></i>
                                Create New
                            </a>
                        @endcan --}}
                    </div>
                </div>
                {{--  --}}
            </div>
            {{-- ---------------------- the start table ---------------------- --}}

            <div id="payments-table" class="table-responsive ">
                <table class="table table-striped w-100 ">
                    <thead class="bg-warning">
                        <tr>
                            <th scope="col" class='text-center'>Fixer Name</th>
                            <th scope="col" class='text-center'>Price</th>
                            {{-- <th scope="col" class='text-center'>Date Paid</th> --}}
                            <th scope="col" class='text-center'>Deadline</th>
                            <th scope="col" class='text-center'>Description</th>
                            <th scope="col" class='text-center'>Status</th>
                            <th scope="col" class='text-center'>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="payment-table-body" class="w-100">
                        @can('Payment access')
                            @foreach ($payments as $payment)
                                @php
                                    $fixer = $users->where('id', $payment->fixer_id)->first();
                                    // $yearCreated = \Carbon\Carbon::parse($payment->created_at)->year;
                                    $yearDeadline = \Carbon\Carbon::parse($payment->deadline)->year;
                                    $monthCreated = \Carbon\Carbon::parse($payment->created_at)->month;
                                    $monthDeadline = \Carbon\Carbon::parse($payment->deadline)->month;
                                    $numberPayment = count($payments->where('fixer_id', $fixer->id));
                                @endphp
                                <tr id="payment-row" class="payment-row" data-status="{{ $payment->status }}"
                                    {{-- data-year-created="{{ $yearCreated }}"  --}} data-year-deadline="{{ $yearDeadline }}" {{-- data-month-created="{{ $monthCreated }}"  --}}
                                    data-month-deadline="{{ $monthDeadline }}">
                                    <td class='text-center'>{{ $fixer->name }}</td>
                                    <td class='text-center'>{{ $payment->price }} $</td>
                                    {{-- <td class='text-center'>{{ $payment->created_at }}</td> --}}
                                    {{-- <td class='text-center'>
                                        @if ($payment->created_at == $payment->updated_at)
                                            {{ '...' }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->updated_at)->format('jS, F, Y') }}
                                        @endif
                                    </td> --}}

                                    <td class='text-center'>{{ $payment->deadline }}</td>
                                    <td class='text-center'
                                        style="width:5px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 150px;">
                                        {{ $payment->description }}</td>
                                    {{-- <td class='text-center'>{{ $payment->status }}</td> --}}
                                    <td class="text-center">{{ $payment->status }}</td>
                                    <!-- Add other columns as needed -->
                                    {{-- <td class='text-center'> --}}
                                    <td class="table-actions  text-center">
                                        <a class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#paymentDetailsModal"
                                            data-payment-image="{{ $fixer->profile }}"
                                            data-payment-name="{{ $fixer->name }}"
                                            data-payment-description="{{ $payment->description }}"
                                            data-payment-email="{{ $fixer->email }}"
                                            data-payment-count="{{ $numberPayment }}"
                                            data-payment-list="<tr><td class='text-center'>{{ $fixer->name }}</td></tr>"
                                            data-payment-stars="999">
                                            Details
                                        </a>
                                        @can('Payment edit')
                                            <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endcan
                    </tbody>
                </table>

            </div>
            {{-- ---------------------- the end table ---------------------- --}}
            {{-- ------------------------------ year --------------------------- --}}
            <!-- -----------category detail------ -->
            <div class="modal fade" id="paymentDetailsModal" tabindex="-1"
                aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered h-100">
                    <div class="modal-content h-75">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="paymentDetailsModal">Payment Detail</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body overflow-scroll">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="payment-image-container">
                                            <img src="" class="img-fluid rounded" alt="payment Image"
                                                id="payment-image">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h4 class="text-warning"><i class='bx bxs-category'></i><span
                                                id="payment-name"></span></h4>
                                        <p>Count: <span id="payment-count"></span></p>
                                        <p>Email: <span id="payment-email"></span></p>
                                        <p id="payment-description"></p>
                                        <p>Call: <a class=" bg-light rounded-2 p-2 mx-1 " href="tel:0973329218"><i
                                                    class="fas fa-phone text-gray-500"></i></a> </p>
                                        {{-- <p>
                                        @if ($payment->created_at == $payment->updated_at)
                                            {{ '...' }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->updated_at)->format('jS, F, Y') }}
                                        @endif
                                    </p> --}}

                                    </div>
                                </div>
                                <table class="table table-striped table-hover mt-20 overflow-scroll">
                                    <thead class="bg-warning">

                                        <tr>
                                            <th scope="col" class='text-center'>Price</th>
                                            <th scope="col" class='text-center'>Deadline</th>
                                            <th scope="col" class='text-center'>Description</th>
                                            <th scope="col" class='text-center'>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id='payment-list'>

                                        {{-- @endcan --}}
                                        <!-- Add more rows here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{--  --}}
        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{--  --}}
        @if (session('showAlertCreate'))
            <script>
                Swal.fire({
                    title: 'Payment created Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ff9800',
                    showCloseButton: true,
                });
            </script>
        @endif
        {{--  --}}
        @if (session('showAlertEdit'))
            <script>
                Swal.fire({
                    title: 'Payment edited Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ff9800',
                    showCloseButton: true,
                });
            </script>
        @endif
        {{--  --}}
        @if (session('showAlertDelete'))
            <script>
                Swal.fire({
                    title: 'Category deleted Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ff9800',
                    showCloseButton: true,
                });
            </script>
        @endif
        {{--  --}}
        <style>
            .modal-content {
                animation: fadeIn 0.5s;
            }

            .modal-header {
                position: relative;
            }

            .modal-header .btn-close {
                position: absolute;
                right: 20px;
                top: 20px;
            }

            .modal-header .modal-title {
                font-weight: bold;
            }

            .modal-body {
                padding: 20px;
            }

            .payment-image-container {
                overflow: hidden;
                border-radius: 10px;
            }

            .payment-image-container img {
                transition: transform 0.3s ease;
            }

            .payment-image-container img:hover {
                transform: scale(1.1);
            }

            /* list month */
            #card-month {
                display: none;
                position: absolute;
                left: 30.9%;
                top: 33%;
                width: 10rem;
            }

            /* list month */

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
        {{--  --}}
        <script>
            // ----------------------------------------------

            document.getElementById('paymentDetailsModal').addEventListener('show.bs.modal', function(event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;
                // Update the modal content with the data attributes
                document.getElementById('payment-image').src = button.dataset.paymentImage;
                document.getElementById('payment-name').textContent = button.dataset.paymentName;
                document.getElementById('payment-count').textContent = button.dataset.paymentCount;
                document.getElementById('payment-email').textContent = button.dataset.paymentEmail;
                document.getElementById('payment-list').appendChild(button.dataset.paymentList);
            });

            // Handle live search
            document.getElementById('search-input').addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('#payment-table-body tr');

                rows.forEach(row => {
                    const name = row.children[0].textContent.toLowerCase();
                    const description = row.children[1].textContent.toLowerCase();

                    if (name.includes(query) || description.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            // ----------------------------------------------

            // ----------------------------------------------

            function filterPaymentsPaid() {
                var statusSelect = document.getElementById('status-select');
                var selectedStatus = statusSelect.value;

                var rows = document.querySelectorAll('#payments-table #payment-row');
                rows.forEach(function(row) {
                    var rowStatus = row.getAttribute('data-status');

                    if (selectedStatus === 'all') {
                        row.style.display = '';
                    } else if (rowStatus === selectedStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            // -----------------------   List selection year and month --------------------

            let selectedYear = 'all';
            let selectedMonth = 'all';

            function filterPayments(year, month) {
                if (year !== null) selectedYear = year;
                if (month !== null) selectedMonth = month;

                const paymentRows = document.querySelectorAll('.payment-row');

                paymentRows.forEach(row => {
                    const yearCreated = row.dataset.yearCreated;
                    const yearDeadline = row.dataset.yearDeadline;
                    const monthCreated = row.dataset.monthCreated;
                    const monthDeadline = row.dataset.monthDeadline;

                    const yearMatches = (selectedYear === 'all' || yearCreated === selectedYear || yearDeadline ===
                        selectedYear);
                    const monthMatches = (selectedMonth === 'all' || monthCreated == selectedMonth || monthDeadline ==
                        selectedMonth);

                    if (yearMatches && monthMatches) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateDropdownLabels();
            }
            // -----------------------  

            function updateDropdownLabels() {
                const yearDropdown = document.getElementById('yearDropdown');
                yearDropdown.textContent = selectedYear === 'all' ? 'Select Year' : selectedYear;
            }

            function showRelevantMonths(year) {
                const paymentRows = document.querySelectorAll('.payment-row');
                const monthSelect = document.getElementById('month-select');
                monthSelect.innerHTML = `
        <li><a class="dropdown-item" href="#" onclick="filterPayments(null, 'all')">Select All</a></li>`;

                const monthsInYear = new Set();
                paymentRows.forEach(row => {
                    if (row.dataset.yearCreated === year || row.dataset.yearDeadline === year) {
                        monthsInYear.add(row.dataset.monthCreated);
                        monthsInYear.add(row.dataset.monthDeadline);
                    }
                });
 // ----------------------- 
                monthsInYear.forEach(month => {
                    if (month && monthNames[month]) {
                        const monthName = monthNames[month];
                        monthSelect.innerHTML +=
                            `<li><a class="dropdown-item month-item" href="#" data-month="${month}">${monthName}</a></li>`;
                    }
                });
 // ----------------------- 
                document.querySelectorAll('.month-item').forEach(item => {
                    item.addEventListener('click', event => {
                        const month = event.target.dataset.month;
                        filterPayments(selectedYear, month);
                        monthsCard.style.display = 'none';
                        showData(selectedYear, month); 
                    });
                });
            }

            // -----------------------  show --------------------
            const showDataElement = document.getElementById('show-data');

            function showData(year, month) {
                const selectedMonth = selectedYear.selectedMonth; // Assuming you have this logic somewhere
                if (year == selectedYear && month == selectedMonth) {
                    showDataElement.style.display = 'block';
                    showDataElement.innerHTML = `${year} / ${month}`; // Assuming you want to display the selected year/month
                } else {
                    showDataElement.style.display = 'none';
                }
            }
 // ----------------------- 
            const yearItems = document.querySelectorAll('.year-item');
            const monthsCard = document.getElementById('card-month');
            const monthNames = @json($months);

            yearItems.forEach(item => {
                item.addEventListener('mouseover', event => {
                    selectedYear = event.target.dataset.year;
                    showRelevantMonths(selectedYear);
                    monthsCard.style.display = 'block';
                });

                item.addEventListener('mouseout', event => {
                    if (!monthsCard.contains(event.relatedTarget)) {
                        monthsCard.style.display = 'none';
                    }
                });
            });

            monthsCard.addEventListener('mouseover', () => {
                monthsCard.style.display = 'block';
            });

            monthsCard.addEventListener('mouseout', event => {
                if (!document.querySelector('.year-item:hover')) {
                    monthsCard.style.display = 'none';
                }
            });

            document.querySelector('li > a[href="#"]').addEventListener('click', () => {
                selectedYear = 'all';
                selectedMonth = 'all';
                filterPayments(selectedYear, selectedMonth);
                monthsCard.style.display = 'none';
            });



            // -----------------------   List selection year and month --------------------
        </script>


        {{-- ----------------- Link ------------------------ --}}
        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</x-app-layout>
