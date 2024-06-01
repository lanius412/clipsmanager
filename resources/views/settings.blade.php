@extends('layouts.app')

@section('title', 'Settings | ' . config('app.name'))

@section('header', 'Settings')

@section('contents')

    <div class="max-w-[900px]">
        <div class="py-4">
            <div class="mb-8">
                <h3 class="text-[#dedee3] text-[1.8rem] font-semibold">Profile Settings</h3>
                <div class="mt-4">
                    <p class="text-[#adadb8]">
                        {{ __("Change identifying details for your account") }}
                    </p>
                </div>
            </div>
            <div class="mb-16 border border-[#53535f]/[0.48] rounded-[0.4rem] bg-[#18181b]">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="mb-8">
                <h3 class="text-[#dedee3] text-[1.8rem] font-semibold">Update Password</h3>
                <div class="mt-4">
                    <p class="text-[#adadb8]">
                        {{ __('Ensure your account is using a long, random password to stay secure') }}
                    </p>
                </div>
            </div>
            <div class="mb-16 border border-[#53535f]/[0.48] rounded-[0.4rem] bg-[#18181b]">
                <livewire:profile.update-password-form />
            </div>

            <div class="mb-8">
                <h3 class="text-[#dedee3] text-[1.8rem] font-semibold">Delete Account</h3>
                <div class="mt-4">
                    <p class="text-[#adadb8]">
                        {{ __('Completely deactivate your account') }}
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <livewire:profile.delete-user-form />
            </div>

        </div>
    </div>

@endsection