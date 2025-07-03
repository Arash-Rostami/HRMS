<div class="p-2 pr-4 border-solid border-l-2 border-gray-300
hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
     id="pills-surveyFirst" data-te-tab-active
     role="tabpanel" aria-labelledby="tabs-hoe-tabVertical">
    <div>
        <div class="flex flex-col">
            <p class="p-2 mb-2 text-sm md:text-base text-main"><strong>Questionnaire of first day:</strong></p>
            <p class="p-2 text-justify">
                We will be grateful if you answer and rate some questions of this questionnaire with full transparency,
                away from any worries and only based on your personal experience. <br>
                <span class="text-sm">
                    If you had a better experience of an event similar to this one and you thought it could help us
                    make this process better, please share with us.
                </span>
            </p>
        </div>
        <div class="flex flex-wrap">
            @livewire('recruit-survey')
        </div>
    </div>
</div>
