<?php

    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Validation\Rule;
    use Livewire\Volt\Component;

    new class extends Component
    {
        public string $name = '';
        public string $email = '';

        /**
         * Mount the component.
         */
        public function mount(): void
        {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        /**
         * Update the profile information for the currently authenticated user.
         */
        public function updateProfileInformation(): void
        {
            $user = Auth::user();
            if (!is_null($user->twitch_id)) return;
            if ($user->name === $this->name && $user->email === $this->email) return;

            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            ]);

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            $this->dispatch('profile-updated', name: $user->name);
        }

        /**
         * Send an email verification notification to the current user.
         */
        public function sendVerification(): void
        {
            $user = Auth::user();

            if ($user->hasVerifiedEmail()) {
                $this->redirectIntended(default: route('favorite', absolute: false));

                return;
            }

            $user->sendEmailVerificationNotification();

            Session::flash('status', 'verification-link-sent');
        }
    }; 
?>

<section>

    <form wire:submit="updateProfileInformation" class="form__settings" x-data="{ isChangeable: @json(Auth::user()->twitch_id === null) }">
        <div class="w-full">
            <div class="w-full p-8">
                <div class="flex flex-nowrap grow relative text-[1.3rem]">
                    <div class="shrink-0 w-[18rem] pr-8">
                        <div class="mb-2">
                            <label for="name" class="text-[#f7f7f8] font-bold">
                                {{ __('Name') }}
                            </label>
                        </div>
                    </div>
                    <div class="grow">
                        <input type="text" wire:model="name" id="name" name="name" autocomplete="name" required :disabled="!isChangeable" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>
            </div>
            <div class="w-full p-8 border-t border-[#53535f]/[0.48]">
                <div class="flex flex-nowrap grow relative text-[1.3rem]">
                    <div class="shrink-0 w-[18rem] pr-8">
                        <div class="mb-2">
                            <label for="email" class="text-[#f7f7f8] font-bold">
                                {{ __('Email') }}
                            </label>
                        </div>
                    </div>
                    <div class="grow">
                        <input type="email" wire:model="email" id="email" name="email" autocomplete="username" required :disabled="!isChangeable" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        {{-- @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}
            
                                    <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
            
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="p-8 bg-[#26262c]">
            <div class="flex justify-end">
                <x-action-message class="flex items-end me-4 !text-[#efeff1] !text-[1.3rem] !leading-[1.5]" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
                <button type="submit"
                    class="inline-flex justify-center items-center relative align-middle h-[3rem] rounded-[0.4rem] text-[1.3rem] font-semibold overflow-hidden whitespace-nowrap select-none bg-[#9147ff] hover:bg-[#772ce8]"
                    :disabled="!isChangeable"
                    :class="!isChangeable ? '!cursor-not-allowed !bg-[#53535f]/[.48] !text-[#adadb8]' : ''" 
                    >
                    <div class="flex grow-0 items-center py-0 px-4">
                        <div class="flex grow-0 justify-center items-center">
                            Save
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </form>
</section>
