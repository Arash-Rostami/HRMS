{{-- Check if there is no profile record --}}
@if (!isset($profile))
    <div class="flex flex-col items-center justify-center w-full mx-auto p-10">
        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
        <h1 class="text-red-500 text-center text-xl font-bold mt-2 mb-4">
            Whoops! Looks like you're missing a profile.
            <br>
            Please ask the admin to create one for you.
        </h1>
    </div>
@else
    <div class="flex flex-col md:flex-row w-full mx-auto p-10">
        {{--  Stepper for desktop view--}}
        <div class="hidden md:block md:w-[15%]">
            <ol class="relative text-gray-500 border-l border-gray-500">
                <li class="mb-12 ml-6 ">
        <span
            title="{{ $stepCompletionStatus[1] ?  'complete - employment info': 'take me to step 1 - employment info' }}"
            class="absolute cursor-pointer flex items-center justify-center w-8 h-8 rounded-full -left-4 ring-4 {{ $stepCompletionStatus[1] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step1.scrollIntoView({ behavior: 'smooth' }); ">
            <i class="fas fa-briefcase text-white @if ( isDarkMode()) text-gray-500 @endif"></i>
        </span>
                    <h3 class="font-medium leading-tight">Step 1:</h3>
                    <p class="text-sm">Employment Info</p>
                </li>
                <li class="mb-12 ml-6">
        <span
            title=" {{ $stepCompletionStatus[2] ?  'complete - personal info' : 'take me to step 2 - personal info'}}"
            class="absolute cursor-pointer flex items-center justify-center w-8 h-8 rounded-full -left-4 ring-4 {{ $stepCompletionStatus[2] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step2.scrollIntoView({ behavior: 'smooth' }); ">
            <i class="fas fa-id-card text-white @if ( isDarkMode()) text-gray-500 @endif"></i>
        </span>
                    <h3 class="font-medium leading-tight">Step 2:</h3>
                    <p class="text-sm">Personal Info</p>
                </li>
                <li class="mb-12 ml-6">
        <span
            title="{{ $stepCompletionStatus[3] ?  'complete - extra info' : 'take me to step 3 - extra info'}}"
            class="absolute cursor-pointer bottom-1 flex items-center justify-center w-8 h-8 rounded-full -left-4 ring-4 {{ $stepCompletionStatus[3] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step3.scrollIntoView({ behavior: 'smooth' }); ">
            <svg class="w-3.5 h-3.5 text-white @if ( isDarkMode()) text-gray-500 @endif" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                <path
                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
            </svg>
        </span>
                    <h3 class="font-medium leading-tight">Step 3:</h3>
                    <p class="text-sm">Extra info</p>
                </li>
            </ol>
        </div>
        {{--    Stepper for cellphone view--}}
        <div class="flex w-full mx-auto md:hidden pb-2 mb-4 w-full justify-center">
            <ol class="flex w-full items-center">
                <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-300 after:inline-block dark:after:border-gray-500">
        <span
            title="{{ $stepCompletionStatus[1] ?  'complete - employment info': 'take me to step 1 - employment info' }}"
            class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[1] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step1.scrollIntoView({ behavior: 'smooth' }); ">
            <i class="fas fa-briefcase"></i>
        </span>
                </li>
                <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:inline-block dark:after:border-gray-500">
        <span
            title=" {{ $stepCompletionStatus[2] ?  'complete - personal info' : 'take me to step 2 - personal info'}}"
            class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[2] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step2.scrollIntoView({ behavior: 'smooth' }); ">
            <i class="fas fa-id-card"></i>
        </span>
                </li>
                <li class="flex items-center">
        <span
            title="{{ $stepCompletionStatus[3] ?  'complete - extra info' : 'take me to step 3 - extra info'}}"
            class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[3] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
            x-on:click="$refs.step3.scrollIntoView({ behavior: 'smooth' }); ">
                <svg class="w-3.5 h-3.5" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                </svg>
        </span>
                </li>
            </ol>
        </div>
        {{--    form--}}
        <div class="w-full md:w-[85%]">
            <h5 class="mb-8 text-justify">Please fill out your profile information as carefully & completely as
                possible.</h5>
            <!-- Form -->
            <form wire:submit.prevent class="profile-form">
                {{--    start of step one --}}
                <div class="flex flex-wrap flex-col md:flex-row justify-content-evenly" x-ref="step1">
                    <!-- Personnel ID -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="personnel_id">
                            <i class="fa fa-id-card-alt mr-2"></i>Personnel ID
                        </label>
                        <input wire:model.lazy="personnelId" type="text" id="personnel_id" disabled
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('personnelId') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Email -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="personnel_id">
                            <i class="fa fa-envelope mr-2"></i>Email
                        </label>
                        <input wire:model.lazy="email" type="text" id="email" disabled
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                    </div>
                    <!-- Department -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="department">
                            <i class="fa fa-building mr-2"></i>Department
                        </label>
                        <select wire:model.lazy="department" id="department" disabled
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Department</option>
                            <option value="MG">MG</option>
                            <option value="HR">HR</option>
                            <option value="MA">MA</option>
                            <option value="AS">AS</option>
                            <option value="CM">CM</option>
                            <option value="CP">CP</option>
                            <option value="AC">AC</option>
                            <option value="PS">PS</option>
                            <option value="WP">WP</option>
                            <option value="MK">MK</option>
                            <option value="CH">CH</option>
                            <option value="SP">SP</option>
                            <option value="CX">CX</option>
                            <option value="BD">BD</option>
                            <option value="PERSORE">PERSORE</option>
                        </select>
                        @error('department') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Employment Type -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="employment_type">
                            <i class="fa fa-user-clock mr-2"></i>Employment Type
                        </label>
                        <select wire:model.lazy="employmentType" id="employment_type" disabled
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Employment Type</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                            <option value="contract">Contract</option>
                        </select>
                        @error('employmentType') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-wrap flex-col md:flex-row justify-content-evenly">
                    <!-- Employment Status -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="employment_status">
                            <i class="fa fa-user-check mr-2"></i>Employment Status
                        </label>
                        <select wire:model.lazy="employmentStatus" id="employment_status" disabled
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Employment Status</option>
                            <option value="probational">Probational</option>
                            <option value="working">Working</option>
                            <option value="terminated">Terminated</option>
                        </select>
                        @error('employmentStatus') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Position -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="position">
                            <i class="fa fa-user-tie mr-2"></i>Position
                        </label>
                        <select wire:model.lazy="position" id="position" disabled
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Position</option>
                            <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="senior">Senior</option>
                            <option value="expert">Expert</option>
                            <option value="employee">Employee</option>
                        </select>
                        @error('position') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Insurance -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="insurance">
                            <i class="fa fa-shield-alt mr-2"></i>Insurance Number
                        </label>
                        <input wire:model.lazy="insurance" type="text" id="insurance" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('insurance') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Work Experience -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="work_experience">
                            <i class="fa fa-briefcase mr-2"></i>Work Experience
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
                        <label class="block text-xs mb-2" for="startDate">
                            <i class="fa fa-calendar-alt mr-2"></i>Start Date
                        </label>
                        <div class="flex">
                            <!-- Year select -->
                            <select wire:model.lazy="startYear" id="startYear" disabled
                                    class="shadow appearance-none border rounded mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-sm pl-2">
                                <option value="">Y</option>
                                @for ($year = 1375; $year <= \Morilog\Jalali\Jalalian::now()->getYear(); $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>

                            <!-- Month select -->
                            <select wire:model.lazy="startMonth" id="startMonth" disabled
                                    class="shadow appearance-none border rounded mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-sm text-center">
                                <option value="">M</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>

                            <!-- Day select -->
                            <select wire:model.lazy="startDay" id="startDay" disabled
                                    class="shadow appearance-none border rounded text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-8 text-sm text-center">
                                <option value="">D</option>
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
                {{-- end of step one--}}
                {{--start of step two--}}
                <div class="flex flex-wrap flex-col md:flex-row justify-content-evenly pt-6" x-ref="step2">
                    <!-- ID Card Number -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="id_card_number">
                            <i class="fa fa-address-card mr-2"></i>ID Card Number
                        </label>
                        <input wire:model="idCardNumber" type="text" id="id_card_number" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('idCardNumber') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- ID Booklet Number -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="id_booklet_number">
                            <i class="fa fa-address-book mr-2"></i>ID Booklet Number
                        </label>
                        <input wire:model="idBookletNumber" type="text" id="id_booklet_number" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('idBookletNumber') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Gender -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="gender">
                            <i class="fa fa-venus-mars mr-2"></i>Gender
                        </label>
                        <select wire:model="gender" id="gender" required
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Gender</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Birthdate -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="birthYear">
                            <i class="fa fa-birthday-cake mr-2"></i>Birthdate
                        </label>
                        <div class="flex">
                            <!-- Year select -->
                            <select wire:model="birthYear" id="birthYear" required
                                    class="shadow appearance-none border rounded mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm pl-2">
                                <option value="">Y</option>
                                @for ($year = 1330; $year <= \Morilog\Jalali\Jalalian::now()->getYear(); $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>

                            <!-- Month select -->
                            <select wire:model="birthMonth" id="birthMonth" required
                                    class="shadow appearance-none border rounded mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm text-center">
                                <option value="">M</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>

                            <!-- Day select -->
                            <select wire:model="birthDay" id="birthDay" required
                                    class="shadow appearance-none border rounded text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-8 w-full text-sm text-center">
                                <option value="">D</option>
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
                        <label class="block text-xs mb-2" for="marital_status">
                            <i class="fa fa-ring mr-2"></i>Marital Status
                        </label>
                        <select wire:model="maritalStatus" id="marital_status" required
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Marital Status</option>
                            <option value="married">Married</option>
                            <option value="single">Single</option>
                        </select>
                        @error('maritalStatus') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Number of Children -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="number_of_children">
                            <i class="fa fa-child mr-2"></i>Number of Children
                        </label>
                        <input wire:model="numberOfChildren" type="number" id="number_of_children" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('numberOfChildren') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Degree -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="degree">
                            <i class="fa fa-graduation-cap mr-2"></i>Degree
                        </label>
                        <select wire:model="degree" id="degree" required
                                class="block text-sm appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Degree</option>
                            <option value="undergraduate">Undergraduate</option>
                            <option value="graduate">Graduate</option>
                            <option value="postgraduate">Postgraduate</option>
                        </select>
                        @error('degree') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Field -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="field">
                            <i class="fa fa-laptop-code mr-2"></i>Field
                        </label>
                        <input wire:model="field" type="text" id="field" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('field') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-wrap flex-col md:flex-row justify-content-evenly">
                    <!-- Landline -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="landline">
                            <i class="fa fa-phone-alt mr-2"></i>Landline
                        </label>
                        <input wire:model="landline" type="text" id="landline"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('landline') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Cellphone -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="cellphone">
                            <i class="fa fa-mobile-alt mr-2"></i>Cellphone
                        </label>
                        <input wire:model="cellphone" type="text" id="cellphone" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('cellphone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Emergency Phone -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="emergency_phone">
                            <i class="fa fa-phone mr-2"></i>Emergency Phone
                        </label>
                        <input wire:model="emergencyPhone" type="text" id="emergency_phone" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('emergencyPhone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Emergency Relationship -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="emergency_relationship">
                            <i class="fa fa-users mr-2"></i>Emergency Relationship
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
                        <label class="block text-xs mb-2" for=license_plate>
                            <i class="fas fa-car mr-2"></i>License plate #
                        </label>
                        <input wire:model="licensePlate" type="text" id="license_plate"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline rtl-direction"/>
                        @error('licensePlate') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Zip Code -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="zip_code">
                            <i class="fa fa-map-marker-alt mr-2"></i>Zip Code
                        </label>
                        <input wire:model="zipCode" type="text" id="zip_code" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                        @error('zipCode') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Address -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="address">
                            <i class="fa fa-home mr-2"></i>Address
                        </label>
                        <textarea wire:model="address" id="address" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        @error('address') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!--Accessibility-->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="accessibility">
                            <i class="fas fa-wheelchair mr-2"></i>Accessibility Needs
                        </label>
                        <textarea wire:model="accessibility" type="text" id="accessibility"
                                  placeholder="visual | auditory | motor | cognitive | ..."
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        @error('accessibility') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>
                {{-- end of step two--}}
                {{-- start of step three--}}
                <div class="flex flex-wrap flex-col md:flex-row justify-content-evenly py-6" x-ref="step3">
                    <!-- Interests -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="interests">
                            <i class="fa fa-heart mr-2"></i>Interests
                        </label>
                        <textarea wire:model="interests" id="interests"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        @error('interests') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Favorite Colors -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="favorite_colors">
                            <i class="fa fa-palette mr-2"></i>Favorite Colors
                        </label>
                        <textarea wire:model="favoriteColors" id="favorite_colors"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        @error('favoriteColors') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <!-- Image -->
                    <div class="mb-4 md:w-1/5">
                        <label class="block text-xs mb-2" for="image"><i class="fa fa-image mr-2"></i>Image</label>
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
                                        <div class="{{(isDarkMode() ? 'bg-gray-700' :'bg-gray-300')  }} rounded-md p-4 text-xs">
                                            <p class="text-gray-500">Are you sure you want to delete your image?</p>
                                            <div class="mt-4 flex justify-center space-x-4">
                                                <button wire:click="hideDeleteConfirmation"
                                                        class="bg-red-500 text-white px-2 py-1 rounded-md">No :(
                                                </button>
                                                <button wire:click="deleteImage"
                                                        class="bg-green-500 text-white px-2 py-1 rounded-md">Yes :)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endunless
                            </div>
                            {{--  if user is uploading file--}}
                        @elseif(str_contains($image, 'tmp'))
                            <i class="fa fa-check main-color" aria-hidden="true"></i>
                            <p class="text-sm main-color">Uploaded successfully. Just save changes.</p>
                            {{--if there is no image--}}
                        @else
                            <input wire:model="image" type="file" id="image"
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 h-2/3 focus:outline-none ">
                        @endif
                        @error('image') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- end of step three--}}
                    <!-- Submit Button -->
                    <div class="mb-4 md:w-1/5 flex items-center justify-center pt-4">
                        <button wire:click="saveProfile" title="commit the edit"
                                class="bg-main-mode hover:opacity-50 py-2 px-4 rounded mx-2">
                            <i class="fas fa-check normal-color text-white"></i>
                        </button>
                        <button wire:click="cancelProfile" title="discard the edit"
                                class="bg-main-mode hover:opacity-50 py-2 px-4 rounded mx-2">
                            <i class="fas fa-times normal-color text-white"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endif
