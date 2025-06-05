<div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
 w-full p-2 pr-4 border-solid border-l-2 border-gray-300"
     id="pills-stageFour" role="tabpanel"
     aria-labelledby="pills-stageFour">
    <div class="charts-bg" x-data>
        <p class="p-2 mb-2 text-main"><strong>Organizational charts:</strong></p>
        <div class="w-full">
            <p class="p-2 text-justify">
                You can learn more about PERSOL by viewing <strong class="main-color">organizational charts</strong>.
            </p>
        </div>
        <div class="flex flex-wrap mt-4">
            <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6">
                <a href="" target="_blank">
                    <img class="thumbnail charts-thumbnails charts-thumbnails-color cursor-pointer"
                         src="/img/user/organization.svg"
                         alt="organizational chart" title="organizational chart" data-lity
                         data-lity-target="/img/user/organization.svg"
                         @mouseover="$el.setAttribute('src', '/img/user/organization-view.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/organization.svg')">
                </a>
            </div>
            <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6">
                <a href="" target="_blank">
                    <img class="thumbnail charts-thumbnails charts-thumbnails-color cursor-pointer"
                         src="/img/user/team.svg" data-lity data-lity-target="/img/user/team.svg"
                         alt="team chart" title="team chart"
                         @mouseover="$el.setAttribute('src', '/img/user/team-view.svg')"
                         @mouseout="$el.setAttribute('src','/img/user/team.svg')">
                </a>
            </div>
        </div>
    </div>
</div>
