@push('scripts')
    <script>
        const clips = @json($clips);

        const sortClips = (e) => {
            const images = document.querySelectorAll('img.lozad');
            images.forEach(img => observer.triggerLoad(img));

            const sortBy = e.target.value;
            let sortedClips;
            switch (sortBy) {
                case 'desc-date':
                    sortedClips = clips.sort((n, m) => {
                        return (new Date(n.created_at) > new Date(m.created_at)) ? -1 : 1;
                    });
                    break;
                case 'asc-date':
                    sortedClips = clips.sort((n, m) => {
                        return (new Date(n.created_at) > new Date(m.created_at)) ? 1 : -1;
                    });
                    break;
                case 'view-count':
                    sortedClips = clips.sort((n, m) => {
                        return (Number(n.view_count) > Number(m.view_count)) ? -1 : 1;
                    });
                    break;
            }
            if (!sortedClips) return;

            const clipBox = document.querySelector('#clip-box');
            let clipItems = '';
            sortedClips.forEach(clip => {
                clipItems += clipBox.querySelector(`#clip-${clip.id}`).outerHTML;
            });
            clipBox.innerHTML = clipItems;
        }
    </script>
@endpush

<div x-data="{showSortBy: false, sortBy: 'Sort By'}">
    <div class="flex justify-end">
        <div class="relative">
            <button type="button"
                class="flex justify-between items-center relative w-[150px] h-[4.5rem] px-3 rounded-lg text-[1.4rem] font-semibold whitespace-nowrap select-none bg-[#18181b] transition-transform focus:transform duration-500 ease-in-out"
                @click="showSortBy = ! showSortBy"
                @click.outside="showSortBy = false"
                >
                <p x-text="sortBy"></p>
                <svg x-bind:style="{ transform: 'rotate(' + (showSortBy ? '180' : '0') + 'deg)' }" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7"/>
                </svg>
            </button>
    
            <div x-show="showSortBy" x-cloak @keydown.escape.window="showSortBy = false" class="absolute w-full z-[2]">
                <ul id="sort-by-list" class="flex flex-col gap-1 w-full mt-2 py-2 px-3 rounded bg-[#18181b]">
                    <li>
                        <button type="button"
                            value="desc-date"
                            class="w-full pl-2 py-2 rounded hover:bg-[#2f2f35] focus:bg-[#2f2f35] text-2xl font-semibold text-start select-none"
                            @click="sortBy = 'Desc Date'; showSortBy = false; sortClips($event)" >
                            {{ __('Desc Date') }}
                        </button>
                    </li>
                    <li>
                        <button type="button"
                            value="asc-date"
                            class="w-full pl-2 py-2 rounded hover:bg-[#2f2f35] focus:bg-[#2f2f35] text-2xl font-semibold text-start select-none"
                            @click="sortBy = 'Asc Date'; showSortBy = false; sortClips($event)" >
                            {{ __('Asc Date') }}
                        </button>
                    </li>
                    <li>
                        <button type="button"
                            value="view-count"
                            class="w-full pl-2 py-2 rounded hover:bg-[#2f2f35] focus:bg-[#2f2f35] text-2xl font-semibold text-start select-none"
                            @click="sortBy = 'View Count'; showSortBy = false; sortClips($event)" >
                            {{ __('View Count') }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>