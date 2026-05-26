<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>QUICK FIX @yield('title')</title>


        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Icons + Bootstrap (loaded once here for every admin page; do not re-include per page) -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        {{-- Brand (amber) focus for every form field — overrides the framework's blue focus ring --}}
        <style>
            input[type=text]:focus, input[type=email]:focus, input[type=password]:focus,
            input[type=number]:focus, input[type=search]:focus, input[type=tel]:focus,
            input[type=url]:focus, input[type=date]:focus, input[type=datetime-local]:focus,
            input[type=time]:focus, input[type=month]:focus, input[type=week]:focus,
            input:not([type]):focus, textarea:focus, select:focus,
            .form-control:focus, .form-select:focus {
                border-color: #f59e0b !important;
                box-shadow: 0 0 0 3px rgba(245, 158, 11, .18) !important;
                outline: none !important;
            }
            input[type=checkbox]:focus, input[type=radio]:focus, .form-check-input:focus {
                border-color: #f59e0b !important;
                box-shadow: 0 0 0 3px rgba(245, 158, 11, .25) !important;
                outline: none !important;
            }
            /* Placed last so it wins at equal specificity: borderless search pills show focus on the wrapper */
            .qlist-search input:focus, .qperm-search input:focus, .qdisc-search input:focus {
                box-shadow: none !important;
                border: 0 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
        
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col overflow-scroll">

                    @include('layouts.header')

                    @if(\Session::has('success'))
                        <div class="text-green-600 pt-5 pl-5">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    
                    @if(\Session::has('error'))
                        <div class="text-green-600 pt-5 pl-5">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="text-red-600  pt-5 pl-5">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                    
            </div>
        </div>
    </body>
</html>
