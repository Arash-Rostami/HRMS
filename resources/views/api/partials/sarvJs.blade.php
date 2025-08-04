<script>
    class TableExporter {
        constructor(tableId) {
            this.table = document.getElementById(tableId) ?? null;
        }

        exportToExcel(filename = 'data-export.xlsx') {
            if (!this.table) return;
            let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"});
            XLSX.writeFile(workbook, filename);
        }

        exportToCSV(filename = 'data-export.csv') {
            if (!this.table) return;
            let workbook = XLSX.utils.table_to_book(this.table, {sheet: "Sheet 1"});
            let csv = XLSX.utils.sheet_to_csv(workbook.Sheets[workbook.SheetNames[0]]);
            this.downloadCSV(csv, filename);
        }

        downloadCSV(csv, filename) {
            const csvFile = new Blob([csv], {type: "text/csv"});
            const link = Object.assign(document.createElement('a'), {
                href: window.URL.createObjectURL(csvFile),
                download: filename,
                style: 'display:none'
            });
            document.body.appendChild(link);
            link.click();
            link.remove();
        }
    }

    // class ModuleFieldsLoader {
    //     constructor(moduleSelectId, containerId) {
    //         this.moduleSelect = document.getElementById(moduleSelectId);
    //         this.container = document.getElementById(containerId);
    //         if (!this.moduleSelect || !this.container) return;
    //
    //         this.moduleSelect.addEventListener('change', (e) => this.loadFields(e.target.value));
    //
    //         if (window.location.pathname.includes('/crm/create') && this.moduleSelect.value) {
    //             this.loadFields(this.moduleSelect.value);
    //         }
    //     }
    //
    //     async loadFields(module) {
    //         this.container.innerHTML = '';
    //         if (!module) return;
    //
    //         try {
    //             const columns = await this.fetchColumns(module);
    //             columns.forEach(col => col && this.createFieldGroup(col));
    //         } catch {
    //             this.container.innerHTML = '<p class="text-danger">Could not load fields.</p>';
    //         }
    //     }
    //
    //     async fetchColumns(module) {
    //         const res = await fetch(`/crm/columns/${module}`);
    //         if (!res.ok) throw new Error('Failed to fetch columns');
    //         return await res.json();
    //     }
    //
    //     createFieldGroup(columnName) {
    //         const labelText = this.formatLabel(columnName);
    //         const group = Object.assign(document.createElement('div'), {
    //             className: 'field-group'
    //         });
    //
    //         const label = Object.assign(document.createElement('label'), {
    //             textContent: labelText
    //         });
    //
    //         const input = Object.assign(document.createElement('input'), {
    //             type: 'text',
    //             name: `data[${columnName}]`,
    //             placeholder: `Enter ${labelText}…`,
    //             className: 'form-control'
    //         });
    //
    //         group.append(label, input);
    //         this.container.appendChild(group);
    //     }
    //
    //     formatLabel(name) {
    //         return name
    //             .replace(/_/g, ' ')
    //             .replace(/\b\w/g, c => c.toUpperCase());
    //     }
    // }

    {{--class UIHelpers {--}}
    {{--    static toggleCreateLink(selectEl) {--}}
    {{--        const link = document.getElementById('createLink');--}}
    {{--        if (!link) return;--}}

    {{--        const hasValue = Boolean(selectEl.value);--}}
    {{--        const styles = hasValue--}}
    {{--            ? {opacity: '0.4', cursor: 'not-allowed'}--}}
    {{--            : {opacity: '1', cursor: 'pointer'};--}}

    {{--        Object.assign(link.style, styles);--}}
    {{--        link[hasValue ? 'removeAttribute' : 'setAttribute']('href', '{{ route("crm-form") }}');--}}
    {{--    }--}}
    {{--}--}}

    class ConfirmationModal {
        constructor(modalId, confirmId, cancelId, messageId) {
            this.modal = document.getElementById(modalId);
            this.confirmBtn = document.getElementById(confirmId);
            this.cancelBtn = document.getElementById(cancelId);
            this.message = document.getElementById(messageId);
            this.currentEl = null;
            this.currentEvent = null;

            if (this.modal && this.confirmBtn && this.cancelBtn && this.message) {
                this.setupListeners();
            }
        }

        setupListeners() {
            document.body.addEventListener('htmx:beforeRequest', (e) => {
                if (e.target.classList.contains('editable-cell-input') && !e.target.dataset.confirmedRequest) {
                    e.preventDefault();
                    this.currentEl = e.target;
                    this.currentEvent = e.detail.triggeringEvent;
                    this.message.textContent = 'آیا مطمئن هستید که می‌خواهید این فیلد را به‌روزرسانی کنید؟';
                    this.modal.style.display = 'block';
                } else if (e.target.dataset.confirmedRequest) {
                    delete e.target.dataset.confirmedRequest;
                }
            });

            this.confirmBtn.addEventListener('click', () => {
                if (this.currentEl) {
                    this.currentEl.dataset.confirmedRequest = 'true';
                    this.modal.style.display = 'none';
                    htmx.trigger(this.currentEl, this.currentEvent?.type || 'change');
                    this.currentEl = null;
                    this.currentEvent = null;
                }
            });

            this.cancelBtn.addEventListener('click', () => this.hideModal());
            window.addEventListener('click', (e) => e.target === this.modal && this.hideModal());
        }

        hideModal() {
            this.modal.style.display = 'none';
            this.currentEl = null;
            this.currentEvent = null;
        }
    }


    document.addEventListener('DOMContentLoaded', () => {
        // new ModuleFieldsLoader('module', 'data-fields');


        document.body.addEventListener('htmx:afterSwap', () => {
            window.exporter = new TableExporter('tableData');
            new ConfirmationModal('confirmationModal', 'confirmBtn', 'cancelBtn', 'modalMessage');
        });

        // If the limit & offset input is empty, delete it from the request parameters for reason of fallback options.
        document.body.addEventListener('htmx:configRequest', ({detail: {parameters}}) => {
            ['limit', 'offset'].forEach(key => {
                if (parameters[key] === '') delete parameters[key];
            });
        });

        // window.addEventListener('popstate', () => {
        //     const sel = document.getElementById('module');
        //     if (sel) {
        //         sel.selectedIndex = 0;
        //         UIHelpers.toggleCreateLink(sel);
        //     }
        // });
    });
</script>
{{--<script>--}}
{{--    // Configuration and Constants--}}
{{--    const CONFIG = {--}}
{{--        ENDPOINTS: {--}}
{{--            COLUMNS: '/crm/columns',--}}
{{--            CRM_FORM: '{{ route("crm-form") }}'--}}
{{--        },--}}
{{--        SELECTORS: {--}}
{{--            MODULE_SELECT: 'module',--}}
{{--            DATA_FIELDS_CONTAINER: 'data-fields',--}}
{{--            TABLE_DATA: 'tableData',--}}
{{--            CREATE_LINK: 'createLink',--}}
{{--            CONFIRMATION_MODAL: 'confirmationModal',--}}
{{--            CONFIRM_BTN: 'confirmBtn',--}}
{{--            CANCEL_BTN: 'cancelBtn',--}}
{{--            MODAL_MESSAGE: 'modalMessage'--}}
{{--        },--}}
{{--        CLASSES: {--}}
{{--            FIELD_GROUP: 'field-group',--}}
{{--            FORM_CONTROL: 'form-control',--}}
{{--            EDITABLE_CELL_INPUT: 'editable-cell-input',--}}
{{--            TEXT_DANGER: 'text-danger'--}}
{{--        },--}}
{{--        MESSAGES: {--}}
{{--            FIELD_LOAD_ERROR: 'Could not load fields.',--}}
{{--            CONFIRMATION_TEXT: 'آیا مطمئن هستید که می‌خواهید این فیلد را به‌روزرسانی کنید؟'--}}
{{--        },--}}
{{--        DEFAULT_FILENAMES: {--}}
{{--            EXCEL: 'data-export.xlsx',--}}
{{--            CSV: 'data-export.csv'--}}
{{--        }--}}
{{--    };--}}

{{--    // Utility Functions--}}
{{--    const Utils = {--}}
{{--        /**--}}
{{--         * Safely get element by ID--}}
{{--         * @param {string} id - Element ID--}}
{{--         * @returns {HTMLElement|null}--}}
{{--         */--}}
{{--        getElementById(id) {--}}
{{--            return document.getElementById(id);--}}
{{--        },--}}

{{--        /**--}}
{{--         * Format column name to readable label--}}
{{--         * @param {string} name - Column name--}}
{{--         * @returns {string}--}}
{{--         */--}}
{{--        formatLabel(name) {--}}
{{--            return name--}}
{{--                .replace(/_/g, ' ')--}}
{{--                .replace(/\b\w/g, char => char.toUpperCase());--}}
{{--        },--}}

{{--        /**--}}
{{--         * Create element with properties--}}
{{--         * @param {string} tagName - HTML tag name--}}
{{--         * @param {Object} props - Element properties--}}
{{--         * @returns {HTMLElement}--}}
{{--         */--}}
{{--        createElement(tagName, props = {}) {--}}
{{--            return Object.assign(document.createElement(tagName), props);--}}
{{--        },--}}

{{--        /**--}}
{{--         * Apply styles to element--}}
{{--         * @param {HTMLElement} element - Target element--}}
{{--         * @param {Object} styles - Style properties--}}
{{--         */--}}
{{--        applyStyles(element, styles) {--}}
{{--            Object.assign(element.style, styles);--}}
{{--        },--}}

{{--        /**--}}
{{--         * Handle fetch errors--}}
{{--         * @param {Response} response - Fetch response--}}
{{--         * @returns {Response}--}}
{{--         */--}}
{{--        handleFetchError(response) {--}}
{{--            if (!response.ok) {--}}
{{--                throw new Error(`HTTP error! status: ${response.status}`);--}}
{{--            }--}}
{{--            return response;--}}
{{--        }--}}
{{--    };--}}

{{--    // Base Class for common functionality--}}
{{--    class BaseComponent {--}}
{{--        constructor() {--}}
{{--            this.isInitialized = false;--}}
{{--        }--}}

{{--        /**--}}
{{--         * Initialize component--}}
{{--         * @returns {boolean} - Success status--}}
{{--         */--}}
{{--        init() {--}}
{{--            try {--}}
{{--                this.setup();--}}
{{--                this.bindEvents();--}}
{{--                this.isInitialized = true;--}}
{{--                return true;--}}
{{--            } catch (error) {--}}
{{--                console.error(`Error initializing ${this.constructor.name}:`, error);--}}
{{--                return false;--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Setup component - override in subclasses--}}
{{--         */--}}
{{--        setup() {--}}
{{--            // Override in subclasses--}}
{{--        }--}}

{{--        /**--}}
{{--         * Bind event listeners - override in subclasses--}}
{{--         */--}}
{{--        bindEvents() {--}}
{{--            // Override in subclasses--}}
{{--        }--}}
{{--    }--}}

{{--    // Table Export Functionality--}}
{{--    class TableExporter extends BaseComponent {--}}
{{--        constructor(tableId) {--}}
{{--            super();--}}
{{--            this.tableId = tableId;--}}
{{--            this.table = null;--}}
{{--        }--}}

{{--        setup() {--}}
{{--            this.table = Utils.getElementById(this.tableId);--}}
{{--            if (!this.table) {--}}
{{--                throw new Error(`Table with ID "${this.tableId}" not found`);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Export table to Excel format--}}
{{--         * @param {string} filename - Output filename--}}
{{--         */--}}
{{--        exportToExcel(filename = CONFIG.DEFAULT_FILENAMES.EXCEL) {--}}
{{--            if (!this.isInitialized || !this.table) return;--}}

{{--            try {--}}
{{--                const workbook = XLSX.utils.table_to_book(this.table, { sheet: "Sheet 1" });--}}
{{--                XLSX.writeFile(workbook, filename);--}}
{{--            } catch (error) {--}}
{{--                console.error('Excel export failed:', error);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Export table to CSV format--}}
{{--         * @param {string} filename - Output filename--}}
{{--         */--}}
{{--        exportToCSV(filename = CONFIG.DEFAULT_FILENAMES.CSV) {--}}
{{--            if (!this.isInitialized || !this.table) return;--}}

{{--            try {--}}
{{--                const workbook = XLSX.utils.table_to_book(this.table, { sheet: "Sheet 1" });--}}
{{--                const csv = XLSX.utils.sheet_to_csv(workbook.Sheets[workbook.SheetNames[0]]);--}}
{{--                this.downloadCSV(csv, filename);--}}
{{--            } catch (error) {--}}
{{--                console.error('CSV export failed:', error);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Download CSV content--}}
{{--         * @param {string} csv - CSV content--}}
{{--         * @param {string} filename - Output filename--}}
{{--         */--}}
{{--        downloadCSV(csv, filename) {--}}
{{--            const csvFile = new Blob([csv], { type: "text/csv" });--}}
{{--            const link = Utils.createElement('a', {--}}
{{--                href: window.URL.createObjectURL(csvFile),--}}
{{--                download: filename,--}}
{{--                style: 'display:none'--}}
{{--            });--}}

{{--            document.body.appendChild(link);--}}
{{--            link.click();--}}
{{--            link.remove();--}}
{{--            window.URL.revokeObjectURL(link.href);--}}
{{--        }--}}
{{--    }--}}

{{--    // Dynamic Module Fields Loader--}}
{{--    class ModuleFieldsLoader extends BaseComponent {--}}
{{--        constructor(moduleSelectId, containerId) {--}}
{{--            super();--}}
{{--            this.moduleSelectId = moduleSelectId;--}}
{{--            this.containerId = containerId;--}}
{{--            this.moduleSelect = null;--}}
{{--            this.container = null;--}}
{{--            this.abortController = null;--}}
{{--        }--}}

{{--        setup() {--}}
{{--            this.moduleSelect = Utils.getElementById(this.moduleSelectId);--}}
{{--            this.container = Utils.getElementById(this.containerId);--}}

{{--            if (!this.moduleSelect || !this.container) {--}}
{{--                throw new Error('Required elements not found for ModuleFieldsLoader');--}}
{{--            }--}}
{{--        }--}}

{{--        bindEvents() {--}}
{{--            this.moduleSelect.addEventListener('change', (e) => {--}}
{{--                this.loadFields(e.target.value);--}}
{{--            });--}}

{{--            // Auto-load fields if on create page with pre-selected module--}}
{{--            if (window.location.pathname.includes('/crm/create') && this.moduleSelect.value) {--}}
{{--                this.loadFields(this.moduleSelect.value);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Load fields for selected module--}}
{{--         * @param {string} module - Module name--}}
{{--         */--}}
{{--        async loadFields(module) {--}}
{{--            // Cancel previous request if still pending--}}
{{--            if (this.abortController) {--}}
{{--                this.abortController.abort();--}}
{{--            }--}}

{{--            this.clearContainer();--}}
{{--            if (!module) return;--}}

{{--            this.showLoading();--}}

{{--            try {--}}
{{--                this.abortController = new AbortController();--}}
{{--                const columns = await this.fetchColumns(module);--}}

{{--                if (Array.isArray(columns)) {--}}
{{--                    columns.forEach(column => {--}}
{{--                        if (column) this.createFieldGroup(column);--}}
{{--                    });--}}
{{--                }--}}
{{--            } catch (error) {--}}
{{--                if (error.name !== 'AbortError') {--}}
{{--                    console.error('Error loading fields:', error);--}}
{{--                    this.showError();--}}
{{--                }--}}
{{--            } finally {--}}
{{--                this.abortController = null;--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Fetch columns for module--}}
{{--         * @param {string} module - Module name--}}
{{--         * @returns {Promise<Array>}--}}
{{--         */--}}
{{--        async fetchColumns(module) {--}}
{{--            const response = await fetch(--}}
{{--                `${CONFIG.ENDPOINTS.COLUMNS}/${encodeURIComponent(module)}`,--}}
{{--                { signal: this.abortController.signal }--}}
{{--            );--}}

{{--            Utils.handleFetchError(response);--}}
{{--            return await response.json();--}}
{{--        }--}}

{{--        /**--}}
{{--         * Create field group for column--}}
{{--         * @param {string} columnName - Column name--}}
{{--         */--}}
{{--        createFieldGroup(columnName) {--}}
{{--            const labelText = Utils.formatLabel(columnName);--}}

{{--            const group = Utils.createElement('div', {--}}
{{--                className: CONFIG.CLASSES.FIELD_GROUP--}}
{{--            });--}}

{{--            const label = Utils.createElement('label', {--}}
{{--                textContent: labelText,--}}
{{--                htmlFor: `field_${columnName}`--}}
{{--            });--}}

{{--            const input = Utils.createElement('input', {--}}
{{--                type: 'text',--}}
{{--                id: `field_${columnName}`,--}}
{{--                name: `data[${columnName}]`,--}}
{{--                placeholder: `Enter ${labelText}…`,--}}
{{--                className: CONFIG.CLASSES.FORM_CONTROL--}}
{{--            });--}}

{{--            group.append(label, input);--}}
{{--            this.container.appendChild(group);--}}
{{--        }--}}

{{--        /**--}}
{{--         * Clear container content--}}
{{--         */--}}
{{--        clearContainer() {--}}
{{--            if (this.container) {--}}
{{--                this.container.innerHTML = '';--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Show loading state--}}
{{--         */--}}
{{--        showLoading() {--}}
{{--            if (this.container) {--}}
{{--                this.container.innerHTML = '<p class="text-info">Loading fields...</p>';--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Show error message--}}
{{--         */--}}
{{--        showError() {--}}
{{--            if (this.container) {--}}
{{--                this.container.innerHTML = `<p class="${CONFIG.CLASSES.TEXT_DANGER}">${CONFIG.MESSAGES.FIELD_LOAD_ERROR}</p>`;--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}

{{--    // UI Helper Functions--}}
{{--    class UIHelpers {--}}
{{--        /**--}}
{{--         * Toggle create link based on select value--}}
{{--         * @param {HTMLSelectElement} selectEl - Select element--}}
{{--         */--}}
{{--        static toggleCreateLink(selectEl) {--}}
{{--            const link = Utils.getElementById(CONFIG.SELECTORS.CREATE_LINK);--}}
{{--            if (!link) return;--}}

{{--            const hasValue = Boolean(selectEl.value);--}}
{{--            const styles = hasValue--}}
{{--                ? { opacity: '0.4', cursor: 'not-allowed' }--}}
{{--                : { opacity: '1', cursor: 'pointer' };--}}

{{--            Utils.applyStyles(link, styles);--}}

{{--            if (hasValue) {--}}
{{--                link.removeAttribute('href');--}}
{{--            } else {--}}
{{--                link.setAttribute('href', CONFIG.ENDPOINTS.CRM_FORM);--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}

{{--    // Confirmation Modal Handler--}}
{{--    class ConfirmationModal extends BaseComponent {--}}
{{--        constructor(modalId, confirmId, cancelId, messageId) {--}}
{{--            super();--}}
{{--            this.modalId = modalId;--}}
{{--            this.confirmId = confirmId;--}}
{{--            this.cancelId = cancelId;--}}
{{--            this.messageId = messageId;--}}

{{--            this.modal = null;--}}
{{--            this.confirmBtn = null;--}}
{{--            this.cancelBtn = null;--}}
{{--            this.message = null;--}}
{{--            this.currentElement = null;--}}
{{--            this.currentEvent = null;--}}
{{--        }--}}

{{--        setup() {--}}
{{--            this.modal = Utils.getElementById(this.modalId);--}}
{{--            this.confirmBtn = Utils.getElementById(this.confirmId);--}}
{{--            this.cancelBtn = Utils.getElementById(this.cancelId);--}}
{{--            this.message = Utils.getElementById(this.messageId);--}}

{{--            if (!this.modal || !this.confirmBtn || !this.cancelBtn || !this.message) {--}}
{{--                throw new Error('Required modal elements not found');--}}
{{--            }--}}
{{--        }--}}

{{--        bindEvents() {--}}
{{--            // HTMX before request handler--}}
{{--            document.body.addEventListener('htmx:beforeRequest', (e) => {--}}
{{--                this.handleBeforeRequest(e);--}}
{{--            });--}}

{{--            // Confirm button handler--}}
{{--            this.confirmBtn.addEventListener('click', () => {--}}
{{--                this.handleConfirm();--}}
{{--            });--}}

{{--            // Cancel button handler--}}
{{--            this.cancelBtn.addEventListener('click', () => {--}}
{{--                this.hideModal();--}}
{{--            });--}}

{{--            // Outside click handler--}}
{{--            window.addEventListener('click', (e) => {--}}
{{--                if (e.target === this.modal) {--}}
{{--                    this.hideModal();--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        /**--}}
{{--         * Handle HTMX before request event--}}
{{--         * @param {Event} e - Event object--}}
{{--         */--}}
{{--        handleBeforeRequest(e) {--}}
{{--            const isEditableCell = e.target.classList.contains(CONFIG.CLASSES.EDITABLE_CELL_INPUT);--}}
{{--            const isConfirmed = e.target.dataset.confirmedRequest;--}}

{{--            if (isEditableCell && !isConfirmed) {--}}
{{--                e.preventDefault();--}}
{{--                this.showConfirmation(e.target, e.detail.triggeringEvent);--}}
{{--            } else if (isConfirmed) {--}}
{{--                delete e.target.dataset.confirmedRequest;--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Show confirmation modal--}}
{{--         * @param {HTMLElement} element - Target element--}}
{{--         * @param {Event} event - Triggering event--}}
{{--         */--}}
{{--        showConfirmation(element, event) {--}}
{{--            this.currentElement = element;--}}
{{--            this.currentEvent = event;--}}
{{--            this.message.textContent = CONFIG.MESSAGES.CONFIRMATION_TEXT;--}}
{{--            this.modal.style.display = 'block';--}}
{{--        }--}}

{{--        /**--}}
{{--         * Handle confirm action--}}
{{--         */--}}
{{--        handleConfirm() {--}}
{{--            if (!this.currentElement) return;--}}

{{--            this.currentElement.dataset.confirmedRequest = 'true';--}}
{{--            this.hideModal();--}}

{{--            // Trigger the original event--}}
{{--            if (typeof htmx !== 'undefined' && htmx.trigger) {--}}
{{--                htmx.trigger(this.currentElement, this.currentEvent?.type || 'change');--}}
{{--            }--}}

{{--            this.resetState();--}}
{{--        }--}}

{{--        /**--}}
{{--         * Hide modal--}}
{{--         */--}}
{{--        hideModal() {--}}
{{--            if (this.modal) {--}}
{{--                this.modal.style.display = 'none';--}}
{{--            }--}}
{{--            this.resetState();--}}
{{--        }--}}

{{--        /**--}}
{{--         * Reset internal state--}}
{{--         */--}}
{{--        resetState() {--}}
{{--            this.currentElement = null;--}}
{{--            this.currentEvent = null;--}}
{{--        }--}}
{{--    }--}}

{{--    // Application Controller--}}
{{--    class CRMApp {--}}
{{--        constructor() {--}}
{{--            this.components = new Map();--}}
{{--            this.isInitialized = false;--}}
{{--        }--}}

{{--        /**--}}
{{--         * Initialize the application--}}
{{--         */--}}
{{--        init() {--}}
{{--            if (this.isInitialized) return;--}}

{{--            try {--}}
{{--                this.setupComponents();--}}
{{--                this.bindGlobalEvents();--}}
{{--                this.isInitialized = true;--}}
{{--                console.log('CRM App initialized successfully');--}}
{{--            } catch (error) {--}}
{{--                console.error('Failed to initialize CRM App:', error);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Setup all components--}}
{{--         */--}}
{{--        setupComponents() {--}}
{{--            // Initialize module fields loader--}}
{{--            const fieldsLoader = new ModuleFieldsLoader(--}}
{{--                CONFIG.SELECTORS.MODULE_SELECT,--}}
{{--                CONFIG.SELECTORS.DATA_FIELDS_CONTAINER--}}
{{--            );--}}

{{--            if (fieldsLoader.init()) {--}}
{{--                this.components.set('fieldsLoader', fieldsLoader);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Bind global event listeners--}}
{{--         */--}}
{{--        bindGlobalEvents() {--}}
{{--            // HTMX after swap handler--}}
{{--            document.body.addEventListener('htmx:afterSwap', () => {--}}
{{--                this.handleAfterSwap();--}}
{{--            });--}}

{{--            // HTMX config request handler--}}
{{--            document.body.addEventListener('htmx:configRequest', (e) => {--}}
{{--                this.handleConfigRequest(e);--}}
{{--            });--}}

{{--            // Browser navigation handler--}}
{{--            window.addEventListener('popstate', () => {--}}
{{--                this.handlePopState();--}}
{{--            });--}}
{{--        }--}}

{{--        /**--}}
{{--         * Handle HTMX after swap event--}}
{{--         */--}}
{{--        handleAfterSwap() {--}}
{{--            // Reinitialize table exporter--}}
{{--            window.exporter = new TableExporter(CONFIG.SELECTORS.TABLE_DATA);--}}
{{--            if (window.exporter.init()) {--}}
{{--                this.components.set('exporter', window.exporter);--}}
{{--            }--}}

{{--            // Reinitialize confirmation modal--}}
{{--            const modal = new ConfirmationModal(--}}
{{--                CONFIG.SELECTORS.CONFIRMATION_MODAL,--}}
{{--                CONFIG.SELECTORS.CONFIRM_BTN,--}}
{{--                CONFIG.SELECTORS.CANCEL_BTN,--}}
{{--                CONFIG.SELECTORS.MODAL_MESSAGE--}}
{{--            );--}}

{{--            if (modal.init()) {--}}
{{--                this.components.set('modal', modal);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Handle HTMX config request event--}}
{{--         * @param {Event} e - Event object--}}
{{--         */--}}
{{--        handleConfigRequest(e) {--}}
{{--            const { parameters } = e.detail;--}}

{{--            // Clean empty parameters for fallback options--}}
{{--            ['limit', 'offset'].forEach(key => {--}}
{{--                if (parameters[key] === '') {--}}
{{--                    delete parameters[key];--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        /**--}}
{{--         * Handle browser back/forward navigation--}}
{{--         */--}}
{{--        handlePopState() {--}}
{{--            const moduleSelect = Utils.getElementById(CONFIG.SELECTORS.MODULE_SELECT);--}}
{{--            if (moduleSelect) {--}}
{{--                moduleSelect.selectedIndex = 0;--}}
{{--                UIHelpers.toggleCreateLink(moduleSelect);--}}
{{--            }--}}
{{--        }--}}

{{--        /**--}}
{{--         * Get component instance--}}
{{--         * @param {string} name - Component name--}}
{{--         * @returns {BaseComponent|null}--}}
{{--         */--}}
{{--        getComponent(name) {--}}
{{--            return this.components.get(name) || null;--}}
{{--        }--}}

{{--        /**--}}
{{--         * Destroy the application--}}
{{--         */--}}
{{--        destroy() {--}}
{{--            this.components.clear();--}}
{{--            this.isInitialized = false;--}}
{{--        }--}}
{{--    }--}}

{{--    // Initialize application when DOM is ready--}}
{{--    document.addEventListener('DOMContentLoaded', () => {--}}
{{--        window.crmApp = new CRMApp();--}}
{{--        window.crmApp.init();--}}
{{--    });--}}

{{--</script>--}}
