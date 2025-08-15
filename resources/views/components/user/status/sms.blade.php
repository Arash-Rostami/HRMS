<div class="absolute bottom-0 left-0 right-0 top-0 bg-opacity-75 flex justify-center items-center backdrop-blur-sm"
     title="پیامتان در باکس وارد نمایید"
     x-transition
     x-show="openSMSModal"
     @click.outside="openSMSModal = false">
    <div
        @class([
             'bg-white shadow-2xl w-3/4 md:w-1/2 rounded-lg p-4',
             'bg-[#1F2937]' => isDarkMode(),
             ])
        >
        <div class="text-center">
            <label for="smsMessage" class="sr-only">SMS Message</label>
            <textarea
                id="smsMessage"
                name="message"
                rows="10"
                x-bind:placeholder="message"
                class="mx-auto mt-12 w-full md:w-2/3 h-48 rounded-lg p-4 border-main text-center text-main"></textarea>
        </div>
        <div class="mt-4 flex justify-center space-x-4">
            <input type="hidden" name="receptor" x-model="receptor" x-ref="receptor" />
            <button class="bg-red-500 text-white px-2 py-1 rounded-md" @click="openSMSModal = false">لغو</button>
            <button class="bg-green-500 text-white px-2 py-1 rounded-md" @click="sendSMS()">ارسال</button>
        </div>
    </div>
</div>
