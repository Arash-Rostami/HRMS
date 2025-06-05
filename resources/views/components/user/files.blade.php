<div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
w-full p-2 pr-4 border-solid border-l-2 border-gray-300"
     id="pills-stageFive" role="tabpanel"
     aria-labelledby="pills-stageFive" >
    <div class="files-bg" x-data>
        <p class="p-2 mb-2 text-main"><strong>Organizational manuals:</strong></p>
        <div class="w-full">
            <p class="p-2 text-justify">
                You need to ensure studying the following <strong class="main-color">organizational manuals</strong>
                carefully.
            </p>
        </div>
        <div class="flex flex-wrap">
            <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6">
                <a target="_blank" href="/files/values/index.html">
                    <img class="thumbnail files-thumbnails files-thumbnails-color" src="/img/user/principles.svg"
                         alt="The principles and values of PERSOL" title="The principles and values of PERSOL"
                         @mouseover="$el.setAttribute('src', '/img/user/principles-read.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/principles.svg')">
                </a>
            </div>
            <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6">
                <a target="_blank" href="/files/competencies/index.html">
                    <img class="thumbnail files-thumbnails files-thumbnails-color" src="/img/user/competencies.svg"
                         alt="The booklet of competencies in PERSOL" title="The booklet of competencies in PERSOL"
                         @mouseover="$el.setAttribute('src', '/img/user/competencies-read.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/competencies.svg')">
                </a>
            </div>
            <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6">
                <a target="_blank" href="">
                    <img class="thumbnail files-thumbnails files-thumbnails-color" src="/img/user/job-details.svg"
                         alt="Job ID and organizational post details" title="Job ID and organizational post details"
                         @mouseover="$el.setAttribute('src', '/img/user/job-details-read.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/job-details.svg')">
                </a>
            </div>
        </div>
    </div>
</div>
