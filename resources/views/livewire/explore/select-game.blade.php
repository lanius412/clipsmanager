@push('scripts')
    <script>
        const hiddenGameId = document.querySelector('#hidden-game-id');
        const showGameId = document.querySelector('#show-game-id');
        const selectGame = (e) => {
            const selectedGame = e.target.textContent.trim();
            const selectedGameId = e.target.value;
            showGameId.value = selectedGame;
            hiddenGameId.value = selectedGameId;
        }

        const nextGame = (e) => {
            // console.log('next game');
            e.preventDefault();
            const games = document.querySelectorAll('#top100-games-list button');
            const currentGameIndex = [...games].findIndex(elm => e.target === elm);
            if (e.target === document.querySelector('input#show-game-id') || currentGameIndex+1 === games.length) {
                games[0].focus();
            } else {
                games[currentGameIndex+1].focus();
            }
        }
        const prevGame = (e) => {
            // console.log('prev game');
            e.preventDefault();
            const games = document.querySelectorAll('#top100-games-list button');
            const currentGameIndex = [...games].findIndex(elm => e.target === elm);
            if (currentGameIndex === 0) {
                games[games.length-1].focus();
            } else {
                games[currentGameIndex-1].focus();
            }
        }
    </script>
@endpush
<div x-data="{showSelectGame: false}">
    <div id="input__select-game" class="relative">
        <input type="text" id="hidden-game-id" name="game_id" class="!hidden" value="{{ Request::get('game_id', '') }}">
        <input type="text"
            id="show-game-id"
            class="disabled:opacity-70"
            readonly
            placeholder="-"
            autocomplete="off"
            wire:model="gameName"
            @click="showSelectGame = ! showSelectGame"
            @click.outside="showSelectGame = false"
            @keydown.tab="nextGame; showSelectGame = true"
            @keydown.down="nextGame; showSelectGame = true"
            @if (empty($games)) disabled @endif />
        
        @isset($games)
            <div x-show="showSelectGame" x-cloak @keydown.escape.window="showSelectGame = false" class="absolute w-full h-[330px] z-[2]">
                <ul id="top100-games-list" class="scrollable-area flex flex-col gap-1 w-full mt-2 py-2 px-3 rounded bg-[#18181b] overflow-y-auto" data-simplebar data-simplebar-auto-hide="true" tabindex="-1">
                    @foreach ($games as $game)
                        <li>
                            <button type="button"
                                class="w-full pl-2 py-2 rounded hover:bg-[#2f2f35] focus:bg-[#2f2f35] text-2xl text-start"
                                value="{{ $game['id'] }}"
                                onclick="selectGame(event)"
                                @click="showSelectGame = false"
                                @keydown.tab="$event.shiftKey ? prevGame : nextGame"
                                @keydown.down="nextGame"
                                @keydown.up="prevGame"
                                onkeydown="keydown(event)"
                            >
                                {{ $game['name'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endisset
    </div>
</div>
