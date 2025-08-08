@php
    $isLightMode = (Cookie::get('mode') == '#F1F1F1');
    $modules = config('modules');
@endphp
<style>
    :root {
        --ui-panel-bg: rgba(31, 41, 55, {{ isDarkMode() ? '0.6' : '.3' }});
        --main: {{ Cookie::get('theme', '#607D8B') }};
        --bg-main: {{ Cookie::get('mode', '#1B232E') }};
    }
</style>
<main>
    <div class="landing-grid">
        <div class="visual-side">
            <canvas id="interactive-background"></canvas>
            <div class="text-content">
                <h1 class="hrms-title">HRMS</h1>
                <h4 class="main-heading">سیستم مدیریت منابع انسانی</h4>
            </div>
        </div>

        <div class="action-panel">
            <div class="enter-section">
                <a href="{{ route('user.panel') }}" title="ورود به سامانه {{ config('app.name') }} 🔐">
                    <i class="fas fa-fingerprint"></i>
                    <span>ورود به سامانه</span>
                </a>
            </div>
            <div class="modules-section">
                <h3>برخی از ماژول‌ها</h3>
                <ul class="module-grid">
                    @foreach($modules as $module)
                        <li class="module-item">
                            <div class="module-icon">
                                <i class="fas {{ $module['icon'] }}"></i>
                            </div>
                            <div class="module-tooltip">
                                <h4>{{ $module['title'] }}</h4>
                                <p>{{ $module['summary'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="controls-footer">
                @if($isLightMode)
                    <a href="{{route('landing-page', 'dark-mode')}}" class="control-btn" title="تغییر به حالت تاریک 🌙">
                        <i class="fas fa-moon"></i>
                    </a>
                @else
                    <a href="{{route('landing-page', 'light-mode')}}" class="control-btn" title="تغییر به حالت روشن ☀️">
                        <i class="fas fa-sun"></i>
                    </a>
                @endif

                @foreach($themes as $name => $code)
                    <a href="{{route('landing-page', $name)}}" title="{{strstr($name,'-theme', true)}}">
                        <span class="color-dot {{strstr($name,'-theme', true)}}"></span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</main>



