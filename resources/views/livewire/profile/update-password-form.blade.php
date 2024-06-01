<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <form wire:submit="updatePassword" class="form__settings" x-data="{ isChangeable: @json(Auth::user()->twitch_id === null) }">
        <div class="w-full">
            <div class="w-full p-8">
                <div class="flex flex-nowrap grow relative text-[1.3rem]">
                    <div class="shrink-0 w-[18rem] pr-8">
                        <div class="mb-2">
                            <label for="update_password_current_password" class="text-[#f7f7f8] font-bold">
                                {{ __('Current Password') }}
                            </label>
                        </div>
                    </div>
                    <div class="grow">
                        <input type="password" wire:model="current_password" id="update_password_current_password" name="current_password" autocomplete="current-password" :disabled="!isChangeable" />
                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                    </div>
                </div>
            </div>
            <div class="w-full p-8 border-t border-[#53535f]/[0.48]">
                <div class="flex flex-nowrap grow relative text-[1.3rem]">
                    <div class="shrink-0 w-[18rem] pr-8">
                        <div class="mb-2">
                            <label for="update_password_password" class="text-[#f7f7f8] font-bold">
                                {{ __('New Password') }}
                            </label>
                        </div>
                    </div>
                    <div class="grow">
                        <input type="password" wire:model="password" id="update_password_password" name="password" autocomplete="new-password" :disabled="!isChangeable" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>
                </div>
            </div>
            <div class="w-full p-8 border-t border-[#53535f]/[0.48]">
                <div class="flex flex-nowrap grow relative text-[1.3rem]">
                    <div class="shrink-0 w-[18rem] pr-8">
                        <div class="mb-2">
                            <label for="update_password_password_confirmation" class="text-[#f7f7f8] font-bold">
                                {{ __('Confirm Password') }}
                            </label>
                        </div>
                    </div>
                    <div class="grow">
                        <input type="password" wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password" :disabled="!isChangeable" />
                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 bg-[#26262c]">
            <div class="flex justify-end">
                <x-action-message class="flex items-end me-4 !text-[#efeff1] !text-[1.3rem] !leading-[1.5]" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
                <button type="submit"
                    class="inline-flex justify-center items-center relative align-middle h-[3rem] rounded-[0.4rem] text-[1.3rem] font-semibold overflow-hidden whitespace-nowrap select-none bg-[#9147ff] hover:bg-[#772ce8]"
                    :disabled="!isChangeable"
                    :class="!isChangeable ? '!cursor-not-allowed !bg-[#53535f]/[.48] !text-[#adadb8]' : ''" 
                    >
                    <div class="flex grow-0 items-center py-0 px-4 ">
                        <div class="flex grow-0 justify-center items-center">
                            Save
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </form>
</section>
