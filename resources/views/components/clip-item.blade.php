<?php 
use App\Models\Favorite;
?>

@props([
    'lazyLoad' => false,
    'id',
    'channelId',
    'broadcasterName',
    'avatar',
    'title',
    'gameId',
    'url',
    'thumbnailUrl',
    'viewCount',
    'createdAt',
])

@once
    @push('css')
        <link rel="stylesheet" href="{{ asset('/storage/css/transform-image.css') }}">
    @endpush
@endonce
@once
    @push('scripts')
        <script>
            const copyClipUrl = (e) => {
                if (!navigator.clipboard) {
                    alert('Your browser is not supported!');
                    return;
                }
                const copyBtn = e.currentTarget;
                copyBtn.disabled = true;
                copyBtn.classList.add('cursor-not-allowed')
                copyBtn.classList.remove('hover:bg-[#2f2f35]');
                const before = copyBtn.children[0];
                const after = copyBtn.children[1];
                before.classList.add('hidden');
                after.classList.remove('hidden');
                navigator.clipboard.writeText(copyBtn.value).then(
                    () => {},
                    () => {
                        alert('Failed to copy URL');
                    }
                );
                setTimeout(() => {
                    before.classList.remove('hidden');
                    after.classList.add('hidden');
                    copyBtn.classList.add('hover:bg-[#2f2f35]');
                    copyBtn.classList.remove('cursor-not-allowed');
                    copyBtn.disabled = false;
                }, 2000);
            }
        </script>
    @endpush
@endonce
<div class="flex flex-col h-full w-full">
    <div class="transform-image">
        <div class="transform-image__corner-top"></div>
        <div class="transform-image__corner-bottom"></div>
        <div class="transform-image__edge-left"></div>
        <div class="transform-image__edge-bottom"></div>
        <div class="transform-image-item">
            <a href="{{ $url }}" target="_blank">
                <div>
                    <div class="flex justify-center items-center w-full h-full">
                        @if ($lazyLoad)
                            <img class="lozad border-none" src="" data-src="{{ $thumbnailUrl }}" alt="{{ $title }}" />
                        @else
                            <img class="border-none" src="{{ $thumbnailUrl }}" alt="{{ $title }}" />
                        @endif
                    </div>
                    <div class="bottom-0 left-0 absolute m-1 md:m-2">
                        <div class="flex justify-center items-center px-1 py-1 rounded bg-black/60 text-xl select-none">
                            <p class="text-[#efeff1]">
                                {{ $viewCount }} viewers
                            </p>
                        </div>
                    </div>
                    <div class="bottom-0 right-0 absolute m-1 md:m-2">
                        <div class="flex justify-center items-center px-1 py-1 rounded bg-black/60 text-xl select-none">
                            <p class="text-[#efeff1]">
                                {{ $createdAt }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="flex justify-stretch items-center mt-1">
        <div class="p-1">
            <div class="h-[40px] w-[40px]">
                <a href="https://www.twitch.tv/{{ $broadcasterName }}" target="_blank" class="select-none">
                    @if ($lazyLoad)
                        <img class="lozad rounded-full" src="" data-src="{{ $avatar }}" alt="avatar" />
                    @else
                        <img class="rounded-full" src="{{ $avatar }}" alt="avatar" />
                    @endif
                </a>
            </div>    
        </div>

        <div class="flex grow mx-2 truncate">
            <div class="flex flex-col">
                <a href="{{ $url }}" target="_blank">
                    <h3 class="text-[1.4rem] leading-[1.2] font-semibold whitespace-nowrap">
                        {{ $title }}
                    </h3>
                </a>
                <a href="{{ route('home', ['channel_id' => $channelId]) }}" target="_blank">
                    <p class="text-[1.3rem] leading-[1.5] [&:not(:hover)]:text-[#adadb8] whitespace-nowrap">
                        {{ $broadcasterName }}
                    </p>
                </a>
            </div>
        </div>

        <div class="flex grow justify-end items-center h-full">
            <button class="p-2 rounded hover:bg-[#2f2f35]" value="{{ $url }}" onclick="copyClipUrl(event)" data-tooltip-target="cp-{{ $id }}" data-tooltip-placement="left">
                    <div>
                        <svg class="fill-[#efeff1]" viewBox="0 0 16 16" version="1.1" width="16" height="16">
                            <path d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z"></path>
                            <path d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                        </svg>
                    </div>
                    <div class="hidden">
                        <div class="flex items-center">
                            <p class="mr-[.5rem]">copied</p>
                            <svg class="fill-[#3fcd8e]" viewBox="0 0 16 16" version="1.1" width="16" height="16">
                                <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z"></path>
                            </svg>
                        </div>
                    </div>
            </button>
            <div id="cp-{{ $id }}" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] select-none tooltip" role="tooltip">
                {{ __('Copy Clip URL') }}
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>

    <div>
        @auth
            @unless(in_array($id, Favorite::where('user_id', Auth::id())->first()['ids']))
                <form action="{{ route('favorite.save') }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="text" name="routeName" value="{{ Request::route()->getName() }}" class="hidden">
                    <input type="text" name="clip_id" value="{{ $id }}" class="hidden">
                    <button type="submit" class="w-full py-3 text-center rounded-md bg-[#3fcd8e] hover:bg-[#34d399] text-black text-2xl font-semibold select-none">
                        {{ __('Favorite this clip') }}
                    </button>
                </form>
            @else
                <form action="{{ route('favorite.delete') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="text" name="routeName" value="{{ request()->route()->getName() }}" class="hidden">
                    <input type="text" name="clip_id" value="{{ $id }}" class="hidden">
                    <button type="submit" class="w-full py-3 text-center rounded-md bg-red-600 hover:bg-red-600/80 font-semibold select-none">
                        {{ __('Unfavorite this clip') }}
                    </button>
                </form>
            @endunless
        @else
            <button type="button" onclick="document.querySelector('#login-modal').style='';" class="w-full py-3 text-center rounded-md bg-[#3fcd8e] hover:bg-[#34d399] text-black font-semibold select-none">
                {{ __('Favorite this clip') }}
            </button>
        @endauth
    </div>
</div>