@if(isset($data) && count($data) > 0)
    <!-- VIEW MODE -->
    @include('api.partials.view')
    <!-- EDIT MODE (initially hidden) -->
    @include('api.partials.edit')

    <i class="record-count-message">{{ count($data) }} records displayed</i>
@else
    <p class="no-data-message" dir="rtl">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
             class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path
                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738
                   3.468c-.194.897.105 1.319.808 1.319.545 0
                   1.178-.252 1.465-.598l.088-.416c-.2.177-.5.23-.71.2
                   -.674-.11-.413-.509-.126-1.04l.587-2.77c.219-1.028
                   -.113-1.653-.825-1.653-.756 0-1.242.472-1.242 1.168v.605
                   q0 .148.118.423z"/>
        </svg>
        <strong>هیچ رکوردی یافت نشد:</strong> در حال حاضر با انتخاب انجام‌شده،
        هیچ داده‌ای یافت نشد. لطفاً معیارهای جستجوی خود را اصلاح کنید
        یا ماژول متفاوتی را انتخاب نمایید تا اطلاعات مربوطه بازیابی شوند.
    </p>
@endif
