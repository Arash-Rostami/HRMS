<div class="overlay-content w-2/3 md:w-[35%]" x-show="presence">
    <a href="{{ route('user.presence', ['status' => 'onsite']) }}">
        <i class="fa fa-building text-success-400 m-2"></i>
        ONSITE
    </a>
    <a href="{{ route('user.presence', ['status' => 'off-site']) }}">
        <i class="fa fa-laptop text-warning-500 m-2"></i>
        OFF-SITE
    </a>
    <a href="{{ route('user.presence', ['status' => 'busy']) }}">
        <i class="fa fa-clock text-danger-600 m-2"></i>
        BUSY
    </a>
</div>
