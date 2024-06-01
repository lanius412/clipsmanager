<div x-show="openSignupModal" x-cloak class="flex justify-center items-start fixed top-0 left-0 right-0 bottom-0 z-[5000] overflow-auto bg-black/85">
    <div x-on:click.away = "openSignupModal = false" class="flex grow-0 justify-center w-full h-full outline-none pointer-events-none [&>*]:relative">
        <div class="p-4 flex justify-center items-start w-full h-full">
            <div class="flex grow-0 justify-center relative w-full my-auto outline-none [&>*]:pointer-events-auto">
                <div class="relative max-w-full">
                    <div class="flex overflow-hidden rounded-[0.4rem]">
                        <div class="w-[50rem] overflow-auto">
                            <div class="flex flex-col p-12 bg-[#18181b] ">
                                <div>
                                    <div class="flex flex-col mt-2">
                                        <div class="inline-flex justify-center items-center">
                                            <div class="inline-flex items-center w-[50px] h-[50px] rounded">
                                                <img class="rounded-2xl" src="{{ asset('/storage/images/clipsmanager.ico') }}" alt="ClipsManager">
                                            </div>
                                            <div class="ml-4 text-center">
                                                <h2 class="text-[2rem] lg:text-[2.4rem] leading-[1.2] font-semibold">
                                                    Sign up to ClipsManager
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col w-full mb-4">
                                    <div class="mt-8">
                                        <a class="inline-flex justify-center items-center gap-x-2 w-full py-2 px-4 text-xl font-bold rounded-md bg-[#9147ff] hover:bg-[#772ce8] hover:!text-current disabled:opacity-50 disabled:pointer-events-none select-none" href="{{ route('twitch.login') }}">
                                            <img width="20" height="20" src="{{ asset('/storage/images/TwitchGlitchWhite.svg') }}" alt="Twitch Icon">
                                            Connect with Twitch
                                        </a>
                                        <div class="py-3 flex items-center text-xl text-gray-400 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 select-none">or</div>
                                    </div>
                                    <form class="form__auth" action="{{ route('register') }}" method="POST" x-data="{ registerFields: { name: '', email: '', password: '', confirmPassword: '' } }">
                                        @csrf
                                        <div class="flex flex-col w-full">
                                            <div>
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow">
                                                            <label for="signup-name" class="text-[#f7f7f8] font-bold">
                                                                Username
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="text"
                                                                id="signup-name"
                                                                name="name"
                                                                value
                                                                x-model="registerFields.name"
                                                                aria-label="Enter your username"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow">
                                                            <label for="signup-email" class="text-[#f7f7f8] font-bold">
                                                                Email
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="email"
                                                                id="signup-email"
                                                                name="email"
                                                                value
                                                                x-model="registerFields.email"
                                                                class="@if ($errors->has('register-email')) input-error @endif"
                                                                aria-label="Enter your email"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off" />
                                                            <x-input-error :messages="$errors->get('register-email')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow flex">
                                                            <label for="signup-password" class="text-[#f7f7f8] font-bold">
                                                                Password
                                                            </label>
                                                            <div class="ml-2">
                                                                <figure class="inline-flex items-center" data-tooltip-target="auth-password__hint" data-tooltip-placement="right">
                                                                    <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </figure>
                                                                <div id="auth-password__hint" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] text-wrap tooltip" role="tooltip">
                                                                    {{ __('At least 8 characters') }}
                                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                                </div>                                                                          
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="password"
                                                                id="signup-password"
                                                                name="password"
                                                                value
                                                                x-model="registerFields.password"
                                                                class="@if ($errors->has('password')) input-error @endif"
                                                                aria-label="Enter your password"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off"
                                                                spellcheck="false" />
                                                            <span x-show="registerFields.password.length < 8 && registerFields.password.length > 0">The password is too short</span>
                                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow">
                                                            <label for="signup-password_confirmation" class="text-[#f7f7f8] font-bold">
                                                                Confirm Password
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="password"
                                                                id="signup-password_confirmation"
                                                                name="password_confirmation"
                                                                value
                                                                x-model="registerFields.confirmPassword"
                                                                class="@if ($errors->has('password_confirmation') || $errors->has('register-password')) input-error @endif"
                                                                aria-label="Confirm your password"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off"
                                                                spellcheck="false" />
                                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                            <x-input-error :messages="$errors->get('register-password')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div>
                                                    <button type="submit"
                                                        :disabled="!registerFields.name || !registerFields.email || !registerFields.password || registerFields.password.length < 8 || !registerFields.confirmPassword || registerFields.confirmPassword.length < 8"
                                                        :class="(!registerFields.name || !registerFields.email || !registerFields.password || registerFields.password.length < 8 || !registerFields.confirmPassword || registerFields.confirmPassword.length < 8) ? '!bg-[#232328] !text-[#adadb8] cursor-not-allowed' : ''"
                                                        class="inline-flex justify-center items-center relative w-full h-12 align-middle rounded-[0.4rem] overflow-hidden bg-[#3fcd8e] hover:bg-[#34d399] text-[#18181b] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                                                        <div class="flex grow items-center py-0 px-4">
                                                            <div class="flex grow justify-center items-center">
                                                                Sign Up
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-4 left-auto right-4 absolute ml-2">
                        <button @click="openSignupModal = false" class="inline-flex justify-center items-center relative align-middle w-12 h-12 rounded-[0.4rem] overflow-hidden font-semibold text-[1.3rem] whitespace-nowrap select-none hover:bg-[#53535f]/[48]">
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