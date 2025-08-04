{{-- Success Message --}}
@if(session('success'))
    <div dir="rtl" id="crm-success" class="crm-alert crm-alert--success">
        <svg style="display:none"
             xmlns="http://www.w3.org/2000/svg"
             fill="transparent"
             viewBox="0 0 16 16"
             hx-on:load="
              setTimeout(() => {
                const el = document.getElementById('crm-success');
                if (el) {
                  el.style.opacity = '0.2';
                  setTimeout(() => el.remove(), 500);
                }
              }, 3000);"></svg>
        ✅ <span>{{ session('success') }}</span>
    </div>
@endif
{{-- Error Message --}}
@if($errors->has('credentials'))
    <div dir="rtl" id="crm-error" class="crm-alert crm-alert--error">
        <svg style="display:none"
             xmlns="http://www.w3.org/2000/svg"
             fill="transparent" viewBox="0 0 16 16"
             hx-on:load="
              setTimeout(() => {
                const el = document.getElementById('crm-error');
                if (el) {
                  el.style.opacity = '0.2';
                  setTimeout(() => el.style.visibility = 'hidden', 500);
                }
              }, 3000);"></svg>
        ❌ <span>{{ $errors->first('credentials') }}</span>
    </div>
@endif
