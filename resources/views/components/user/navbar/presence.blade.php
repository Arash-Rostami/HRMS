<div class="overlay-content w-2/3 md:w-[35%] persol-farsi-font"
     x-show="presence"
     dir="rtl">
    <a href="{{ route('user.presence', ['status' => 'onsite']) }}">
        در دفتر
        <i class="fa fa-building text-success-400 m-2"></i>
    </a>
    <a href="{{ route('user.presence', ['status' => 'off-site']) }}">
        دور کار
        <i class="fa fa-laptop text-warning-500 m-2"></i>
    </a>
    <a href="{{ route('user.presence', ['status' => 'busy']) }}">
        مشغول
        <i class="fa fa-clock text-danger-600 m-2"></i>
    </a>
</div>
