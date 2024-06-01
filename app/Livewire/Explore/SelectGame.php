<?php

namespace App\Livewire\Explore;

use App\Services\TwitchService;
use Illuminate\Http\Request;
use Livewire\Component;

class SelectGame extends Component
{
    public $games = [];

    public $gameName = '';

    public function mount(Request $request)
    {
        $gameId = $request->game_id;
        if (!is_null($gameId)) {
            $games = TwitchService::getGames([
                'id' => $gameId
            ]);
            if (!is_null($games) && count($games) !== 0) {
                $this->gameName = $games[0]['name'];
            }
        }        
    }

    public function boot()
    {
        $top100Games = TwitchService::getTopGames([
            'first' => 100
        ]);

        if (!is_null($top100Games)) { 
            array_multisort(array_column($top100Games, 'name'), SORT_ASC, $top100Games);
            $this->games = $top100Games;
        }
    }
    
    public function render()
    {
        return view('livewire.explore.select-game');
    }
}
