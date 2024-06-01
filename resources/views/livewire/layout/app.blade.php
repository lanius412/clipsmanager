<?php
use App\Models\TwitchAccount;

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex h-full mr-4 py-4">
    <div class="flex flex-nowrap">
        <x-dropdown align="right">
            <x-slot name="trigger">
                <button class="inline-flex items-center border border-transparent text-md leading-4 font-medium transition ease-in-out duration-150">
                    @isset (Auth::user()->twitch_id)
                        <div class="w-[30px] h-[30px] rounded-full flex justify-center items-center">
                            <img src="{{ TwitchAccount::where('login_id', Auth::user()->twitch_id)->first()->avatar }}" class="rounded-full" alt="twitch-user-avatar">
                        </div>
                    @else
                        <div class="w-[30px] h-[30px] rounded-full flex justify-center items-center bg-green-500">
                            <p>{{ mb_substr(Auth::user()->name, 0, 1) }}</p>
                        </div>
                    @endisset
                </button>
            </x-slot>

            <x-slot name="content">
                <div>
                    <div class="flex p-2">
                        <div class="flex grow-0 flex-col">
                            <div class="grow-0">
                                <a href="{{ route('settings') }}" class="hover:text-current">
                                    <div class="relative w-16 h-16 max-h-full bg-inherit">
                                        @isset (Auth::user()->twitch_id)
                                            <div class="w-[40px] h-[40px] rounded-full flex justify-center items-center">
                                                <img src="{{ TwitchAccount::where('login_id', Auth::user()->twitch_id)->first()->avatar }}" class="rounded-full" alt="Twitch User Avatar">
                                            </div>
                                        @else
                                            <div class="w-[40px] h-[40px] rounded-full flex justify-center items-center bg-green-500">
                                                <p>{{ mb_substr(Auth::user()->name, 0, 1) }}</p>
                                            </div>
                                        @endisset
                                    </div>
                                </a>
                            </div>
                            <div class="grow"></div>
                        </div>
                        <div class="flex grow flex-col justify-center pl-4">
                            <h6 class="font-semibold select-none">{{ auth()->user()->name }}</h6>
                        </div>
                    </div>     
                </div>
                <div class="overflow-auto">
                    <div role="separator" class="my-4 mx-2 border-t border-[#53535f]/[.48]"></div>
                </div>
                <div class="relative w-full">
                    <a class="block w-full rounded-[.4rem] hover:bg-[#53535f]/[.48] select-none hover:text-inherit" href="{{ route('settings') }}" wire:navigate>
                        <div class="flex items-center relative p-2">
                            <div class="flex shrink-0 items-center pr-2">
                                <div class="flex items-center">
                                    <div class="inline-flex items-center w-8 h-8 fill-current">
                                        <svg width="20" height="20" viewBox="0 0 20 20"><path d="M10 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"></path><path fill-rule="evenodd" d="M9 2h2a2.01 2.01 0 0 0 1.235 1.855l.53.22a2.01 2.01 0 0 0 2.185-.439l1.414 1.414a2.01 2.01 0 0 0-.439 2.185l.22.53A2.01 2.01 0 0 0 18 9v2a2.01 2.01 0 0 0-1.855 1.235l-.22.53a2.01 2.01 0 0 0 .44 2.185l-1.415 1.414a2.01 2.01 0 0 0-2.184-.439l-.531.22A2.01 2.01 0 0 0 11 18H9a2.01 2.01 0 0 0-1.235-1.854l-.53-.22a2.009 2.009 0 0 0-2.185.438L3.636 14.95a2.009 2.009 0 0 0 .438-2.184l-.22-.531A2.01 2.01 0 0 0 2 11V9c.809 0 1.545-.487 1.854-1.235l.22-.53a2.009 2.009 0 0 0-.438-2.185L5.05 3.636a2.01 2.01 0 0 0 2.185.438l.53-.22A2.01 2.01 0 0 0 9 2zm-4 8 1.464 3.536L10 15l3.535-1.464L15 10l-1.465-3.536L10 5 6.464 6.464 5 10z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="grow">
                                {{ __('Settings') }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="relative w-full">
                    <button class="block w-full rounded-[.4rem] hover:bg-[#53535f]/[.48] hover:text-inherit" wire:click="logout">
                        <div class="flex items-center relative p-2">
                            <div class="flex shrink-0 items-center pr-2">
                                <div class="flex items-center">
                                    <div class="inline-flex items-center w-8 h-8 fill-current">
                                        <svg width="20" height="20" version="1.1" viewBox="0 0 20 20" x="0px" y="0px" class="ScIconSVG-sc-1q25cff-1 jpczqG"><g><path d="M16 18h-4a2 2 0 01-2-2v-2h2v2h4V4h-4v2h-2V4a2 2 0 012-2h4a2 2 0 012 2v12a2 2 0 01-2 2z"></path><path d="M7 5l1.5 1.5L6 9h8v2H6l2.5 2.5L7 15l-5-5 5-5z"></path></g></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="grow text-start">
                                {{ __('Log Out') }}
                            </div>
                        </div>
                    </button>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</div>