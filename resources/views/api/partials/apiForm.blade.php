@php
    $moduleOptions = [
        'Core CRM Modules' => [
            'Accounts'   => 'Accounts',
            'Contacts'   => 'Contacts',
            'Leads'      => 'Leads',
            'Opportunities' => 'Opportunities',
            'Cases'      => 'Cases',
            'Tasks'      => 'Tasks',
            'Meetings'   => 'Meetings',
            'Calls'      => 'Calls',
            'Emails'     => 'Emails',
            'Notes'      => 'Notes',
            'Documents'  => 'Documents',
            'Campaigns'  => 'Campaigns',
        ],
        'Sales & Financials' => [
            'AOS_Quotes'            => 'Quotes',
            'AOS_Invoices'          => 'Invoices',
            'AOS_Contracts'         => 'Sales Contracts',
            'AOS_Products'          => 'Products',
            'AOS_Product_Categories'=> 'Product Categories',
            'Purchase_Order'        => 'Purchase Orders',
            'Payments'              => 'Payments',
            'Deposits'              => 'Deposits',
        ],
        'Support & Service' => [
            'sc_Contract'                 => 'Support Contracts',
            'sc_contract_management'      => 'Services',
            'Service_Centers'             => 'Service Centers',
            'Knowledge_Base'              => 'Knowledge Base',
            'Knowledge_Base_Categories'   => 'Knowledge Base Categories',
            'Bugs'                        => 'Bug Tracker',
        ],
        'Project & Resource Management' => [
            'asol_Project'  => 'Projects',
            'Timesheet'     => 'Timesheets',
            'Appointments'  => 'Appointments',
        ],
        'Strategic & Operational' => [
            'OBJ_Objectives'    => 'Objectives',
            'OBJ_Indicators'    => 'Indicators',
            'OBJ_Conditions'    => 'Conditions',
            'Approval'          => 'Approval',
            'Branches'          => 'Branches',
            'Vendors'           => 'Vendors',
            'sc_competitor'     => 'Competitors',
        ],
        'Communications & Templates' => [
            'Communications'            => 'Communications',
            'Communications_Campaign'   => 'Communications Campaigns',
            'Communications_Target'     => 'Communications Targets',
            'Communications_Template'   => 'Communications Templates',
            'AOS_PDF_Templates'         => 'PDF Templates',
        ],
    ];
@endphp

<h1>Select Module</h1>
<form
    hx-get="{{ route('crm.index') }}"
    hx-select=".container"
    hx-target="#mainContainer"
    hx-swap="outerHTML"
    hx-push-url="true"
    hx-trigger="submit"
    hx-indicator="#loading"
>
    @csrf
    <label for="module" title="module">📂 Module</label>
    <select required id="module" name="module" aria-label="Select CRM Module"
            hx-on:change="UIHelpers.toggleCreateLink(this)">
        <option value=""> ...</option>
        @foreach($moduleOptions as $groupLabel => $options)
            <optgroup label="{{ $groupLabel }}">
                @foreach($options as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <label for="offset" title="offset">📅 Offset</label>
    <input type="number" id="offset" name="offset" placeholder="0">
    <label for="limit" title="limit">📊 Limit</label>
    <input type="number" id="limit" name="limit" placeholder="10">
    <div class="buttonContainer">
        <button type="submit"
                class="btn btn-primary retrieve-button"
                title="Retrieve data from SARV CRM API Service">
            🔎
        </button>
        {{-- Logout Button --}}
        @include('api.partials.logOut')
    </div>
</form>
