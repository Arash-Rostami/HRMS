{{-- Filter the result --}}
<div class="flex flex-col"
     x-data="{
     selectedDepartment: 'AS',

     expandAll() {
            const allPanels = document.querySelectorAll('.all-items');
            allPanels.forEach(panel => {
                panel.classList.remove('hidden');
                panel.removeAttribute('data-te-collapse-show');
            });
        },
        collapseAll() {
         const allPanels = document.querySelectorAll('.all-items');
            allPanels.forEach(panel => {
                panel.classList.add('hidden');
                panel.setAttribute('data-te-collapse-show','');
            });
        },
        filterByDepartment(code) {
             const records = document.querySelectorAll('.delegation-record');
             records.forEach((record) => record.style.display = (record.getAttribute('data-department') === code) ? 'block' : 'none');
             this.selectedDepartment = code;
     }}"
     x-init="filterByDepartment(selectedDepartment)">
    <div class="my-8 md:ml-4 ">
        <h5 class="text-justify">
            Transparent Overview of Authorities Delegated.
        </h5>
        <div class="flex flex-row-reverse">
            <button title="Back to the user panel"
                    @click="window.location.href = '{{ route('user.panel.delegation') }}'"
                    class="bg-main-mode hover:opacity-50 py-1 px-2 rounded">
                <i class="fas fa-arrow-left normal-color text-white"></i>
            </button>
        </div>
    </div>


    {{-- Filter by selecting departments --}}
    <div class="flex flex-row-reverse flex-wrap ml-auto px-3 pb-6 gap-1">
        @foreach(getPersianNamesOfDepts() as $department)
                <?php $departmentCode = getCodesOfDepts($department); ?>
            <button
                id="dept-{{ $departmentCode }}"
                class="dept-button px-2 py-2 text-sm rounded-lg hover:opacity-70 border-r border-white persol-farsi-font"
                :class="selectedDepartment === '{{ $departmentCode }}' ? 'bg-main-theme text-white' : 'bg-main-mode text-white'"
                @click="filterByDepartment('{{ $departmentCode }}')">
                ({{$departmentCode}}) {{ $department }}
            </button>
        @endforeach

    </div>
    {{-- Collapse & Expand All duties --}}
    <div class="flex flex-row mx-4">
        <button @click="expandAll()" class="bg-main-mode hover:opacity-50  text-white m-2 p-1 rounded" title="Expand All">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <button @click="collapseAll()" class="bg-main-mode hover:opacity-50  text-white m-2 p-1 rounded" title="Collapse All">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>

    </div>
</div>


<div id="accordionDelegations" class="rtl-direction persol-farsi-font">
    @foreach($delegations as $delegation)
        @php
            $icon = getExecutionProcedureIcon($delegation->details['execution_procedure']);
        @endphp

        <div data-department="{{ $delegation->dept }}"
             x-transition
             x-transition.duration.500ms
             class="delegation-record faqs faq-container rounded-t-lg border links-thumbnails links-thumbnails-color bg-[--bg-main]">
            <h2 class="mb-0" id="heading{{$delegation->id}}">
                <button
                    class="group delegation-search relative flex w-full items-center rounded-t-[15px] border-0 px-5 py-4 text-right text-base transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none  @if (isDarkMode()) bg-main-theme @endif [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)]  dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]"
                    type="button"
                    data-te-collapse-init
                    data-te-collapse-collapsed
                    data-te-target="#collapse{{$delegation->id}}"
                    aria-expanded="true"
                    aria-controls="collapse{{$delegation->id}}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ $delegation->details['duty'] }}
                    <svg class="w-4 h-4 inline-block mx-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="{{ $delegation->sub_duty ? 'M17 20h5v-2a3 3 0 00-3-3H5a3 3 0 00-3 3v2h5m5-6a4 4 0 110-8 4 4 0 010 8zm0 0V10' : 'M15 12a3 3 0 100-6 3 3 0 000 6zm-9-3a3 3 0 100-6 3 3 0 000 6zM7 14l3-2 3 2m-6 0v4h6v-4' }}"/>
                    </svg>
                    <span class="text-main">
                       {{ $delegation->sub_duty ? 'مرتبط با وظائف همکاران زیر مجموعه' : ($delegation->user ? $delegation->user->fullName : 'No User Assigned') }}

                    </span>
                    <span
                        class="mr-auto h-5 w-5 shrink-0 rotate-[180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </button>
            </h2>
            <div class="!visible all-items" id="collapse{{$delegation->id}}"
                 x-transition
                 x-transition.duration.500ms
                 data-te-collapse-item
                 data-te-collapse-show
                 aria-labelledby="heading{{$delegation->id}}"
                 data-te-parent="#accordionDelegation">
                <div class="px-5 py-4 delegation-search">
                    <div class="flex flex-wrap justify-around rounded-lg shadow @if (isDarkMode()) bg-[#1F2937] @endif">
                        @if(auth()->user()->profile->position == "manager")
                            {{--execution_procedure--}}
                            <div class="p-4 mx-1 shadow-lg rounded-lg">
                                <div class="flex flex-col items-center">
                                    <img src="{{ $icon['src'] }}" alt="{{ $icon['alt'] }}" class="w-12 h-12">
                                    <p class="m-auto font-semibold pt-5">
                                        <span class="text-main"> روش اجرایی (فرایند) مصوب </span>
                                        {{ translateExecutionProcedure($delegation->details['execution_procedure']) }}
                                    </p>
                                </div>
                            </div>
                            {{--repeat_frequency--}}
                            <div class="p-4 mx-1 shadow-lg rounded-lg">
                                <div class="flex flex-col items-center">
                                    <img src="/img/user/times_icon.png" alt="times" class="w-12 h-12">
                                    <p class="m-auto font-semibold pt-5">
                                        <span class="text-main">فراوانی تکرار</span>
                                        {{ translateRepeatFrequency($delegation->details['repeat_frequency']) }}
                                    </p>
                                </div>
                            </div>
                            {{--impact_score--}}
                            <div class="p-4 mx-1 shadow-lg rounded-lg">
                                <div class="flex flex-col items-center">
                                    <img src="/img/user/rocket_icon.png" alt="urgency" class="w-12 h-12">
                                    <p class="m-auto font-semibold pt-5">
                                        <span class="text-main"> شاخص اثر</span>
                                        {{ translateImpactScore($delegation->details['impact_score']) }}
                                    </p>
                                </div>
                            </div>
                            {{--proposed_delegation--}}
                            <div class="p-4 mx-1 shadow-lg rounded-lg">
                                <div class="flex flex-col items-center">
                                    <img src="/img/user/puzzle_icon.png" alt="proposed_delegation" class="w-12 h-12">
                                    <p class="m-auto font-semibold pt-5">
                                        <span class="text-main"> سطح تفویض پیشنهادی</span>
                                        {{ translateDelegationLevel($delegation->details['proposed_delegation']) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        {{--approved_delegation--}}
                        <div class="p-4 mx-1 shadow-lg rounded-lg">
                            <div class="flex flex-col items-center">
                                <img src="/img/user/puzzle_complete_icon.png" alt="approved_delegation"
                                     class="w-12 h-12">
                                <p class="m-auto font-semibold pt-5">
                                    <span class="text-main">سطح تفویض مصوب</span>
                                    {{ translateDelegationLevel($delegation->details['approved_delegation']) }}
                                </p>
                            </div>
                        </div>
                        {{--co_delegate--}}
                        <div class="p-4 mx-1 shadow-lg rounded-lg">
                            <div class="flex flex-col items-center">
                                <img src="/img/user/handshake_icon.png" alt="co_delegate" class="w-12 h-12">
                                <p class="m-auto font-semibold pt-5">
                                    <span class="text-main"> تفویض مشترک با</span>
                                    {{ !empty($delegation->details['co_delegate']) ? $delegation->details['co_delegate'] : 'کسی ذکر نشده!' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

