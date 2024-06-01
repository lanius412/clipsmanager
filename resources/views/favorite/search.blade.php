@push('scripts')
    <script>
        const searchClips = @json($clips);
        const searchResult = document.querySelector('#search-result');

        document.querySelector('#search').addEventListener('input', (e) => {
            const clipBox = document.querySelector('.clip-box');
            const searchValue = e.target.value.toLowerCase();

            let result = 0;
            searchClips.forEach(clip => {
                if (!clip.title.toLowerCase().includes(searchValue)) {
                    clipBox.querySelector(`#clip-${clip.id}`).classList.add('hidden');
                } else {
                    clipBox.querySelector(`#clip-${clip.id}`).classList.remove('hidden');
                    result += 1;
                }
            });
            searchResult.textContent = `Result: ${result}`;
        });
    </script>
@endpush
<div class="mt-4">
    <div class="flex justify-center items-center">
        <div class="flex items-center max-w-full w-[50rem] py-4 px-4 bg-[#18181b] rounded">
            <button type="button" onclick="(document.querySelector('#search').focus())" class="flex justify-start fill-white">
                <svg width="20px" height="20px" version="1.1" viewBox="0 0 20 20" x="0px" y="0px"><g><path fill-rule="evenodd" d="M13.192 14.606a7 7 0 111.414-1.414l3.101 3.1-1.414 1.415-3.1-3.1zM14 9A5 5 0 114 9a5 5 0 0110 0z" clip-rule="evenodd"></path></g></svg>
            </button> 
            <input type="search" id="search" class="grow mx-4 border-none bg-transparent text-xl !shadow-none focus:ring-0 " autocomplete="off">
            <div class="flex justify-end">
                <div id="search-result">
                    All: {{ count($clips) }}
                </div>
            </div>
        </div>
    </div>
</div>