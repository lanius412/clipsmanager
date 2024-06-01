<?php

use App\Models\Favorite;
use App\Models\TwitchAccount;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $user = Auth::user();
        $twitchUser = TwitchAccount::find($user->twitch_id ?? '');
        if (is_null($twitchUser)) {
            $this->validate([
                'password' => ['required', 'string', 'current_password'],
            ]);
        } else {
            $twitchUser->delete();
        }

        Favorite::where('user_id', $user->id)->first()->delete();
        tap($user, $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <div x-data="{openDeleteAccountModal: false}">
        <button @click="openDeleteAccountModal = true" class="inline-flex justify-center items-center align-middle relative h-[3rem] overflow-hidden rounded-md bg-[#dc2626] hover:bg-[#ef4444] text-[1.3rem] font-semibold whitespace-nowrap select-none">
            <div class="flex grow-0 items-center py-0 px-4">
                <div class="flex grow-0 justify-start items-center">
                    Delete Account
                </div>
            </div>
        </button>
        <div x-show="openDeleteAccountModal" x-cloak class="flex justify-center items-start fixed top-0 left-0 right-0 bottom-0 z-[5000] overflow-auto bg-black/85">
            <div x-on:click.away = "openDeleteAccountModal = false" class="flex grow-0 justify-center w-full h-full outline-none pointer-events-none [&>*]:relative">
                <div class="p-4 flex justify-center items-start w-full h-full">
                    <div class="flex grow-0 justify-center relative w-full my-auto outline-none [&>*]:pointer-events-auto">
                        <div class="relative max-w-full">
                            <div class="flex overflow-hidden rounded-[0.4rem]">
                                <div class="w-[50rem] overflow-auto">
                                    <div class="flex flex-col p-12 bg-[#18181b]">
                                        @if (is_null(Auth::user()->twitch_id))
                                            <div>
                                                <div class="flex flex-col mt-2">
                                                    <div class="inline-flex justify-center items-center">
                                                        <div class="inline-flex items-center w-[50px] h-[50px] rounded">
                                                            <img class="rounded-2xl" src="{{ asset('/storage/images/clipsmanager.ico') }}" alt="ClipsManager">
                                                        </div>
                                                        <div class="ml-4 text-center">
                                                            <h2 class="text-[2rem] lg:text-[2.4rem] leading-[1.2] font-semibold">
                                                                Confirm your password
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col w-full mb-4">
                                                <form wire:submit="deleteUser" class="form__settings" x-data="{ deleteUserFields: { password: '' } }">
                                                    <div class="flex flex-col w-full">
                                                        <div class="mt-4">
                                                            <p>
                                                                For security, please enter your password to continue.
                                                            </p>
                                                        </div>
                                                        <div class="mt-8">
                                                            <div>
                                                                <div class="flex items-center mb-2">
                                                                    <div class="grow">
                                                                        <label for="password" class="text-[#f7f7f8] font-bold">
                                                                            Password
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="relative">
                                                                        <input
                                                                            type="password"
                                                                            wire:model="password"
                                                                            id="password"
                                                                            name="password"
                                                                            x-model="deleteUserFields.password"
                                                                            placeholder="{{ __('Password') }}"
                                                                        />
                                                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-8">
                                                            <div>
                                                                <button type="submit"
                                                                    :disabled="!deleteUserFields.password || deleteUserFields.password.length < 8"
                                                                    :class="(!deleteUserFields.password || deleteUserFields.password.length < 8) ? '!bg-[#232328] !text-[#adadb8] cursor-not-allowed' : ''"
                                                                    class="inline-flex justify-center items-center relative w-full h-12 align-middle rounded-[0.4rem] overflow-hidden bg-[#9147ff] hover:bg-[#772ce8] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                                                                    <div class="flex grow items-center py-0 px-4">
                                                                        <div class="flex grow justify-center items-center">
                                                                            Verify
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div>
                                                <div class="px-8">
                                                    <p class="text-[1.8rem] ">
                                                        Are you sure you want to disconnect Twitch
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex flex-row justify-center pt-4">
                                                <div class="pr-2">
                                                    <button type="button" @click="openDeleteAccountModal = false" class="inline-flex justify-center items-center align-middle relative h-[3rem] overflow-hidden rounded-md bg-transparent hover:bg-[#53535f]/[0.48] text-[#bf94ff] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                                                        <div class="flex grow-0 items-center py-0 px-4">
                                                            <div class="flex grow-0 justify-start items-center">
                                                                Cancel
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div class="pl-2">
                                                    <form wire:submit="deleteUser">
                                                    <button type="submit" class="inline-flex justify-center items-center align-middle relative h-[3rem] overflow-hidden rounded-md bg-[#ff4f4d] hover:bg-[#ffaaa8] text-black text-[1.3rem] font-semibold whitespace-nowrap select-none">
                                                        <div class="flex grow-0 items-center py-0 px-4">
                                                            <div class="flex grow-0 justify-start items-center">
                                                                Yes, Disconnect
                                                            </div>
                                                        </div>
                                                    </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="top-4 left-auto right-4 absolute ml-2">
                                <button @click="openDeleteAccountModal = false" class="inline-flex justify-center items-center relative align-middle w-12 h-12 rounded-[0.4rem] overflow-hidden font-semibold text-[1.3rem] whitespace-nowrap select-none hover:bg-[#53535f]/[48]">
                                    <div class="w-8 h-8 pointer-events-none">
                                        <div class="inline-flex items-center w-full h-full fill-current">
                                            <svg width="20" height="20" viewBox="0 0 20 20" focusable="false" aria-hidden="true" role="presentation">
                                                <path d="M8.5 10 4 5.5 5.5 4 10 8.5 14.5 4 16 5.5 11.5 10l4.5 4.5-1.5 1.5-4.5-4.5L5.5 16 4 14.5 8.5 10z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
