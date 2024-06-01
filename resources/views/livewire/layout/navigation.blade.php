<nav class="block flex-shrink-0 z-[1000]" style="height: 5rem;">
    <div class="flex flex-nowrap items-stretch h-full shadow-sm bg-[#18181b]">
        <div class="flex flex-grow flex-nowrap justify-start items-stretch w-full">
            <a aria-label="Explore Clips" href="{{ route('home') }}" wire:navigate>
                <div class="inline-flex items-center p-2">
                    <div class="w-[40px] h-[40px]">
                        <img class="rounded-2xl select-none" width="40px" height="40px" src="{{ asset('storage/images/clipsmanager.ico') }}" alt="ClipsManager">
                    </div>
                </div>
            </a>
            <div>
                <div class="flex flex-row justify-between h-full">
                    <div class="flex flex-col h-full px-2 lg:px-4">
                        <div class="flex self-center h-full">
                            <a aria-label="Explore Clips" class="flex items-center text-center whitespace-nowrap {{ Request::routeIs('home') || Request::routeIs('explore') ? 'text-[#bf94ff]' : ''}}" href="{{ route('home') }}">
                                <div>
                                    <div class="hidden md:flex">
                                        <div class="hidden lg:block">
                                            <p class="font-semibold text-[1.8rem] leading-[1.2]">Explore</p>
                                        </div>
                                        <div class="lg:hidden">
                                            <p class="font-semibold text-[1.4rem] leading-[1.2]">Explore</p>
                                        </div>
                                    </div>
                                    <div aria-label="Explore Clips" class="flex md:hidden px-4">
                                        <div class="inline-flex relative">
                                            <figure class="inline-flex items-center" data-tooltip-target="nav-explore__hint" data-tooltip-placement="bottom">
                                                <svg class="w-[20px] h-[20px] aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                                </svg>                                                  
                                            </figure>
                                            <div id="nav-explore__hint" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] text-wrap tooltip" role="tooltip">
                                                {{ __('Explore Clips') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="h-[0.2rem]">
                            <div class="mb-[-0.1rem] h-[0.2rem] origin-top-left {{ Request::routeIs('home') ? 'bg-[#bf94ff]' : '' }}"></div>
                        </div>
                    </div>
                    <div class="flex flex-col h-full px-2 lg:px-4">
                        <div class="flex self-center h-full">
                            <a aria-label="Trend Games Clips" class="flex items-center text-center whitespace-nowrap {{ Request::routeIs('trend') ? 'text-[#bf94ff]' : ''}}" href="{{ route('trend') }}" wire:navigate>
                                <div>
                                    <div class="hidden md:flex">
                                        <div class="hidden lg:block">
                                            <p class="font-semibold text-[1.8rem] leading-[1.2]">Trend</p>
                                        </div>
                                        <div class="lg:hidden">
                                            <p class="font-semibold text-[1.4rem] leading-[1.2]">Trend</p>
                                        </div>
                                    </div>
                                    <div aria-label="Trend Games Clips" class="flex md:hidden px-4">
                                        <div class="inline-flex relative">
                                            <figure class="inline-flex items-center" data-tooltip-target="nav-trend__hint" data-tooltip-placement="bottom">
                                                <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                                                </svg> 
                                            </figure>
                                            <div id="nav-trend__hint" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] text-wrap tooltip" role="tooltip">
                                                {{ __('Trend Games Clips') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="h-[0.2rem]">
                            <div class="mb-[-0.1rem] h-[0.2rem] {{ Request::routeIs('trend') ? 'bg-[#bf94ff]' : '' }}"></div>
                        </div>
                    </div>
                    <div class="flex flex-col h-full px-2 lg:px-4">
                        <div class="flex self-center h-full">
                            <a aria-label="Favorite Clips"
                                class="flex items-center text-center whitespace-nowrap cursor-pointer {{ Request::routeIs('favorite') ? 'text-[#bf94ff]' : ''}}"
                                @auth
                                    href="{{ route('favorite') }}" wire:navigate
                                @else
                                    onclick="document.querySelector('#login-modal').style='';"
                                @endauth
                                >
                                <div>
                                    <div class="hidden md:flex">
                                        <div class="hidden lg:block">
                                            <p class="text-[1.8rem] leading-[1.2] font-semibold">Favorite</p>
                                        </div>
                                        <div class="lg:hidden">
                                            <p class="text-[1.4rem] leading-[1.2] font-semibold">Favorite</p>
                                        </div>
                                    </div>
                                    <div aria-label="Favorite Clips" class="flex md:hidden px-4">
                                        <div class="inline-flex relative">
                                            <figure class="inline-flex items-center" data-tooltip-target="nav-favorite__hint" data-tooltip-placement="bottom">
                                                <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/>
                                                </svg>
                                            </figure>
                                            <div id="nav-favorite__hint" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] text-wrap tooltip" role="tooltip">
                                                {{ __('Favorite Clips') }}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="h-[0.2rem]">
                            <div class="mb-[-0.1rem] h-[0.2rem] origin-top-left {{ Request::routeIs('favorite') ? 'bg-[#bf94ff]' : '' }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-grow justify-end items-center w-full">
            @auth
                @livewire('layout.app')
            @else
                @livewire('layout.guest')
            @endauth
        </div>
    </div>
</nav>
