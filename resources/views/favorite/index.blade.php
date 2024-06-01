@extends('layouts.app')

@section('title', 'Favorite Clips | ' . config('app.name'))

{{-- @section('header', 'Favorite Clips') --}}

@section('contents')

    @auth
        @section('header', 'Favorite Clips')

        @if (!empty($clips))
            {{-- @include('favorite.search') --}}
            @include('favorite.sort')

            <div class="mt-4">
                <ul id="clip-box" class="grid grid-cols-[repeat(auto-fill,minmax(336px,1fr))] gap-4 relative my-0 mx-auto max-w-full">
                    @foreach ($clips as $clipIdx => $clip)
                        <li id="clip-{{ $clip['id'] }}">
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
            <div class="inline-block top-1/2 left-1/2 absolute mt-4" style="transform: translateX(-50%)">
                <p class="text-[#adadb8] text-3xl italic">No favorite clips</p>
            </div>
        @endif

    @endauth

@endsection