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


    });
</script>
