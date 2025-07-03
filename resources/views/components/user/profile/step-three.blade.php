<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly py-6" x-ref="step3">
    <!-- Interests -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="interests">
            <i class="fa fa-heart ml-2"></i>علایق و سرگرمی ها
        </label>
        <textarea wire:model="interests" id="interests"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        @error('interests') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Favorite Colors -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="favorite_colors">
            <i class="fa fa-palette ml-2"></i>رنگهای مورد علاقه
        </label>
        <textarea wire:model="favoriteColors" id="favorite_colors"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        @error('favoriteColors') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Image -->
    <div class="mb-4 md:w-1/5">
        <label class="block  mb-2" for="image"><i class="fa fa-image ml-2"></i>تصویر</label>
        {{--not uploaded file--}}
        @if ($image && !str_contains($image, 'tmp'))
            <div class="relative aspect-w-1">
                <img class="cursor-pointer" width="62px" src="{{ asset($image) }}" alt="profileImage"
                     title="click to enlarge the image" data-lity>
                {{-- if user wants to delete the image--}}
                @unless ($showDeleteConfirmation)
                    <span class="trash scale-20 top-3 left-10 cursor-pointer"
                          wire:click="showDeleteConfirmation"
                          title="click to delete the image">
    	                                <span></span>
    	                                    <i></i>
                                     </span>
                @else
                    <div
                        class="absolute bottom-0 left-0 right-0 top-0 bg-opacity-75 flex justify-center items-center">
                        <div
                            class="{{(isDarkMode() ? 'bg-gray-700' :'bg-gray-300')  }} rounded-md p-4 text-xs">
                            <p class="text-gray-500">آیا قصد حذف عکس پروفایل خود را دارید؟</p>
                            <div class="mt-4 flex justify-center space-x-4">
                                <button wire:click="hideDeleteConfirmation"
                                        class="bg-red-500 text-white px-2 py-1 rounded-md">خیر
                                </button>
                                <button wire:click="deleteImage"
                                        class="bg-green-500 text-white px-2 py-1 rounded-md">بلی
                                </button>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>
            {{--  if user is uploading file--}}
        @elseif(str_contains($image, 'tmp'))
            <i class="fa fa-check main-color" aria-hidden="true"></i>
            <p class="text-sm main-color">با موفقیت آپلود شد، صرفا بر گزینه ذخیره کلیک نمایید.</p>
            {{--if there is no image--}}
        @else
            <input wire:model="image" type="file" id="image"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 h-2/3 focus:outline-none ">
        @endif
        @error('image') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Submit Button -->
    <div class="mb-4 md:w-1/5 flex items-center justify-center pt-4">
        <button wire:click="saveProfile"
                title="ذخیره ویرایش"
                class="bg-main-mode hover:opacity-50 py-2 px-4 rounded mx-2">
            <i class="fas fa-check normal-color text-white"></i>
        </button>
        <button wire:click="cancelProfile"
                title="حذف ویرایش"
                class="bg-main-mode hover:opacity-50 py-2 px-4 rounded mx-2">
            <i class="fas fa-times normal-color text-white"></i>
        </button>
    </div>
</div>
