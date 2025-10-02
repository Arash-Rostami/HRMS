<?php

namespace App\Http\Livewire\Profile;

trait WithValidation
{
    protected $rules = [
        'personnelId' => 'nullable|string|max:255|englishChar',
        'gender' => 'required|in:female,male',
        'employmentType' => 'nullable|in:fulltime,parttime,contract',
        'maritalStatus' => 'required|in:married,single',
        'numberOfChildren' => 'required|integer|min:0',
        'employmentStatus' => 'nullable|in:probational,working,terminated',
        'idCardNumber' => 'nullable|string|max:255|englishChar',
        'idBookletNumber' => 'required|string|max:255|englishChar',
        'degree' => 'required|in:undergraduate,graduate,postgraduate',
        'field' => 'required|string|max:255|englishChar',
        'birthYear' => 'required|integer|required_with:birthMonth,birthDay',
        'birthMonth' => 'required|integer|min:1|max:12|required_with:birthYear,birthDay',
        'birthDay' => 'required|integer|min:1|max:31|required_with:birthYear,birthMonth',
        'landline' => 'nullable|string|max:255|englishChar|regex:/^(?!00)[^+].*$/',
        'cellphone' => 'required|string|max:255|englishChar|regex:/^(?!00)[^+].*$/',
        'licensePlate' => 'nullable|string',
        'zipCode' => 'required|string|max:255|englishChar',
        'address' => 'required|string',
        'accessibility' => 'nullable|string',
        'department' => 'nullable|in:HR,AS,PR,VC,FP,CM,CP,AC,PS,WP,SA,MK,PO,CH,SP,CX,BD,MG,MA,HC,SO,PERSORE',
        'position' => 'nullable|in:manager,supervisor,senior,expert,employee',
        'insurance' => 'required|string|max:255|englishChar',
        'emergencyPhone' => 'required|string|max:255|englishChar',
        'emergencyRelationship' => 'required|string|max:255|englishChar',
        'startYear' => 'nullable|integer',
        'startMonth' => 'nullable|integer|min:1|max:12',
        'startDay' => 'nullable|integer|min:1|max:31',
        'workExperience' => 'required|string|englishChar',
        'interests' => 'nullable|string|englishChar',
        'favoriteColors' => 'nullable|string|max:255|englishChar',
    ];


    protected $messages = [
        'personnelId.string' => 'فرمت کد پرسنلی صحیح نمی‌باشد. لطفاً مجدداً بررسی کنید.',
        'personnelId.max' => 'کد پرسنلی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'personnelId.englishChar' => 'لطفاً برای کد پرسنلی فقط از حروف و اعداد انگلیسی استفاده نمایید.',

        'gender.required' => 'انتخاب جنسیت الزامی می‌باشد.',
        'gender.in' => 'مقدار انتخاب شده برای جنسیت معتبر نیست.',

        'employmentType.in' => 'نوع قرارداد انتخاب شده معتبر نمی‌باشد.',

        'maritalStatus.required' => 'انتخاب وضعیت تأهل الزامی می‌باشد.',
        'maritalStatus.in' => 'وضعیت تأهل انتخاب شده معتبر نیست.',

        'numberOfChildren.required' => 'وارد کردن تعداد فرزندان الزامی است.',
        'numberOfChildren.integer' => 'لطفاً تعداد فرزندان را به صورت عدد صحیح وارد کنید.',
        'numberOfChildren.min' => 'تعداد فرزندان نمی‌تواند یک عدد منفی باشد.',


        'employmentStatus.in' => 'وضعیت اشتغال انتخاب شده معتبر نمی‌باشد.',

        'idCardNumber.string' => 'فرمت کد ملی صحیح نمی‌باشد.',
        'idCardNumber.max' => 'کد ملی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'idCardNumber.englishChar' => 'لطفاً برای کد ملی فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'idBookletNumber.required' => 'وارد کردن شماره شناسنامه الزامی است.',
        'idBookletNumber.string' => 'فرمت شماره شناسنامه صحیح نمی‌باشد.',
        'idBookletNumber.max' => 'شماره شناسنامه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'idBookletNumber.englishChar' => 'لطفاً برای شماره شناسنامه فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'degree.required' => 'انتخاب مقطع تحصیلی الزامی می‌باشد.',
        'degree.in' => 'مقطع تحصیلی انتخاب شده معتبر نیست.',

        'field.required' => 'وارد کردن رشته تحصیلی الزامی است.',
        'field.string' => 'فرمت رشته تحصیلی صحیح نمی‌باشد.',
        'field.max' => 'رشته تحصیلی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'field.englishChar' => 'لطفاً برای رشته تحصیلی فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'birthYear.required' => 'وارد کردن سال تولد الزامی است.',
        'birthYear.integer' => 'لطفاً سال تولد را به صورت عدد صحیح وارد کنید.',
        'birthYear.required_with' => 'لطفاً تاریخ تولد را به صورت کامل (روز، ماه و سال) وارد نمایید.',

        'birthMonth.required' => 'وارد کردن ماه تولد الزامی است.',
        'birthMonth.integer' => 'لطفاً ماه تولد را به صورت عدد صحیح وارد کنید.',
        'birthMonth.min' => 'مقدار ماه تولد نمی‌تواند کمتر از ۱ باشد.',
        'birthMonth.max' => 'مقدار ماه تولد نمی‌تواند بیشتر از ۱۲ باشد.',
        'birthMonth.required_with' => 'لطفاً تاریخ تولد را به صورت کامل (روز، ماه و سال) وارد نمایید.',

        'birthDay.required' => 'وارد کردن روز تولد الزامی است.',
        'birthDay.integer' => 'لطفاً روز تولد را به صورت عدد صحیح وارد کنید.',
        'birthDay.min' => 'مقدار روز تولد نمی‌تواند کمتر از ۱ باشد.',
        'birthDay.max' => 'مقدار روز تولد نمی‌تواند بیشتر از ۳۱ باشد.',
        'birthDay.required_with' => 'لطفاً تاریخ تولد را به صورت کامل (روز، ماه و سال) وارد نمایید.',

        'landline.string' => 'فرمت تلفن ثابت صحیح نمی‌باشد.',
        'landline.max' => 'تلفن ثابت نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'landline.englishChar' => 'لطفاً برای تلفن ثابت فقط از اعداد انگلیسی استفاده کنید.',
        'landline.regex' => 'فرمت تلفن ثابت وارد شده صحیح نمی‌باشد.',

        'cellphone.required' => 'وارد کردن شماره تلفن همراه الزامی است.',
        'cellphone.string' => 'فرمت شماره تلفن همراه صحیح نمی‌باشد.',
        'cellphone.max' => 'شماره تلفن همراه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'cellphone.englishChar' => 'لطفاً برای شماره تلفن همراه فقط از اعداد انگلیسی استفاده کنید.',
        'cellphone.regex' => 'فرمت شماره تلفن همراه وارد شده صحیح نمی‌باشد.',

        'licensePlate.string' => 'فرمت شماره پلاک صحیح نمی‌باشد.',

        'zipCode.required' => 'وارد کردن کد پستی الزامی است.',
        'zipCode.string' => 'فرمت کد پستی صحیح نمی‌باشد.',
        'zipCode.max' => 'کد پستی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'zipCode.englishChar' => 'لطفاً برای کد پستی فقط از اعداد انگلیسی استفاده کنید.',

        'address.required' => 'وارد کردن آدرس الزامی است.',
        'address.string' => 'فرمت آدرس صحیح نمی‌باشد.',

        'accessibility.string' => 'فرمت دسترسی صحیح نمی‌باشد.',

        'department.in' => 'دپارتمان انتخاب شده معتبر نیست.',
        'position.in' => 'سمت سازمانی انتخاب شده معتبر نیست.',

        'insurance.required' => 'وارد کردن شماره بیمه الزامی است.',
        'insurance.string' => 'فرمت شماره بیمه صحیح نمی‌باشد.',
        'insurance.max' => 'شماره بیمه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'insurance.englishChar' => 'لطفاً برای شماره بیمه فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'emergencyPhone.required' => 'وارد کردن تلفن تماس ضروری الزامی است.',
        'emergencyPhone.string' => 'فرمت تلفن تماس ضروری صحیح نمی‌باشد.',
        'emergencyPhone.max' => 'تلفن تماس ضروری نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'emergencyPhone.englishChar' => 'لطفاً برای تلفن تماس ضروری فقط از اعداد انگلیسی استفاده کنید.',

        'emergencyRelationship.required' => 'وارد کردن نسبت تماس ضروری الزامی است.',
        'emergencyRelationship.string' => 'فرمت نسبت تماس ضروری صحیح نمی‌باشد.',
        'emergencyRelationship.max' => 'نسبت تماس ضروری نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'emergencyRelationship.englishChar' => 'لطفاً برای نسبت تماس ضروری فقط از حروف انگلیسی استفاده کنید.',

        'startYear.integer' => 'لطفاً سال شروع به کار را به صورت عدد صحیح وارد کنید.',

        'startMonth.integer' => 'لطفاً ماه شروع به کار را به صورت عدد صحیح وارد کنید.',
        'startMonth.min' => 'مقدار ماه شروع به کار نمی‌تواند کمتر از ۱ باشد.',
        'startMonth.max' => 'مقدار ماه شروع به کار نمی‌تواند بیشتر از ۱۲ باشد.',

        'startDay.integer' => 'لطفاً روز شروع به کار را به صورت عدد صحیح وارد کنید.',
        'startDay.min' => 'مقدار روز شروع به کار نمی‌تواند کمتر از ۱ باشد.',
        'startDay.max' => 'مقدار روز شروع به کار نمی‌تواند بیشتر از ۳۱ باشد.',

        'workExperience.required' => 'وارد کردن سوابق کاری الزامی است.',
        'workExperience.string' => 'فرمت سوابق کاری صحیح نمی‌باشد.',
        'workExperience.englishChar' => 'لطفاً برای سوابق کاری فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'interests.string' => 'فرمت علایق صحیح نمی‌باشد.',
        'interests.englishChar' => 'لطفاً برای فیلد علایق فقط از حروف و اعداد انگلیسی استفاده کنید.',

        'favoriteColors.string' => 'فرمت رنگ‌های مورد علاقه صحیح نمی‌باشد.',
        'favoriteColors.max' => 'ورودی رنگ‌های مورد علاقه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        'favoriteColors.englishChar' => 'لطفاً برای رنگ‌های مورد علاقه فقط از حروف انگلیسی استفاده کنید.',
    ];
}
