<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="icon" href="{{ asset('/storage/images/clipsmanager.ico') }}">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('/storage/css/scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('/storage/css/simplebar/simplebar.min.css') }}">
        @stack('css')
    </head>
    <body style="font-family: Inter">
        <div id="root">
            <div class="flex flex-col flex-nowrap absolute inset-0 overflow-hidden">
                <div class="flex flex-col flex-nowrap h-full">
                    <livewire:layout.navigation />

                    <div class="flex flex-nowrap relative h-full overflow-hidden">
                        <main class="flex flex-grow flex-col relative w-full h-full overflow-hidden">
                            <div class="scrollable-area" data-simplebar data-simplebar-auto-hide="true">
                                <div class="relative w-full">
                                    <div class="mx-12 mt-6">
                                        <div class="mx-auto my-0">
                                            <section>
                                                <header class="mb-8">
                                                    <div class="text-[5.4rem] leading-[1.2] font-bold">
                                                       @yield('header') 
                                                    </div>
                                                </header>
                                                <div class="relative">
                                                    @yield('contents')
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>                
            </div>
        </div>
        
        @stack('scripts')
        <script src="{{ asset('/storage/js/flowbite/flowbite.min.js') }}"></script>
        <script src="{{ asset('/storage/js/simplebar/simplebar.min.js') }}"></script>
        {{-- <livewire:toasts /> --}}
    </body>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
    <script>
        const observer = lozad();
        observer.observe();
    </script>
</html>
