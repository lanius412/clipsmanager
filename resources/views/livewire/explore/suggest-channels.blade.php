@push('scripts')
    <script>
        const nextSuggestion = (e) => {
            // console.log('next suggestion');
            e.preventDefault();
            const suggestions = document.querySelectorAll('#channel-suggestion-list button');
            const currentSuggestionIndex = [...suggestions].findIndex(elm => e.target === elm);
            if (e.target === document.querySelector('input[name="channel"]') || currentSuggestionIndex+1 === suggestions.length) {
                suggestions[0].focus();
            } else {
                suggestions[currentSuggestionIndex+1].focus();
            }
        }
        const prevSuggestion = (e) => {
            // console.log('prev suggestion')
            e.preventDefault();
            const suggestions = document.querySelectorAll('#channel-suggestion-list button');
            const currentSuggestionIndex = [...suggestions].findIndex(elm => e.target === elm);
            if (currentSuggestionIndex === 0) {
                suggestions[suggestions.length-1].focus();
            } else {
                suggestions[currentSuggestionIndex-1].focus();
            }
        }
    </script>
@endpush

<div x-data="{showSuggest: false}">
    <div id="input__channel-suggestions" class="relative">
        <input type="search"
            id="channel-id"
            name="channel_id"
            placeholder="iq200yukaf"
            autocomplete="off"
            wire:model.live.debounce.400ms="search"
            @input.debounce.1000ms="showSuggest = ($event.target.value != '')"
            @click="showSuggest = ! showSuggest"
            @click.outside="showSuggest = false"
            @keydown.down="nextSuggestion" />

        @isset($channels)
            <div x-show="showSuggest" x-cloak @keydown.escape.window="showSuggest = false" class="absolute w-full z-[2]">
                <ul id="channel-suggestion-list" class="flex flex-col gap-1 w-full mt-2 py-2 px-3 rounded bg-[#18181b]">
                    @forelse ($channels as $channel)
                        <li>
                            <button type="button"
                                class="w-full pl-2 py-2 rounded hover:bg-[#2f2f35] focus:bg-[#2f2f35] text-2xl text-start"
                                wire:click="$set('search', '{{ $channel['broadcaster_login'] }}')"
                                @click="showSuggest = false"
                                @keydown.tab="$event.shiftKey ? prevSuggestion : nextSuggestion"
                                @keydown.down="nextSuggestion"
                                @keydown.up="prevSuggestion" >
                                {{ $channel['broadcaster_login'] }}
                            </button>
                        </li>
                    @empty
                        <li x-cloak>
                            {{ $isEmpty }}
                        </li>
                    @endforelse
                </ul>
            </div>
        @endisset
    </div>
</div>