
<div class="flex flex-col active sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl
    @if ( isDarkMode()) bg-[#1F2937] @endif ignore-elements main-user-accordion-panel"
     x-cloak>
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2 class="accordion button user-panel-badge cursor-pointer before:content-['+'] scale-[0.8] w-2/3 md:w-1/2 box-shadow-customized @if ( isDarkMode())text-gray-300 @endif"
            title="This is to send a quick notification through PERSOL standard email format."
            onclick="(this.classList.contains('before:content-['+']')) ? this.classList.toggle('before:content-['+']')
            : this.classList.add('before:content-['+']'); "
            data-te-collapse-init
            data-te-target="#flush-collapseEmail"
            type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEmail"
            aria-expanded="false" aria-controls="flush-collapseEmail"> IM
            <i class='fas fa-envelope-open-text'></i>
        </h2>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseEmail"
         class="notranslate accordion-collapse border-0 !visible hidden @if ( isDarkMode())text-gray-300 @endif"
         data-te-collapse-item
         data-te-collapse-collapsed
         aria-labelledby="flush-collapseEmail" data-te-parent="#accordionFlushExample" x-ref="accordion"
         wire:ignore.self>
        <x-user.instant-message :users="$users" :user="$user"/>
    </div>

</div>



