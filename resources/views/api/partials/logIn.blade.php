<h1 title="CRM Login">🔐 CRM</h1>
<form id="loginForm" action="{{ route('crm.login') }}" method="POST">
    @csrf
    <label for="username" title="username">👦🏻 Username</label>
    <input type="text" id="username" name="username" required>

    <label for="password" title="password">🔑 Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="btn btn-primary" title="Log into SARV CRM system">🔓 Login</button>
</form>
