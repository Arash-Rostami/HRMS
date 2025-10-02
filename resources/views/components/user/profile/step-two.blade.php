<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly pt-6" x-ref="step2">
    <!-- ID Card Number -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="id_card_number">
            <i class="fa fa-address-card ml-2"></i>شماره کارت ملی
        </label>
        <input wire:model="idCardNumber" type="text" id="id_card_number" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('idCardNumber') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- ID Booklet Number -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="id_booklet_number">
            <i class="fa fa-address-book ml-2"></i>شماره شناسنامه
        </label>
        <input wire:model="idBookletNumber" type="text" id="id_booklet_number" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('idBookletNumber') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Gender -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="gender">
            <i class="fa fa-venus-mars ml-2"></i>جنسیت
        </label>
        <select wire:model="gender" id="gender" required dir="rtl"
                class="block w-full text-sm appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pl-8 pr-3 border rounded py-2 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Select Gender</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
        </select>
        @error('gender') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Birthdate -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="birthYear">
            <i class="fa fa-birthday-cake ml-2"></i>تارخ تولد
        </label>
        <div class="flex">
            <!-- Year select -->
            <select wire:model="birthYear" id="birthYear" required
                    class="shadow appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pr-3 border rounded ml-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm pl-2">
                <option value="">سال</option>
                @for ($year = 1330; $year <= $thisYear ; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>

            <!-- Month select -->
            <select wire:model="birthMonth" id="birthMonth" required
                    class="shadow appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pl-8 pr-3 border rounded ml-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm text-center">
                <option value="">ماه</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}">{{ $month }}</option>
                @endfor
            </select>

            <!-- Day select -->
            <select wire:model="birthDay" id="birthDay" required
                    class="shadow appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pl-8 pr-3 border rounded text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm text-center">
                <option value="">روز</option>
                @for ($day = 1; $day <= 31; $day++)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endfor
            </select>
        </div>
        @foreach (['birthYear', 'birthMonth', 'birthDay'] as $field)
            @error($field)
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        @endforeach
    </div>

</div>

<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly">
    <!-- Marital Status -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="marital_status">
            <i class="fa fa-ring ml-2"></i>وضعبت تاهل
        </label>
        <select wire:model="maritalStatus" id="marital_status" required
                class="block text-sm appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pl-8 pr-3 w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">انتخاب کنید</option>
            <option value="married">متاهل</option>
            <option value="single">مجرد</option>
        </select>
        @error('maritalStatus') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Number of Children -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="number_of_children">
            <i class="fa fa-child ml-2"></i>تعداد فرزند
        </label>
        <input wire:model.defer="numberOfChildren" type="number" id="number_of_children"  value="0" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('numberOfChildren') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Degree -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="degree">
            <i class="fa fa-graduation-cap ml-2"></i>مدرک تحصیلی
        </label>
        <select wire:model="degree" id="degree" required
                class="block text-sm appearance-none bg-no-repeat bg-left bg-[url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 4 5&quot;><path fill=&quot;#000&quot; d=&quot;M2 5L0 0h4z&quot/></svg>')] pl-8 pr-3 w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">انتخاب کنید</option>
            <option value="undergraduate"> دیپلم یا کاردانی</option>
            <option value="graduate">کارشناسی</option>
            <option value="postgraduate">کارشناسی ارشد یا دکترا</option>
        </select>
        @error('degree') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Field -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="field">
            <i class="fa fa-laptop-code ml-2"></i>گرایش
        </label>
        <input wire:model="field" type="text" id="field" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('field') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
</div>

<div class="flex flex-wrap flex-col md:flex-row justify-content-evenly">
    <!-- Landline -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="landline">
            <i class="fa fa-phone-alt ml-2"></i>شماره تلفن (منزل)
        </label>
        <input wire:model="landline" type="text" id="landline"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('landline') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Cellphone -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="cellphone">
            <i class="fa fa-mobile-alt ml-2"></i>شماره تلفن (همراه)
        </label>
        <input wire:model="cellphone" type="text" id="cellphone" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('cellphone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Emergency Phone -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="emergency_phone">
            <i class="fa fa-phone ml-2"></i>شماره تلفن (ضروری)
        </label>
        <input wire:model="emergencyPhone" type="text" id="emergency_phone" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('emergencyPhone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Emergency Relationship -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="emergency_relationship">
            <i class="fa fa-users ml-2"></i>نسبت فرد (ضروری)
        </label>
        <input wire:model="emergencyRelationship" type="text" id="emergency_relationship" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('emergencyRelationship') <p
            class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
</div>

<div
    class="flex flex-wrap flex-col md:flex-row justify-content-evenly border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-6">
    <!--Licence plate number -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for=license_plate>
            <i class="fas fa-car ml-2"></i>شماره پلاک
        </label>
        <input wire:model="licensePlate" type="text" id="license_plate"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rtl-direction"/>
        @error('licensePlate') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Zip Code -->
    <div class="mb-4 md:w-1/5">
        <label class="block mb-2" for="zip_code">
            <i class="fa fa-map-marker-alt ml-2"></i>کد پستی
        </label>
        <input wire:model="zipCode" type="text" id="zip_code" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        @error('zipCode') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!-- Address -->
    <div class="mb-4 md:w-1/5">
        <label class="block  mb-2" for="address">
            <i class="fa fa-home ml-2"></i>آدرس
        </label>
        <textarea wire:model="address" id="address" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        @error('address') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
    <!--Accessibility-->
    <div class="mb-4 md:w-1/5">
        <label class="block  mb-2" for="accessibility">
            <i class="fas fa-wheelchair ml-2"></i>نیاز خاص (ویژه)
        </label>
        <textarea wire:model="accessibility" type="text" id="accessibility"
                  placeholder="visual | auditory | motor | cognitive | ..."
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        @error('accessibility') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
    </div>
</div>
