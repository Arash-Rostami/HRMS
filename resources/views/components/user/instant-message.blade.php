<div x-data="{ content: @entangle('content'), persian: false  }" id="instantMessage">
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <select class="bg-gray-300 @if ( isDarkMode())  bg-main @endif border border-gray-300 text-sm rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500
                    dark:focus:border-gray-500" wire:model="user">
                <option value="">Please select the recipient</option>
                @foreach ($users as $user)
                    <option value="{{$user->email}}">
                        {{$user->surname}} , {{ $user->forename }}
                    </option>
                @endforeach
            </select>
            @error('user') <span class="text-red-500 text-xs mb-2 italic">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">

            <input class="gauge-meter border border-gray-300 text-sm rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500
                    dark:focus:border-gray-500" type="text" placeholder="Topic" wire:model="topic">
            @error('topic') <span class="text-red-500 text-xs italic mb-4">{{ $message }}</span> @enderror
        </div>


        <div class="mb-2">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" x-on:click="persian = !persian">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-white-300 dark:peer-focus:ring-grey-800 rounded-full peer dark:bg-gray-400 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-800"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Persian</span>
            </label>
        </div>


        <div class="flex flex-col text-center" x-show="!persian">
            <div class="w-full mx-auto" wire:ignore>
                <div id="latin" x-ref="editorLatin" class="bg-gray-500"
                     @keyup="content = $refs.editorLatin.children[2].children[0].textContent;
                          $wire.set('content', content)"></div>
            </div>
        </div>

        <div class="flex flex-col text-center" x-show="persian">
            <div class="w-full mx-auto" wire:ignore>
                <div id="persian" x-ref="editorPersian" class="bg-gray-500"
                     @keyup="content = $refs.editorPersian.children[2].children[0].textContent;
                          $wire.set('content', content)"></div>
            </div>
        </div>
        @error('content') <span class="text-red-500 text-xs mb-2 italic">{{ $message }}</span> @enderror

        <div class="email-submit text-center m-auto justify-content-between w-1/6 bg-gray-300 @if ( isDarkMode())  bg-main @endif mt-4 p-4 rounded-l">
            <button type="button" title="send message" wire:click="sendMessage()">
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
            </button>
        </div>
    </form>
    {{-- to show notification--}}
    <x-user.toast/>
</div>
