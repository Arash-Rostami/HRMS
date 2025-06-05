@if ($ticketToRate)
    <form wire:submit.prevent="submitRating">
        <div class="m-4 w-full">
            <h2 class="text-lg font-bold mb-4">لطفا به نحوه بررسی تیکت زیر امتیاز دهید:</h2>
            <p><strong class="text-main mx-1">موضوع تیکت:</strong> {{ $ticketToRate->request_subject }}</p>
            <p><strong class="text-main mx-1">توضیحات:</strong> {{ Str::limit($ticketToRate->description, 100) }}</p>
        </div>
        <div class="m-4 w-full md:w-1/3">
            <label for="satisfactionScore" class="block mb-2">
                <i class="fas fa-star text-xs text-main"></i>
                امتیاز رضایت:
            </label>
            <div class="flex space-x-1">
                @for($i = 1; $i <= 5; $i++)
                    <span wire:click="rate({{ $i }})"
                          class="cursor-pointer text-3xl"
                          style="color: {{ $satisfactionScore >= $i ? '#FFD700' : '#ccc' }};">
                &#9733;
            </span>
                @endfor
            </div>
            @error('satisfactionScore')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
            <div class="m-4 w-full md:w-2/3 mx-1">
                <label for="satisfactionComment" class="block mb-2">
                    <i class="fa fa-edit text-xs text-main"></i>
                    توضیحات شما:
                </label>
                <textarea id="satisfactionComment" wire:model="satisfactionComment"
                          class="w-full border border-gray-300 text-gray-500 rounded-md p-2"
                          rows="3" placeholder="توضیحات خود را وارد کنید"></textarea>
                @error('satisfactionComment')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        <div class="m-4">
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="bg-main-mode text-white py-2 px-4 rounded-md mt-4">
                <span wire:loading.remove wire:target="submitRating">ثبت امتیاز</span>
                <span wire:loading wire:target="submitRating"><i
                        class="fas fa-spinner fa-spin"></i> در حال ارسال...</span>
            </button>
        </div>
    </form>
@endif
