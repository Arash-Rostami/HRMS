@forelse ($questions as $question)
    <div class="flex flex-col-reverse md:flex-row rtl-direction persol-farsi-font mb-3">
        {{--Query & Response section--}}
        <div class="w-full md:w-[60%] text-justify flex flex-col">
            {{--Q--}}
            <div class="w-full mb-2">
                    <span class="block mb-2">
                        <i class="fas fa-question-circle text-main"></i>
                        پرسش:
                    </span>

                <p>{!!  $question->content !!}</p>
            </div>
            {{--R--}}
            <div class="w-full mt-2">
                <label for="suggestion-description" class="block mb-4">
                    <i class="fa fa-edit text-xs text-main"></i>
                    پاسخ:
                </label>
                <textarea wire:model="response"
                          placeholder="* به پاسخهایی که موجب بهبود در سازمان شوند، جایزه تعلق خواهد گرفت."
                          class="w-full border border-gray-300 text-gray-500 rounded-md p-2 h-48"></textarea>
                @error('response')
                <span class="text-red-500">{{ $message }}</span>
                @enderror

                <div class="w-full md:w-1/4 pt-2">
                    <button type="submit"
                            class="px-4 py-2 mx-auto md:mx-0 block bg-main-mode text-white rounded-md"
                            title="➡️ ارسال"
                            wire:loading.class.remove="bg-main-mode"
                            wire:loading.class="bg-red-700"
                            wire:click.prevent="submitResponse({{ $question->id }})"
                            wire:loading.attr="disabled"
                            wire:target="submitResponse({{ $question->id }})">
                                <span wire:loading.remove wire:target="submitResponse({{ $question->id }})">
                                    <i class="fas fa-envelope"></i>
                                </span>
                        <span wire:loading wire:target="submitResponse({{ $question->id }})">
                                    <i class="fas fa-spinner fa-spin"></i> ارسال...
                                </span>
                    </button>
                </div>

            </div>
        </div>

        {{--Image section--}}
        <div class="w-full mb-3 md:mb-0 md:w-1/3 mr-auto flex items-center justify-center">
            <img src="/{{ $question->image ?? 'img/user/QoM.jpg' }}"
                 alt="QoMPicture"
                 class="w-auto h-auto mx-auto my-auto rounded-lg">
        </div>
    </div>
@empty
    <p>هیچ پرسشی در این بازه موجود نیست!</p>
@endforelse

<audio id="login-audio" class="hidden">
    <source src="/audio/login.mp3" type="audio/mpeg">
</audio>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let audioElement = document.getElementById("login-audio");
        if (audioElement) {
            let lastAudioPlay = localStorage.getItem('lastAudioPlay');
            let now = Date.now();
            let twoDaysInMs = 2 * 24 * 60 * 60 * 1000;

            if (lastAudioPlay === null || (now - parseInt(lastAudioPlay, 10)) >= twoDaysInMs) {
                audioElement.play().catch(console.error);
                localStorage.setItem('lastAudioPlay', now.toString());
            }
        }
    });
</script>
