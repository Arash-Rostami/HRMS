<button
    hx-post="{{ route('crm.logout') }}"
    hx-push-url="false"
    hx-trigger="click"
    hx-indicator="#loading"
    type="submit"
    class="logout-button"
    title="Logout from SARV CRM API Service"
>
    🔐
</button>
