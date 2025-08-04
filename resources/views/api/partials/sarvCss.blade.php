<style>
    :root {
        --color-bg: #E3EBF6;
        --color-card-bg: #ffffff;

        --color-text: #2e3b4e;
        --color-light-text: #5e6b7d;

        --color-border: #c4d1e1;

        --color-primary-btn: #3b4f66;
        --color-primary-btn-hover: #2f4054;

        --color-create-btn: #748873;
        --color-create-btn-hover: #515f50;

        --color-edit-btn: #D1A980;
        --color-edit-btn-hover: #885d31;

        --color-success-btn: #113F67;
        --color-success-btn-hover: #10151b;

        --color-info-btn: #374c52;
        --color-info-btn-hover: #158e8e;

        --color-secondary-btn: #7b8a95;
        --color-secondary-btn-hover: #57636c;

        --color-white: #ffffff;
        --color-table-header-bg: #dde5ee;
        --color-table-header-text: #3a4b5c;
        --color-table-row-even: #f8fafc;
        --color-table-row-hover: #dbe7f2;

        --color-focus-ring: rgba(59, 79, 102, 0.25);


        --spacing-unit: 0.75rem;
        --padding-sm: 0.5rem;
        --padding-md: 0.75rem;
        --padding-lg: 1.25rem;
        --container-padding: 2.5rem;
        --table-cell-vertical-padding: 0.4rem;
        --table-cell-horizontal-padding: 1.2rem;

        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;

        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 20px rgba(0, 0, 0, 0.16);

        --transition-fast: 0.2s ease-out;
        --transition-normal: 0.35s ease-in-out;

        --font-base: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        --font-size-base: 1rem;
        --font-size-lg: 1.6rem;
        --font-size-xl: 2.2rem;
        --font-size-sm: 0.85rem;
        --table-font-size: 0.9rem;
        --module-btn-padding-vertical: 0.4rem;
        --module-btn-padding-horizontal: 1rem;
        --module-btn-font-size: 0.8rem;
    }


    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html, body {
        min-height: 100vh;
        font-family: var(--font-base);
        font-size: var(--font-size-base);
        line-height: 1.6;
        color: var(--color-text);
        background: var(--color-bg);
    }

    body {
        display: flex;
        justify-content: center;
        padding: var(--container-padding);
        overflow-y: auto;
    }

    h1 {
        color: var(--color-text);
        font-size: var(--font-size-xl);
        font-weight: 700;
        text-align: center;
        margin-bottom: var(--padding-lg);
        letter-spacing: -0.025em;
    }

    .container h1 {
        font-size: var(--font-size-lg);
    }

    #mainContainer {
        background: var(--color-card-bg);
        padding: var(--container-padding);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        width: 100%;
        max-width: 450px;
        margin: var(--container-padding) auto;
    }

    #loginForm, #logoutForm {
        margin-bottom: var(--padding-lg);
    }

    .crm-alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.375rem;
        font-size: 0.9375rem;
        line-height: 1.25;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .crm-alert--error {
        background-color: #fdecea;
        color: #b71c1c;
        border: 1px solid #f5c6cb;
    }

    .crm-alert--success {
        background-color: #e6f4ea;
        color: #1e4620;
        border: 1px solid #c3e6cb;
        transition: opacity 1s ease;
    }

    .crm-alert--error {
        transition: opacity 1s ease;
    }

    .crm-alert svg {
        flex-shrink: 0;
        width: 1.25rem;
        height: 1.25rem;
    }


    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--color-light-text);
        font-size: var(--font-size-sm);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    input, select {
        width: 100%;
        padding: var(--padding-md);
        margin-bottom: var(--padding-lg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        font-size: var(--font-size-base);
        color: var(--color-text);
        background-color: var(--color-card-bg);
        transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    input:focus, select:focus {
        outline: none;
        border-color: var(--color-primary-btn);
        box-shadow: 0 0 0 3px var(--color-focus-ring);
    }

    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath fill='%236c757d' d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 0.8em 0.8em;
        padding-right: 2.5rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: var(--radius-sm);
        font-size: var(--font-size-base);
        font-weight: 600;
        cursor: pointer;
        transition: background var(--transition-fast), transform var(--transition-fast), box-shadow var(--transition-fast);
        white-space: nowrap;
        text-decoration: none;
        box-shadow: var(--shadow-sm);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn:active {
        transform: translateY(0);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary {
        background: var(--color-primary-btn);
        color: var(--color-white);
    }

    .btn-create {
        background: var(--color-create-btn);
        color: var(--color-white);
    }

    .btn-create:hover {
        background: var(--color-create-btn-hover);
        color: var(--color-white);
    }

    .btn-edit {
        background: var(--color-edit-btn);
        color: var(--color-white);
    }

    .btn-edit:hover {
        background: var(--color-edit-btn-hover);
        color: var(--color-white);
    }

    .btn-primary:hover {
        background: var(--color-primary-btn-hover);
    }

    .btn-success {
        background: var(--color-success-btn);
        color: var(--color-white);
    }

    .btn-success:hover {
        background: var(--color-success-btn-hover);
    }

    .btn-info {
        background: var(--color-info-btn);
        color: var(--color-white);
    }

    .btn-info:hover {
        background: var(--color-info-btn-hover);
    }

    .btn-secondary {
        background: var(--color-secondary-btn);
        color: var(--color-white);
    }

    .btn-secondary:hover {
        background: var(--color-secondary-btn-hover);
    }

    .btn span {
        margin-right: 0.5rem;
    }

    .buttonContainer {
        display: flex;
        flex-wrap: wrap;
        gap: var(--padding-md);
        justify-content: center;
        margin-top: var(--padding-lg);
    }

    .retrieve-button, .create-button {
        flex: 1;
    }

    .logout-button {
        padding: 0.75rem;
        font-size: 1.5rem;
        flex: 0 0 auto;
        cursor: pointer;
    }

    #loading.htmx-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40px;
        opacity: 0;
        transition: opacity var(--transition-normal);
        color: var(--color-primary-btn);
        font-weight: 600;
        margin-top: var(--padding-md);
    }

    .htmx-request #loading.htmx-indicator {
        opacity: 1;
    }

    .htmx-swapping #loading.htmx-indicator {
        opacity: 0.4;
    }

    .htmx-settling #loading.htmx-indicator {
        transition: opacity 0.2s ease-out;
    }

    .container {
        max-width: 1400px;
        width: 100%;
        margin: var(--container-padding) auto;
        background: var(--color-card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--color-border);
        padding: var(--container-padding);
    }

    .scrollable-table {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 768px;
        font-size: var(--table-font-size);
    }

    th, td {
        padding: var(--table-cell-vertical-padding) var(--table-cell-horizontal-padding);
        border-bottom: 1px solid var(--color-border);
        text-align: left;
        line-height: 1.2;
        white-space: nowrap;
    }

    th {
        background: var(--color-table-header-bg);
        color: var(--color-table-header-text);
        font-weight: 600;
        text-transform: uppercase;
        font-size: var(--font-size-sm);
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    svg {
        margin: 3px;
    }

    tbody tr:nth-child(even) {
        background: var(--color-table-row-even);
    }

    tbody tr:hover {
        background: var(--color-table-row-hover);
        transition: background var(--transition-fast);
    }

    .no-data-message {
        text-align: center;
        padding: var(--container-padding);
        font-size: 1.1rem;
        color: var(--color-light-text);
        margin-top: var(--padding-lg);
    }

    .record-count-message {
        float: right !important;
        color: var(--color-light-text);
        font-size: 0.9rem;
    }

    .error-message {
        color: red;
        margin-top: var(--padding-md);
        text-align: center;
    }

    .success-message {
        color: green;
        margin-top: var(--padding-md);
        text-align: center;
    }

    .module-action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: var(--padding-md);
        margin-bottom: var(--container-padding);
    }

    .module-action-buttons .btn {
        padding: var(--module-btn-padding-vertical) var(--module-btn-padding-horizontal);
        font-size: var(--module-btn-font-size);
        box-shadow: var(--shadow-sm);
    }

    .form-container {
        padding: 1rem;
    }

    @media (min-width: 1024px) {
        .form-container {
            padding: 2rem;
        }
    }

    .form-content {
        margin: 0 auto;
        background: #fff;
        padding: 1.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        display: block;
        margin-bottom: .25rem;
        font-weight: 500;
    }

    .form-select {
        display: block;
        width: 100%;
        padding: .5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .fields-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .editable-cell-input {
        width: auto;
        box-sizing: border-box;
    }

    @media (min-width: 640px) {
        .fields-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 768px) {
        .fields-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .field-group {
        display: flex;
        flex-direction: column;
    }

    .field-group label {
        margin-bottom: .25rem;
        font-weight: 500;
    }

    .field-group input {
        padding: .5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .modal-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .modal-buttons .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
    }

    @media (min-width: 640px) {
        .button-wrap {
            text-align: right;
        }

        .btn {
            width: auto;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: var(--padding-lg);
        }

        h1 {
            font-size: var(--font-size-lg);
            margin-bottom: var(--padding-md);
        }

        #mainContainer, .container {
            padding: var(--padding-md);
            margin: var(--padding-md) auto;
            box-shadow: var(--shadow-sm);
            border-radius: var(--radius-md);
        }

        th, td {
            padding: var(--padding-sm) var(--padding-md);
            font-size: var(--font-size-sm);
            white-space: nowrap;
        }

        .module-action-buttons {
            justify-content: center;
            flex-direction: column;
            gap: var(--padding-sm);
            margin-bottom: var(--padding-lg);
        }

        .btn {
            width: 100%;
            max-width: none;
        }

        .buttonContainer {
            flex-direction: column;
            gap: var(--padding-sm);
        }

        .logout-button {
            width: 100%;
        }

        .no-data-message {
            font-size: var(--font-size-base);
            padding: var(--padding-lg);
        }
    }

    @media (max-width: 480px) {
        body {
            padding: var(--padding-md);
        }

        #mainContainer, .container {
            padding: var(--padding-sm);
            margin: var(--padding-md) auto;
        }

        h1 {
            font-size: 1.2rem;
        }

        .scrollable-table {
            border-radius: 0;
            border: none;
        }
    }
</style>
