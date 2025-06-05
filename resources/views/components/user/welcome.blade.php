<div class="hidden block opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
 p-2 pr-4 border-solid border-l-2 border-gray-300"
     id="pills-stageOne"
     role="tabpanel" data-te-tab-active
     aria-labelledby="pills-stageOne">
    <div class="welcome-bg" x-data>
        <div class="flex flex-wrap">
            <p class="p-2 mb-2 text-main"><strong>Welcome!</strong></p>
            <p class="p-2 text-justify">
                We're pleased to have you in our company! This section includes all the information of company
                that you may need as a new member. This part is fun and interactive, so read it carefully. You will find
                what
                makes our <strong>PERSOL</strong> unique and what resources are available to you. You will also see some
                answers to frequently asked questions.
            </p>
        </div>
        <div class="flex text-center py-8 mt-5">
            <b class="p-2 d-block text-main">
                watch our welcome clips
            </b>
        </div>
        <div class="flex flex-wrap">
            <div class="w-2/3 mx-auto md:mx-0 my-4 md:w-1/6">
                <a target="_blank" href="">
                    <img class="thumbnail welcome-thumbnails welcome-thumbnails-color" src="/img/user/ceo-f.svg"
                         alt="ceo-female" title="A Welcome from Parva Soltani (CEO)"
                         @mouseover="$el.setAttribute('src', '/img/user/ceo-f-play.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/ceo-f.svg')">
                </a>
            </div>
            <div class="w-2/3 mx-auto md:mx-0 my-4 md:w-1/6 ">
                <a target="_blank" href="">
                    <img class="thumbnail welcome-thumbnails welcome-thumbnails-color" src="/img/user/ceo-m.svg"
                         alt="ceo-male" title="A Welcome from Pedram Soltani (CEO)"
                         @mouseover="$el.setAttribute('src', '/img/user/ceo-m-play.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/ceo-m.svg')">
                </a>
            </div>
            <div class="w-2/3 mx-auto md:mx-0 my-4 md:w-1/6">
                <a target="_blank" href="">
                    <img class="thumbnail welcome-thumbnails welcome-thumbnails-color" src="/img/user/welcome-card.svg"
                         alt="welcome-card" title="A tour of PERSOL"
                         @mouseover="$el.setAttribute('src', '/img/user/welcome-card-play.svg')"
                         @mouseout="$el.setAttribute('src', '/img/user/welcome-card.svg')">
                </a>
            </div>
        </div>
    </div>

</div>
