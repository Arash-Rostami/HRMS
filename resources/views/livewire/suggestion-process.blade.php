<div class="mx-auto persol-farsi-font rtl-direction">
    <div
        x-data="{
        open:false,
        selfFill: @entangle('suggestion.selfFill') || null,
        response: @entangle('suggestion.response') || null,
        suggestionBox:  @entangle('suggestion.selected') || false,
        selectedRecord: @entangle('suggestion.selectedRecord'),
        typeWriterFlag: @entangle('suggestion.typeWriterFlag'),
        activeTab: 'new',
        rules : {'simplify': 'کار را ساده کن!','prioritize': 'کار فردا را به امروز بیانداز!','collaborate': 'کارِ خوب، نتیجه همکاریِ عالی است!','boost': 'فروشِ بیشتر یعنی من کارم را خوب انجام دادم!'},
        purposes: {'cost': 'کاهش هزینه','time': 'کاهش زمان انجام کار','workload': 'کاهش حجم کار','sales': 'افزایش فروش','profit': 'افزایش سود'},
        feedbackResponse:{'agree' : 'تأیید کل پیشنهاد','neutral': 'تأیید بخشی از پیشنهاد','disagree' : 'رد کل پیشنهاد','incomplete' : 'نیاز به تکمیل یا بازبینی','unknown' : '❓'},
        finalResponse:{'agree' : 'تأیید کل پیشنهاد','neutral': 'تأیید بخشی از پیشنهاد','disagree' : 'رد کل پیشنهاد','under_review' :'نیازمند بازبینی' },
        allDepsSelected: {'HR':'منابع انسانی','AS':'اداری و پشتیبانی','PR':'روابط عمومی و مسئولیت اجتماعی','VC':'سرمایه‌گذاری','FP':'بازرگانی مواد غذایی','CM':'بازرگانی (واردات و خرید داخلی)','CP':'فروش فراورده‌های سلولزی','AC':'مالی','PS':'برنامه‌ریزی و بهبود سیستم‌ها','WP':'فروش فراورده های چوب','SA':'واحد(های) فروش','MK':'واحد بازاریابی','PO':'فروش محصولات پلیمری','CH':'فروش فراورده های شیمیایی و پلیمری','SP':'پلتفرم فروش','CX':'بازرگانی (صادرات)','BD':'توسعه کسب و کار','MG':'مدیریت'},
       typeWriter() {
            let description = $refs.description;
            description.textContent = this.selectedRecord.description || this.selectedRecord.comments ||
                'For a reason unknown, an error occurred; please contact the developer concerned!';
            let opacity = 0;
            function animate() {
                opacity += 0.015;
                description.style.opacity = opacity;
                if (opacity < 1) {
                    requestAnimationFrame(animate);
                }
            }
            animate();
        }
    }"
        x-init="$watch('suggestionBox', (value) => {
                    if (value === true) {
                            typeWriter();
                        }
                    });

                    $watch('typeWriterFlag', () => {
                         this.typeWriter();
                         })

                $watch('selectedRecord', (newVal, oldVal) => {
                    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
                        typeWriter();
                    }
    });">
        {{-- Tab selector--}}
        @include('livewire.suggestion.tab-selector')

        {{-- Tab content--}}
        <div class="p-0 md:p-3">
            {{-- Tab for creation--}}
            @include('livewire.suggestion.tab-creation')

            {{-- Tab for log--}}
            @include('livewire.suggestion.tab-log')

            {{--confirmation box or modal--}}
            @include('livewire.suggestion.confirmation-box')
        </div>
    </div>
</div>
