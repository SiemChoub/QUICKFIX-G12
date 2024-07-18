<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-hidden lg:translate-x-0 lg:static lg:inset-0">
    <div class="h-full relative overflow-y-auto">
        <!-- Your content here -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <div class="d-flex align-items-center justify-content-center mt-4">
            <div class="d-flex align-items-center">
                <svg class="h-12 w-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                </svg>
                <a href="{{ route('admin.dashboard') }}" class="text-white fs-4 mx-2 fw-semibold text-decoration-none">
                    Dashboard
                </a>
            </div>
        </div>

        <nav class="mt-10">
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }} " href="{{ route('admin.dashboard')}}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>

                <span class="mx-3 ">Dashboard</span>
            </a>

            <div class="dropdown">
                <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="h-6 w-6 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 14v6h14v-6z" />
                    </svg>
                    <span>Bookings</span>
                    <?php
                        // Assuming $bookings is your array of bookings with 'action' column
                        $count = 0;
                        foreach ($bookings as $booking) {
                            if ($booking['action'] == 'progress' || $booking['action'] == 'request') {
                                $count++;
                            }
                        }

                        if ($count > 0) {
                    ?>
                        <span class="badge bg-warning rounded-pill ml-1 -mt-3">
                            <?php
                                if ($count > 99) {
                                    echo '99+';
                                } else {
                                    echo $count;
                                }
                            ?>
                        </span>
                    <?php
                        }
                    ?>

                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3 " aria-labelledby="messagesDropdown" style="width:240px; max-height: 500px;">
                <div class="message-info space-y-2 d-flex flex-col gap-3">
                <!-- --------------------------------- -->
                @canany('Request access','Request delete')
                <li>
                    <a href="{{ route('admin.requests.index') }}" class="flex items-center mt-2 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.requests.index') ? 'active' : '' }}">
                    <svg class="h-6 w-6 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Requests</span>
                        <?php
                            $requestCount = $bookings->filter(function($booking) {
                                return $booking->action === 'request';
                            })->count();

                            if ($requestCount > 0) {
                        ?>
                            <span class="badge bg-warning rounded-pill ml-1 -mt-3"> 
                                <?php
                                    if ($requestCount > 99) {
                                        echo '99+';
                                    } else {
                                        echo $requestCount;
                                    }
                                ?>
                            </span>
                        <?php
                            }
                        ?>
                    </a>
                </li>
                @endcanany
                    <!-- -------------------------------- -->
                <!-- --------------------------------- -->
                @canany('Progress access','Progress delete')
                <li>
                    <a href="{{ route('admin.progresss.index') }}" class="flex items-center mt-2 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.progresss.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm">In Progress</span>
                    </div>
                    <?php
                        $progressCount = $FixingProgress->filter(function($booking) {
                            return $booking->action === 'progress';
                        })->count();

                        if ($progressCount > 0) {
                    ?>
                        <span class="badge bg-warning rounded-pill ml-1 -mt-3"> 
                            <?php
                                if ($progressCount > 99) {
                                    echo '99+';
                                } else {
                                    echo $progressCount;
                                }
                            ?>
                        </span>
                    <?php
                        }
                    ?>
                    </a>
                </li>
                @endcanany
                <!-- -------------------------------- -->
                <!-- --------------------------------- -->
                @canany('Done access')
                <li>
                    <a href="{{ route('admin.dones.index') }}" class="flex items-center mt-2 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.dones.index') ? 'active' : '' }}">
                    <div class="flex items-center">
                    <svg class="h-6 w-6 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                        <span class="text-sm">Dones Fixing</span>
                    </div>
                    </a>
                </li>
                @endcanany
                    <!-- -------------------------------- -->
                </ul>
            </div>

            @canany('Role access','Role add','Role edit','Role delete')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.roles.index') ? 'active' : '' }}"
                href="{{ route('admin.roles.index') }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                    </path>
                </svg>

                <span class="mx-3">Role</span>
            </a>
            @endcanany
            @canany('Permission access','Permission add','Permission edit','Permission delete')
             <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.permissions.index') ? 'active' : '' }}"
                href="{{ route('admin.permissions.index') }}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                    </path>
                </svg>

                <span class="mx-3">Permission</span>
            </a>
            @endcanany
            
            @canany('User access','User add','User edit','User delete')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.users.index') ? 'active' : '' }}"
                href="{{ route('admin.users.index')}}">
                <span class="inline-flex justify-center items-center">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </span>

                <span class="mx-3">User</span>
            </a>
            @endcanany

            @canany('Category access','Category add','Category edit','Category delete')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.categories.index') ? 'active' : '' }}"
            href="{{ route('admin.categories.index')}}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012 2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012 2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="mx-3">Categories</span>
            </a>
            @endcanany

            @canany('Service access','Service add','Service edit','Service delete')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.services.index') ? 'active' : '' }}"
            href="{{ route('admin.services.index')}}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                </path>
            </svg>
            <span class="mx-3">Services</span>
            </a>
            @endcanany

            @canany('Discount access','Discount add','Discount edit','Discount delete')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.discounts.index') ? 'active' : '' }}"
            href="{{ route('admin.discounts.index')}}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-4-4-3 3v5h5l3-3 4 4 7-7-4-4zm-5 1h.01"></path>
            </svg>
            <span class="mx-3">Discount</span>
            </a>
            @endcanany
            {{-- ====================== --}}
            @canany('Payment access', 'Payment create', 'Payment edit')
            <a class="flex items-center mt-4 py-2 px-6 text-gray-500 fw-semibold text-decoration-none hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.payments.index') ? 'active' : '' }}"
            href="{{ route('admin.payments.index')}}">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2zm0 4h18m-9 4h4"></path>
            </svg>
            <span class="mx-3">Payment</span>
            
            </a>
            @endcanany
            {{-- ====================== --}}
     
            @canany('Mail access','Mail edit')
             <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 fw-semibold text-decoration-none hover:bg-opacity-25 hover:text-gray-100 {{ Route::currentRouteNamed('admin.mail.index') ? 'active' : '' }}"
                href="{{ route('admin.mail.index')}}">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                <span class="mx-3">Setting</span>
            </a>
            @endcanany
            
        </nav>
    </div>
</div>
