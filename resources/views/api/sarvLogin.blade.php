<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARV API Login Page</title>
    <x-meta/>
    <style>.htmx-request .htmx-indicator {display: block;}.htmx-added {opacity: 0;transition: opacity 1.5s ease-in;} .htmx-swapping {opacity: 0.1;}

        body{display:flex;justify-content:center;align-items:center;height:100vh;margin:0;background-color:#53636b;font-family:Arial,sans-serif;overflow:hidden}#loginFormContainer{background-color:#fff;padding:2rem;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,.1);width:100%;max-width:400px}h1{text-align:center;margin-bottom:1rem}label{display:block;margin-bottom:.5rem;font-weight:700}input[type=number],input[type=password],input[type=text],select{width:100%;padding:.75rem;margin-bottom:1rem;border:1px solid #ccc;border-radius:4px;box-sizing:border-box;font-size:1rem}button{padding:.75rem;border:none;border-radius:4px;background-color:#53636b;color:#fff;font-size:1rem;cursor:pointer}button:hover{background-color:#2f4f4f}.buttonContainer{display:flex;justify-content:space-between;gap:1rem}.buttonContainer button{flex:1}.buttonContainer .logout-button{flex:0 0 25%;margin-top:1rem;background-color:#53636b}.buttonContainer .retrieve-button{flex:0 0 100%}.container{width:100%;max-width:1400px;margin:20px auto;padding:20px;background-color:#fff;box-shadow:0 2px 5px rgba(0,0,0,.1);height:calc(100vh - 40px - 40px);overflow:hidden;border-radius:8px}.scrollable-table{height:100%;overflow-x:auto;white-space:nowrap}table{min-width:100%;border-collapse:collapse;border-radius:8px;background-color:#fff;box-shadow:0 2px 5px rgba(0,0,0,.1)}td,th{text-align:left;border-bottom:1px solid #ddd;padding:8px 12px}th{background-color:#778899;color:#fff;font-size:16px;font-weight:400}tr:nth-child(even){background-color:#f2f2f2}tr:hover{background-color:#ddd}.button-container{display:flex;justify-content:flex-end;padding:10px 0;background-color:#fff;border-bottom:1px solid #ddd}.button{margin-left:10px;padding:8px 15px;background-color:#778899;color:#fff;text-align:center;border-radius:5px;text-decoration:none;font-size:16px;border:none;cursor:pointer;transition:background-color .3s ease;font-weight:400}.button:hover{background-color:#2f4f4f}.container{box-shadow:0 4px 8px rgba(0,0,0,.2)}.back-button{width:150px;font-weight:700;box-shadow:0 2px 4px rgba(0,0,0,.1)}.back-button:hover{background-color:#2f4f4f;box-shadow:0 4px 8px rgba(0,0,0,.2)}h1.text-center{font-size:24px;color:#2c3e50;font-weight:700;text-align:center;padding:10px 0;margin-bottom:20px;border-radius:5px;box-shadow:0 2px 4px rgba(0,0,0,.1)}</style>
    <script src="https://unpkg.com/htmx.org"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
</head>
<body>
@auth
    <div id="loginFormContainer">
        @if(!session()->has('crm_token'))
            <h1 title="CRM Login">🔐 CRM</h1>
            <form id="loginForm" action="{{ route('crm-login') }}" method="POST">
                @csrf
                <label for="username" title="username">👦🏻 Username</label>
                <input type="text" id="username" name="username" required>
                <label for="password" title="password">🔑 Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" title="Log into SARV CRM system">🔓 Login</button>
            </form>
        @else
            <h1>Select Module</h1>
            <form hx-get="{{ route('crm-contacts') }}"
                  hx-select=".container"
                  hx-target="#loginFormContainer"
                  hx-swap="outerHTML"
                  hx-push-url="true"
                  hx-trigger="submit"
                  hx-indicator="#loading">
                @csrf

                <label for="module" title="module">📂 Module</label>
                <select id=module name=module required><option value=Accounts>Accounts<option value=AOS_Contracts>Sales Contract<option value=AOS_Invoices>Invoices<option value=AOS_PDF_Templates>PDF Templates<option value=AOS_Product_Categories>Product Categories<option value=AOS_Products>Products<option value=AOS_Quotes>Quotes<option value=Appointments>Appointments<option value=Approval>Approval<option value=asol_Project>Project<option value=Branches>Branches<option value=Bugs>Bug Tracker<option value=Calls>Calls<option value=Cases>Cases<option value=Communications>Communications<option value=Communications_Campaign>Communications Campaign<option value=Communications_Target>Communications Target<option value=Communications_Template>Communications Template<option value=Campaigns>Campaigns<option value=Contacts>Contacts<option value=Deposits>Deposits<option value=Documents>Documents<option value=Emails>Emails<option value=Knowledge_Base>Knowledge Base<option value=Knowledge_Base_Categories>Knowledge Base Categories<option value=Leads>Leads<option value=Meetings>Meetings<option value=Notes>Notes<option value=OBJ_Conditions>Conditions<option value=OBJ_Indicators>Indicators<option value=OBJ_Objectives>Objectives<option value=Opportunities>Opportunities<option value=Payments>Payments<option value=Purchase_Order>Purchase Order<option value=sc_competitor>Competitor<option value=sc_Contract>Support Contracts<option value=sc_contract_management>Services<option value=Service_Centers>Service Centers<option value=Tasks>Tasks<option value=Timesheet>Timesheet<option value=Vendors>Vendors</select>

                <label for="offset" title="offset">📅 Offset</label>
                <input type="number" id="offset" name="offset" placeholder="0" value="">

                <label for="limit" title="limit">📊 Limit</label>
                <input type="number" id="limit" name="limit" placeholder="10" value="">

                <div class="buttonContainer">
                    <button type="submit" class="retrieve-button" title="Retrieve data from SARV CRM system">GET</button>
                </div>
            </form>
            <!-- Logout Form -->
            <form id="logoutForm" action="{{ route('crm-logout') }}" method="POST">
                @csrf
                <div class="buttonContainer">
                    <button type="submit" class="logout-button" title="Logout from SARV CRM system">🔐</button>
                </div>
            </form>
            <div id="loading" style="display:none;">Loading...</div>
        @endif
    </div>
@endauth
<script>
    let exporter; class TableExporter { constructor(tableId) { this.table = document.getElementById(tableId); } exportToExcel(filename = 'data-export.xlsx') { let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"}); XLSX.writeFile(workbook, filename); } exportToCSV(filename = 'data-export.csv') { let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"}); let csv = XLSX.utils.sheet_to_csv(workbook.Sheets[workbook.SheetNames[0]]); this.downloadCSV(csv, filename); } downloadCSV(csv, filename) { let csvFile = new Blob([csv], {type: "text/csv"}); let downloadLink = document.createElement("a"); downloadLink.download = filename; downloadLink.href = window.URL.createObjectURL(csvFile); downloadLink.style.display = "none"; document.body.appendChild(downloadLink); downloadLink.click(); } } document.body.addEventListener('htmx:afterSwap', () => { exporter = new TableExporter('tableData'); });
</script>
</body>
</html>
