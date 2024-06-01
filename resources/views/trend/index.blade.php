@extends('layouts.app')

@section('title', 'Trend Games Clips | ' . config('app.name'))

@section('header', 'Trend Games Top Clips')

@push('css')
    <link rel="stylesheet" href="{{ asset('/storage/css/transform-image.css') }}">
@endpush

@section('contents')
    
    @isset($trendGamesClips)
    
        <div class="flex flex-nowrap min-w-full">
            @foreach ($trendGamesClips as $gameIdx => $game)  
                <div class="grow mx-2 max-w-[350px] @php
                    switch ($gameIdx) {
                        case 1:
                            echo 'hidden min-[460px]:block';
                            break;
                        case 2:
                            echo 'hidden min-[640px]:block';
                            break;
                        case 3:
                            echo 'hidden min-[820px]:block';
                            break;
                        case 4:
                            echo 'hidden min-[1000px]:block';
                            break;
                        case 5:
                            echo 'hidden min-[1180px]:block';
                            break;
                        case 6:
                            echo 'hidden min-[1360px]:block';
                            break;
                        case 7:
                            echo 'hidden min-[1540px]:block';
                            break;
                        case 8:
                            echo 'hidden min-[1720px]:block';
                            break;
                    } @endphp"
                    id="{{ $game['name'] }}">
                    <livewire:trend.game-clips :gameData="$game" />
                </div>
            @endforeach
        </div>
        
        <div id="top-clips" class="my-8">
            <div class="pb-4">
                <h2 class="text-[1.8rem] leading-[1.2] font-semibold">
                    <span>Top</span>
                    <a href="{{ route('home', ['game_id' => $trendGamesClips[0]['id']]) }}" class="text-[#bf94ff] hover:underline">
                        {{ $trendGamesClips[0]['name'] }}
                    </a>
                    <span>clips</span>
                </h2>
            </div>
            <div>
                <ul id="clip-box" class="grid grid-cols-[repeat(auto-fill,minmax(336px,1fr))] gap-4 relative my-0 mx-auto max-w-full">
                    @foreach ($trendGamesClips[0]['clips'] as $clip)
                        <li id="clip-{{ $clip['id'] }}" class="flex justify-center">
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
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
    @endisset

@endsection