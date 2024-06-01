<div x-show="openLoginModal" x-cloak id="login-modal" class="flex justify-center items-start fixed top-0 left-0 right-0 bottom-0 z-[5000] overflow-auto bg-black/85">
    <div x-on:click.away = "openLoginModal = false" class="flex grow-0 justify-center w-full h-full outline-none pointer-events-none [&>*]:relative">
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
                                                    Log in to ClipsManager
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
                                    <form class="form__auth" action="{{ route('login') }}" method="POST" x-data="{ loginFields: { email: '', password: '' } }">
                                        @csrf

                                        <div class="flex flex-col w-full">
                                            <div>
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow">
                                                            <label for="login-email" class="text-[#f7f7f8] font-bold">
                                                                Email
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="email"
                                                                id="login-email"
                                                                name="email"
                                                                value="{{ old('email') }}"
                                                                x-model="loginFields.email"
                                                                class="@if ($errors->has('login-email')) input-error @endif"
                                                                aria-label="Enter your email"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off" />
                                                            <x-input-error :messages="$errors->get('login-email')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div>
                                                    <div class="flex items-center mb-2">
                                                        <div class="grow">
                                                            <label for="login-password" class="text-[#f7f7f8] font-bold">
                                                                Password
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="relative">
                                                            <input type="password"
                                                                id="login-password"
                                                                name="password"
                                                                value
                                                                x-model="loginFields.password"
                                                                class="@if ($errors->has('login-password')) input-error @endif"
                                                                aria-label="Enter your password"
                                                                autocapitalize="off"
                                                                autocorrect="off"
                                                                autocomplete="off"
                                                                spellcheck="false" />
                                                            <x-input-error :messages="$errors->get('login-password')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="mt-4">
                                                <a href="{{ route('password.request') }}" class="text-[#bf94ff] hover:underline">
                                                    <p class="text-[1.2rem]">Forgot password?</p>
                                                </a>
                                            </div> --}}
                                            <div class="mt-8">
                                                <div>
                                                    <button type="submit"
                                                        :disabled="!loginFields.email || !loginFields.password || loginFields.password.length < 8"
                                                        :class="(!loginFields.email || !loginFields.password || loginFields.password.length < 8) ? '!bg-[#232328] !text-[#adadb8] cursor-not-allowed' : ''"
                                                        class="inline-flex justify-center items-center relative w-full h-12 align-middle rounded-[0.4rem] overflow-hidden bg-[#3fcd8e] hover:bg-[#34d399] text-[#18181b] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                                                        <div class="flex grow items-center py-0 px-4">
                                                            <div class="flex grow justify-center items-center">
                                                                Log In
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
                        <button @click="openLoginModal = false" onclick="document.querySelector('#login-modal').style.display='none';" class="inline-flex justify-center items-center relative align-middle w-12 h-12 rounded-[0.4rem] overflow-hidden font-semibold text-[1.3rem] whitespace-nowrap select-none hover:bg-[#53535f]/[48]">
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