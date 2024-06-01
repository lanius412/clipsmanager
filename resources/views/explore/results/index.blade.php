@extends('layouts.app')

@section('title', 'Explore Clips | ' . config('app.name'))

@section('header', 'Explore Clips')

@section('contents')
    
    @include('explore.form')

    <div class="relative pt-4">
        @isset($clips)
            <div class="mt-4">
                @include('explore.results.sort')
            </div>
            
            <div class="mt-4">
                <ul id="clip-box" class="grid grid-cols-[repeat(auto-fill,minmax(336px,1fr))] gap-4 relative my-0 mx-auto max-w-full">
                    @foreach ($clips as $clipIdx => $clip)
                        <li id="clip-{{ $clip['id'] }}" class="flex justify-center">
                            @if ($clipIdx > 10)
                                <x-clip-item
                                    lazyLoad
                                    id="{{ $clip['id'] }}"
                                    channelId="{{ $clip['channel_id'] }}"
                                    broadcasterName="{{ $clip['broadcaster_name'] }}"
                                    avatar="{{ $clip['avatar'] }}"
                                    title="{{ $clip['title'] }}"
                                    gameId="{{ $clip['game_id'] }}"
                                    url="{{ $clip['url'] }}"
                                    thumbnailUrl="{{ $clip['thumbnail_url'] }}"
                                    viewCount="{{ $clip['view_count'] }}"
                                    createdAt="{{ $clip['created_at'] }}" />
                            @else
                                <x-clip-item
                                    id="{{ $clip['id'] }}"
                                    channelId="{{ $clip['channel_id'] }}"
                                    broadcasterName="{{ $clip['broadcaster_name'] }}"
                                    avatar="{{ $clip['avatar'] }}"
                                    title="{{ $clip['title'] }}"
                                    gameId="{{ $clip['game_id'] }}"
                                    url="{{ $clip['url'] }}"
                                    thumbnailUrl="{{ $clip['thumbnail_url'] }}"
                                    viewCount="{{ $clip['view_count'] }}"
                                    createdAt="{{ $clip['created_at'] }}" />
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="inline-block top-1/2 left-1/2 absolute" style="transform: translateX(-50%)">
                <p class="text-[#adadb8] text-3xl italic">No clips found</p>
            </div>
        @endisset
    </div>

@endsection