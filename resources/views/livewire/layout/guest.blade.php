<div class="flex h-full mr-4 py-4">
    <div class="flex flex-nowrap">
        <div class="px-2">
            <div x-data="{openLoginModal: false}">
                <button @click="openLoginModal = true" class="inline-flex justify-center items-center align-middle relative h-[3rem] overflow-hidden rounded-md bg-[#53535F]/[.38] hover:bg-[#53535F]/[48] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                    <div class="flex grow-0 items-center py-0 px-4">
                        <div class="flex grow-0 justify-start items-center">
                            Log In
                        </div>
                    </div>
                </button>
                @livewire('pages.auth.login-modal')
            </div>
        </div>
        <div class="px-2">
            <div x-data="{openSignupModal: false}">
                <button @click="openSignupModal = true" class="inline-flex justify-center items-center align-middle relative h-[3rem] overflow-hidden rounded-md bg-[#9147ff] hover:bg-[#772ce8] text-[1.3rem] font-semibold whitespace-nowrap select-none">
                    <div class="flex grow-0 items-center py-0 px-4">
                        <div class="flex grow-0 justify-start items-center">
                            Sign Up
                        </div>
                    </div>
                </button>
                @livewire('pages.auth.register-modal')
            </div>
        </div>
    </div>
</div>