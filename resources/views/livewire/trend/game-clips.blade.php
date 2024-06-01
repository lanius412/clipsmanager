<div class="flex flex-col">
    <button type="button" wire:click="fetchClips({{ $gameData['id'] }})" >
        <div class="transform-image">
            <div class="transform-image__corner-top"></div>
            <div class="transform-image__corner-bottom"></div>
            <div class="transform-image__edge-left"></div>
            <div class="transform-image__edge-bottom"></div>
            <div class="transform-image-item">
                <div class="w-full overflow-hidden bg-[#53535f]/[.83]">
                    <div class="relative w-full overflow-hidden">
                        <img class="border-none w-full max-w-full min-h-full align-top" src="{{ $gameData['image'] }}" alt="{{ $gameData['name'] }} cover image">
                    </div>
                </div>
            </div>
        </div>
    </button>

    @script
    <script>
        const gameData = @json($gameData);
        const topClips = $wire.$el.parentElement.parentElement.parentElement.querySelector('#top-clips');
        $wire.on('clipsFetched', (data) => {
            const clips = data[0].clips;
            let clipItems = '';
            for (let i = 0; i < clips.length; i++) {
                clipItems += `
                    <li id="clip-${clips[i].id}">
                        <x-clip-item
                            id="${clips[i].id}"
                            channelId="${clips[i].channel_id}"
                            broadcasterName="${clips[i].broadcaster_name}"
                            avatar="${clips[i].avatar}"
                            title="${clips[i].title}"
                            gameId="${clips[i].game_id}"
                            url="${clips[i].url}"
                            thumbnailUrl="${clips[i].thumbnail_url}"
                            viewCount="${clips[i].view_count}"
                            createdAt="${clips[i].created_at}" />
                    </li>`;
            }            
            topClips.innerHTML = `
                <div class="pb-4">
                    <h2 class="text-[1.8rem] leading-[1.2] font-semibold">
                        <span>Top</span>
                        <a href="/?game_id=${gameData.id}" class="text-[#bf94ff] hover:underline">
                            ${gameData.name}
                        </a>
                        <span>clips</span>
                    </h2>
                </div>
                <ul id="clip-box" class="grid grid-cols-[repeat(auto-fill,minmax(336px,1fr))] gap-4 relative my-0 mx-auto max-w-full">
                    ${clipItems}
                </ul>`;
        });
    </script>
    @endscript

</div>
