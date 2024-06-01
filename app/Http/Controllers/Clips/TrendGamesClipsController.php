<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Services\TwitchService;
use App\Traits\ClipTrait;
use Carbon\CarbonImmutable;
use Illuminate\Support\Number;
use Illuminate\View\View;

class TrendGamesClipsController extends Controller
{
    use ClipTrait;

    public function getTrendGamesClips(): View
    {
        $games = TwitchService::getTopGames([
            'first' => 9
        ]);
        if (is_null($games)) return view('trend.index');

        $firstGameClips = null;
        if (session()->has('trend')) {
            $sessionTrendGamesClips = json_decode(session()->get('trend', ''), true);
            if (array_column($sessionTrendGamesClips, 'id') === array_column($games, 'id')) {
                return view('trend.index')->with([
                    'trendGamesClips' => $sessionTrendGamesClips
                ]);
            }
            if ($sessionTrendGamesClips[0]['id'] === $games[0]['id']) {
                $firstGameClips = $sessionTrendGamesClips[0];
            }
        }

        $trendGamesClips = [];
        foreach ($games as $gameIdx => $game) {
            $clips = null;
            if ($gameIdx === 0) {
                if (!is_null($firstGameClips)) {
                    $trendGamesClips = $firstGameClips;
                    continue;
                }
                $clipsBody = TwitchService::getClips([
                    'game_id' => $game['id'],
                    'first' => 10
                ]);
                if (!is_null($clipsBody) || count($clipsBody['data']) !== 0) {
                    $clips = $clipsBody['data'];
                    $broadcasterIds = array_column($clips, 'broadcaster_id');
                    $users = TwitchService::getUsers(['id' => $broadcasterIds]);
                    if (!is_null($users)) {
                        $userIds = array_column($users, 'id');
                        foreach ($clips as $clipIdx => &$clip) {
                            $clip['view_count'] = Number::abbreviate($clip['view_count']);
                            $clip['created_at'] = CarbonImmutable::parse($clip['created_at'])->format('Y/m/d H:i');
                            $key = array_search($clip['broadcaster_id'], $userIds);
                            if ($key !== false) {
                                $clip['channel_id'] = $users[$key]['login'];
                                $clip['avatar'] = $users[$key]['profile_image_url'];
                            } else {
                                unset($clips[$clipIdx]);
                            }
                        }
                    }
                    // check if process is failed
                    if (count($clips) !== 0 && !array_key_exists('channel_id', $clips[0])) {
                        $clips = [];
                    }
                }
            }

            $categoryName = str_replace(' ', '_', strtolower($game['name']));
            $categoryImage = str_replace(['{width}', '{height}'], ['285', '380'], $game['box_art_url']);

            array_push($trendGamesClips, [
                'id' => $game['id'],
                'name' => $game['name'],
                'image' => $categoryImage,
                'category' => $categoryName,
                'clips' => $clips
            ]);
        }

        session()->put('trend', json_encode($trendGamesClips));

        return view('trend.index')->with([
            'trendGamesClips' => $trendGamesClips
        ]);
    }
}
