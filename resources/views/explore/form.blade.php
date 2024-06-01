@once
    @push('scripts')
        <script src="{{ asset('/storage/js/flowbite/datepicker.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('game_id') && urlParams.get('game_id') !== '') {
                        document.querySelector('#game-tab').click();
                    }
                }, 1000);
            });
        </script>
        <script>
            const minViewCount = document.querySelector('#min-view-count');
            const addViewCount = () => {
                const currentMinViewCount = Number(minViewCount.value);
                minViewCount.value = currentMinViewCount + 1;
            }
            const subViewCount = () => {
                const currentMinViewCount = Number(minViewCount.value);
                minViewCount.value = currentMinViewCount > 0 ? currentMinViewCount-1 : 0;
            }
        </script>
        <script>
            const exploreForm = document.querySelector('.form__explore');
            const channelId = document.querySelector('#channel-id');
            exploreForm.addEventListener('submit', (e) => {
                e.preventDefault();

                if (!channelId.value && !showGameId.value && !hiddenGameId.value) {
                    alert('Channel ID or Game is required');
                    return
                }
                exploreForm.submit();
            });
        </script>
    @endpush
@endonce

<form class="form__explore" action="{{ route('explore') }}" method="GET">
    <div x-data="{tabOpen: 'channel'}" class="flex flex-col w-full">
        <div class="flex justify-start items-center relative w-full mb-8">
            <ul class="inline-grid grid-flow-col items-center h-full text-[1.8rem]" role="tablist">
                <li class="h-[calc(100%-.4rem)] p-[.2rem]" role="presentation">
                    <button type="button"
                        @click="tabOpen = 'channel'"
                        class="inline-block mr-4 font-semibold rounded-t-lg hover:text-[#a970ff]"
                        :class="{'border-b-2 border-[#bf94ff] text-[#bf94ff]': tabOpen === 'channel'}"
                        role="tab" >
                        Channel
                    </button>
                </li>
                <li class="h-[calc(100%-.4rem)] p-[.2rem]" role="presentation">
                    <button type="button"
                        id="game-tab"
                        @click="tabOpen = 'game'"
                        class="inline-block mx-4 font-semibold rounded-t-lg hover:text-[#a970ff]"
                        :class="{'border-b-2 border-[#bf94ff] text-[#bf94ff]': tabOpen === 'game'}"
                        role="tab" >
                        Game
                    </button>
                </li>
            </ul>
        </div>

        <div class="lg:grid grid-cols-2 gap-4">
            <div x-show="tabOpen === 'channel'" role="tabpanel">
                <div class="flex flex-col">
                    <label for="channel-id" class="mb-4 text-2xl">Type ID (end of string of Channel Page URL) with suggestions</label>
                    @livewire('explore.suggest-channels')
                </div>
            </div>
            <div x-show="tabOpen === 'game'" x-cloak role="tabpanel">
                <div class="flex flex-col">
                    <label for="show-game-id" class="mb-4 text-2xl">Select game (available in top 100 games)</label>
                    @livewire('explore.select-game')
                </div>
            </div>
            <div class="hidden lg:block"></div>
        </div>

        <div class="lg:grid grid-cols-2 gap-4 mt-4">
            <div>
                <div class="flex flex-col">
                    <label for="keyword" class="block mb-4 text-2xl">
                        Keyword
                    </label>
                    <input type="text"
                        id="keyword"
                        name="keyword"
                        placeholder="ALGS"
                        autocomplete="off" />
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <div class="flex flex-col">
                    <label for="min-view-count" class="block mb-4 text-2xl">
                        Min View Count
                    </label>
                    <div class="flex relative w-full">
                        <input type="text"
                            id="min-view-count"
                            name="min_view_count"
                            class="!rounded-r-none focus:!mr-[2px]"
                            value="30"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        <div class="flex">
                            <button type="button" onclick="subViewCount();" class="flex justify-center items-center w-[3.6rem] bg-[#2f2f35] hover:bg-[#38383f]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                  </svg>
                            </button>
                            <div class="w-[.75px] bg-[#18181b]"></div>
                            <button type="button" onclick="addViewCount();" class="rounded-r-lg flex justify-center items-center w-[3.6rem] bg-[#2f2f35] hover:bg-[#38383f]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                  </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:grid grid-cols-2 gap-4 mt-4">
            <div>
                <div class="flex flex-col">
                    <label for="start-date" class="block mb-4 text-2xl">
                        From
                    </label>
                    <div x-data="datepicker()" x-init="[initDate(), getNoOfDays()]">
                        <div class="relative">
                            <input type="text"
                                id="start-date"
                                name="start_date"
                                x-on:click="showDatepicker = !showDatepicker"
                                x-model="datepickerValue"
                                x-on:keydown.escape="showDatepicker = false"
                                placeholder="Select date" readonly />
                
                            <div class="datepicker-picker absolute top-0 left-0 w-[32rem] max-w-full rounded-lg shadow-lg z-10 mt-16 p-4 bg-[#18181b]" x-show.transition="showDatepicker" @click.away="showDatepicker = false" x-cloak>
                                <div class="datepicker-header">
                                    <div class="datepicker-controls grid grid-cols-[calc(100%/7)_calc(100%-100%/7*2)_calc(100%/7)] mb-2">
                                        <button type="button" 
                                            class="flex justify-center items-center rounded-lg hover:bg-[#53535F7A] text-lg p-2.5 prev-btn"
                                            @click="if (month === 0) { year--; month = 12; } month--; getNoOfDays()" >
                                            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"></path>
                                            </svg>
                                        </button>
                                        <div class="flex justify-center items-center">
                                            <span x-text="MONTH_NAMES[month]" class="text-lg font-semibold"></span>
                                            <span x-text="year" class="ml-1 text-lg font-semibold"></span>
                                        </div>
                                        <button type="button"
                                            class="flex justify-center items-center rounded-lg hover:bg-[#53535F7A] text-lg p-2.5 next-btn"
                                            @click="if (month === 11) { month = 0;  year++; } else { month++; } getNoOfDays()" >
                                            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="datepicker-main p-1">
                                    <div class="datepicker-view">
                                        <div class="days">
                                            <div class="days-of-week grid grid-cols-7 mb-1">
                                                <template x-for="(day, index) in DAYS" :key="index">
                                                    <span class="text-center leading-6 text-base font-medium text-gray-500" x-text="day"></span>
                                                </template>
                                            </div>
                                            
                                            <div class="datepicker-grid grid grid-cols-7">
                                                <template x-for="blankday in blankdays">
                                                    <span class="datepicker-cell block flex-1 leading-9 border-0 rounded-lg text-center font-semibold text-base day prev"></span>
                                                </template>
                                                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                    <span x-text="date"
                                                        @click="getDateValue(date)"
                                                        :class="{
                                                            'hover:bg-[#53535F7A]' : isSelectedDate(date) == false,
                                                            'bg-[#3fcd8e] text-black' : isSelectedDate(date) === true,
                                                            'text-gray-500 hover:bg-inherit !cursor-not-allowed' : isUnselectableDate(date) === true
                                                        }"
                                                        class="datepicker-cell block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center font-semibold text-base" >
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="datepicker-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <div class="flex flex-col">
                    <div class="flex items-center mb-4">
                        <label for="end-date" class="text-2xl">
                            To
                        </label>
                        <div class="flex items-center ml-2">
                            <figure class="inline-flex items-center" data-tooltip-target="explore-date__hint" data-tooltip-placement="top">
                                <svg class="w-[17px] h-[17px] text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z" clip-rule="evenodd"/>
                                </svg>
                            </figure>
                            <div id="explore-date__hint" role="tooltip" class="inline-block invisible opacity-0 absolute z-10 py-[3px] px-[6px] rounded-[.4rem] shadow-sm bg-[#ffffff] text-[#0e0e10] font-semibold text-[1.3rem] leading-[1.2] text-wrap tooltip">
                                If not specified, get clips from the most recent week
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>

                    <div x-data="datepicker()" x-init="[initDate(), getNoOfDays(), enableTodayBtn(), setWidth('32rem')]">
                        <div class="relative">
                            <input type="text"
                                id="end-date"
                                name="end_date"
                                x-on:click="showDatepicker = !showDatepicker"
                                x-model="datepickerValue"
                                x-on:keydown.escape="showDatepicker = false"
                                placeholder="Select date" readonly />
                
                            <div class="datepicker-picker absolute top-0 left-0 w-1/2 max-w-full rounded-lg shadow-lg z-10 mt-16 p-4 bg-[#18181b]" x-show.transition="showDatepicker" @click.away="showDatepicker = false" x-cloak>
                                <div class="datepicker-header">
                                    <div class="datepicker-title"></div>
                                    <div class="datepicker-controls">
                                        <div class="grid grid-cols-[calc(100%/7)_calc(100%-100%/7*2)_calc(100%/7)] mb-2">
                                            <button type="button" 
                                                class="prev-btn flex justify-center items-center rounded-lg hover:bg-[#53535F7A] text-lg p-2.5"
                                                @click="if (month === 0) { year--; month = 12; } month--; getNoOfDays()" >
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"></path>
                                                </svg>
                                            </button>
                                            <div class="flex justify-center items-center">
                                                <span x-text="MONTH_NAMES[month]" class="text-lg font-semibold"></span>
                                                <span x-text="year" class="ml-1 text-lg font-semibold"></span>
                                            </div>
                                            <button type="button"
                                                class="next-btn flex justify-center items-center rounded-lg hover:bg-[#53535F7A] text-lg p-2.5"
                                                @click="if (month === 11) { month = 0;  year++; } else { month++; } getNoOfDays()" >
                                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="datepicker-main p-1">
                                    <div class="grid grid-cols-7 mb-1">
                                        <template x-for="(day, index) in DAYS" :key="index">
                                            <span class="text-center leading-6 text-base font-medium text-gray-500" x-text="day"></span>
                                        </template>
                                    </div>
                                    
                                    <div class="grid grid-cols-7">
                                        <template x-for="blankday in blankdays">
                                            <span></span>
                                        </template>
                                        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                            <span x-text="date"
                                                @click="getDateValue(date)"
                                                :class="{
                                                    'hover:bg-[#53535F7A]' : isSelectedDate(date) == false,
                                                    'bg-[#3fcd8e] text-black' : isSelectedDate(date) === true,
                                                    'text-gray-500 hover:bg-inherit !cursor-not-allowed' : isUnselectableDate(date) === true
                                                }"
                                                class="block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center font-semibold text-base" >
                                            </span>
                                        </template>
                                    </div>
                                </div>
                                <div class="datepicker-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        const MONTH_NAMES = [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December",
                        ];
                        const MONTH_SHORT_NAMES = [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ];
                        const DAYS = [
                            "Sun",
                            "Mon",
                            "Tue",
                            "Wed",
                            "Thu",
                            "Fri",
                            "Sat"
                        ];
                    
                        function datepicker() {
                            return {
                                showDatepicker: false,
                                datepickerValue: "",
                                selectedDate: "",
                                dateFormat: "YYYY-MM-DD",
                                month: "",
                                year: "",
                                no_of_days: [],
                                blankdays: [],
                                initDate() {
                                    const today = new Date();
                                    this.month = today.getMonth();
                                    this.year = today.getFullYear();
                                    // this.datepickerValue = this.formatDateForDisplay(
                                    //     today
                                    // );
                                },
                                formatDateForDisplay(date) {
                                    const formattedDay = DAYS[date.getDay()];
                                    const formattedDate = ("0" + date.getDate()).slice(-2);
                                    const formattedMonth = MONTH_NAMES[date.getMonth()];
                                    const formattedMonthShortName = MONTH_SHORT_NAMES[date.getMonth()];
                                    const formattedMonthInNumber = (
                                        "0" +
                                        (parseInt(date.getMonth()) + 1)
                                    ).slice(-2);
                                    const formattedYear = date.getFullYear();
                                    return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`; // YYYY-MM-DD
                                },
                                isSelectedDate(date) {
                                    const d = new Date(this.year, this.month, date);
                                    return this.datepickerValue === this.formatDateForDisplay(d) ? true : false;
                                },
                                isUnselectableDate(date) {
                                    const today = new Date();
                                    const tomorrow = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
                                    const d = new Date(this.year, this.month, date);
                                    return d >= tomorrow ? true : false;
                                },
                                isToday(date) {
                                    const today = new Date();
                                    const d = new Date(this.year, this.month, date);
                                    return today.toDateString() === d.toDateString() ? true : false;
                                },
                                getDateValue(date) {
                                    if (this.isUnselectableDate(date)) return;

                                    const selectedDate = new Date(
                                        this.year,
                                        this.month,
                                        date
                                    );
                                    this.datepickerValue = this.formatDateForDisplay(
                                        selectedDate
                                    );
                                    this.isSelectedDate(date);
                                    this.showDatepicker = false;
                                },
                                getNoOfDays() {
                                    const daysInMonth = new Date(
                                        this.year,
                                        this.month + 1,
                                        0
                                    ).getDate();
                                    const dayOfWeek = new Date(
                                        this.year,
                                        this.month
                                    ).getDay();
                                    const blankdaysArray = [];
                                    for (var i = 1; i <= dayOfWeek; i++) {
                                        blankdaysArray.push(i);
                                    }
                                    const daysArray = [];
                                    for (var i = 1; i <= daysInMonth; i++) {
                                        daysArray.push(i);
                                    }
                                    this.blankdays = blankdaysArray;
                                    this.no_of_days = daysArray;
                                },
                                setWidth(width) {
                                    this.$el.querySelector('.datepicker-picker').style = `width: ${width} !important;`;
                                },
                                setTitle(title) {
                                    const titleElm = this.$el.querySelector('.datepicker-title');
                                    if (titleElm) {
                                        titleElm.innerHTML = `
                                            <div class="px-4 py-5 text-center">
                                                <span class="font-semibold">${title}</span>
                                            </div>`;
                                    } else {
                                        console.log('Not found title element');
                                    }
                                },
                                enableTodayBtn() {
                                    const footerElm = this.$el.querySelector('.datepicker-footer');
                                    if (footerElm) { 
                                        footerElm.innerHTML = `
                                            <div class="flex justify-between gap-2 p-1">
                                                <button type="button" class="grow py-2 rounded-md bg-[#3fcd8e] text-white font-semibold text-lg hover:bg-[#34d399]" @click="selectToday()">Today</button>
                                                <button type="button" class="grow py-2 rounded-md bg-zinc-500 text-white font-semibold text-lg hover:bg-zinc-600" @click="clearSelectedDate()">Clear</button>
                                            </div>`;
                                    } else {
                                        console.log('Not found footer element');
                                    }
                                },
                                selectToday() {
                                    const today = new Date();
                                    this.year = today.getFullYear();
                                    this.month = today.getMonth();
                                    this.datepickerValue = this.formatDateForDisplay(today);
                                    this.showDatepicker = false;
                                },
                                clearSelectedDate() {
                                    this.datepickerValue = "";
                                    this.showDatepicker = false;
                                }
                            };
                        }
                      </script>
                </div>
            </div>
        </div>

        <div class="flex mt-4">
            <button type="submit" class="inline-flex justify-center items-center align-middle relative w-[clamp(100px,25%,200px)] h-[3.6rem] rounded-lg text-[1.4rem] font-semibold whitespace-nowrap select-none bg-[#9147ff] hover:bg-[#772ce8]">
                <div class="flex grow-0 items-center px-4 py-0">
                    <div class="flex grow-0 justify-start items-center">
                        Explore
                    </div>
                </div>
            </button>
            <div class="relative ml-4 w-full">
                <p class="bottom-0 absolute">
                    * max 200 clips
                </p>
            </div>
        </div>

    </div>
</form>
