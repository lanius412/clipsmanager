<?php

namespace App\Livewire\Trend;

use Livewire\Component;
use App\Services\TwitchService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Number;

class GameClips extends Component
{
    public $gameData = [
        'id' => '',
        'name' => 'Something went wrong',
        'image' => ''
    ];

    public function fetchClips($gameId)
    {
        $clipsBody = TwitchService::getClips([
            'game_id' => $gameId,
            'first' => 10
        ]);
        $clips = (is_null($clipsBody) || count($clipsBody['data']) === 0) ? [] : $clipsBody['data'];
        $broadcasterIds = array_column($clips, 'broadcaster_id');
        $users = TwitchService::getUsers(['id' => $broadcasterIds]);
        if (is_null($users) || count($users) === 0) return;

        $userIds = array_column($users, 'id');
        foreach ($clips as $idx => &$clip) {
            $clip['view_count'] = Number::abbreviate($clip['view_count']);
            $clip['created_at'] = CarbonImmutable::parse($clip['created_at'])->format('Y/m/d H:i');
            $key = array_search($clip['broadcaster_id'], $userIds);
            if ($key !== false) {
                $clip['channel_id'] = $users[$key]['login'];
                $clip['avatar'] = $users[$key]['profile_image_url'];
            } else {
                unset($clips[$idx]);
            }
        }

        $this->dispatch('clipsFetched', ['clips' => $clips]);
    }

    public function render()
    {
        return view('livewire.trend.game-clips');
    }
}
