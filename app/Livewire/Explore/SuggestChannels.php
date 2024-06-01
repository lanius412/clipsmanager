<?php

namespace App\Livewire\Explore;

use App\Services\TwitchService;
use Illuminate\Http\Request;
use Livewire\Component;

class SuggestChannels extends Component
{
    public $search = '';
    public $channels = null;
    public $isEmpty = 'No channels found.';

    public function mount(Request $request) {
        $this->search = $request->channel_id ?? '';
    }

    public function updatedSearch()
    {
        $this->getChannelSuggestions();
    }

    private function getChannelSuggestions()
    {
        $channels = TwitchService::searchChannels([
            'query' => $this->search,
            'first' => 10
        ]);

        $this->channels = $channels ?? [];
    }

    public function render()
    {   
        return view('livewire.explore.suggest-channels');
    }
}
