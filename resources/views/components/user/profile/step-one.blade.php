<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly" x-ref="step1">
    <!-- Personnel ID -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="personnel_id">
            <i class="fa fa-id-card-alt ml-2"></i>کد پرسنلی
        </label>
        <input wire:model.lazy="personnelId" type="text" id="personnel_id" disabled
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('personnelId') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Email -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="personnel_id">
            <i class="fa fa-envelope ml-2"></i>ایمیل
        </label>
        <input wire:model.lazy="email" type="text" id="email" disabled
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
    </div>
    <!-- Department -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="department">
            <i class="fa fa-building ml-2"></i>واحد
        </label>
        <select wire:model.lazy="department" id="department" disabled
                class="block appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">انتخاب کنید</option>
            @foreach($departmentsList as $code => $name)
                <option value="{{ $code }}">{{ $code }}</option>
            @endforeach
        </select>
        @error('department') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Employment Type -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="employment_type">
            <i class="fa fa-user-clock ml-2"></i>نوع استخدام
        </label>
        <select wire:model.lazy="employmentType" id="employment_type" disabled
                class="block appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">انتخاب کنید</option>
            <option value="fulltime">تمام وقت</option>
            <option value="parttime">پاره وقت</option>
            <option value="contract">قراردادی</option>
        </select>
        @error('employmentType') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
</div>
<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly">
    <!-- Employment Status -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="employment_status">
            <i class="fa fa-user-check ml-2"></i>وضعیت استخدام
        </label>
        <select wire:model.lazy="employmentStatus" id="employment_status" disabled
                class="block appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">نتخاب کنید</option>
            <option value="probational">آزمایشی</option>
            <option value="working">در حال کار</option>
            <option value="terminated">خاتمه یافته</option>
        </select>
        @error('employmentStatus') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Position -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="position">
            <i class="fa fa-user-tie ml-2"></i>سمت
        </label>
        <select wire:model.lazy="position" id="position" disabled
                class="block appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">انتخاب کنید</option>
            <option value="manager">مدیر</option>
            <option value="supervisor">سرپرست</option>
            <option value="senior">ارشد</option>
            <option value="expert">کارشناس</option>
            <option value="employee">کارمند</option>
        </select>
        @error('position') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Insurance -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="insurance">
            <i class="fa fa-shield-alt ml-2"></i> شماره بیمه
        </label>
        <input wire:model.lazy="insurance" type="text" id="insurance" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('insurance') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Work Experience -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="work_experience">
            <i class="fa fa-briefcase ml-2"></i>مدت سابقه
        </label>
        <input wire:model.lazy="workExperience" type="text" id="work_experience" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('workExperience') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
</div>
<div
    class="flex flex-wrap flex-col md:flex-row justify-content-evenly border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-6">
    <!-- Start Date -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="startDate">
            <i class="fa fa-calendar-alt ml-2"></i>تاریخ شروع
        </label>
        <div class="flex">
            <!-- Year select -->
            <select wire:model.lazy="startYear" id="startYear" disabled
                    class="shadow appearance-none border rounded ml-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-center">
                <option value="">سال</option>
                @for ($year = 1375; $year <= $thisYear; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>

            <!-- Month select -->
            <select wire:model.lazy="startMonth" id="startMonth" disabled
                    class="shadow appearance-none border rounded ml-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-center">
                <option value="">ماه</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endfor
            </select>

            <!-- Day select -->
            <select wire:model.lazy="startDay" id="startDay" disabled
                    class="shadow appearance-none border rounded text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-center">
                <option value="">روز</option>
                @for ($day = 1; $day <= 31; $day++)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endfor
            </select>
        </div>

        @foreach (['startYear', 'startMonth', 'startDay'] as $field)
            @error($field)
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        @endforeach
    </div>

    <div class="mb-4 md:w-1/5"></div>
    <div class="mb-4 md:w-1/5"></div>
    <div class="mb-4 md:w-1/5"></div>
</div>
