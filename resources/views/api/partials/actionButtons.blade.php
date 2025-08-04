<div class="module-action-buttons">
    <!-- Create button -->
    <button id="add-new-record"
            hx-get="{{ route('crm.create') }}"
            hx-vals='js:{ module: "{{ $moduleName }}", limit: "{{ $limit }}"}'
            hx-target="#new-record-row"
            hx-swap="outerHTML"
            hx-indicator="#loading"
            class="btn btn-create">
            <span>
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Add
            </span>
    </button>
    <!-- View/Edit button -->
    <button
        class="btn btn-edit"
        hx-on:click="
      document.getElementById('view-mode').hidden = !document.getElementById('view-mode').hidden;
      document.getElementById('edit-mode').hidden = !document.getElementById('edit-mode').hidden;
      const eye = this.querySelector('.view-icon'),
            pen = this.querySelector('.edit-icon');
      eye.hidden = !eye.hidden;
      pen.hidden = !pen.hidden;"
    >
        <span class="view-icon" hidden>
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="16" height="16" fill="currentColor"
                 class="bi bi-eye view-icon inline-block"
                 viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3
               5.5 8 5.5S16 8 16 8z"/>
            <path d="M8 5a3 3 0 1 0 0 6
               3 3 0 0 0 0-6z"/>
        </svg> View
        </span>
        <span class="edit-icon">
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="16" height="16" fill="currentColor"
                 class="bi bi-pencil edit-icon inline-block"
                 viewBox="0 0 16 16">
            <path d="M12.146.854a.5.5 0 0 1
               .708 0l2.292 2.292a.5.5 0 0 1
               0 .708l-9.792 9.792a.5.5 0 0 1
               -.168.11l-5 2a.5.5 0 0 1-.65
               -.65l2-5a.5.5 0 0 1 .11
               -.168l9.792-9.792z"/>
        </svg> Edit
        </span>
    </button>
    <!-- Return button -->
    <button hx-on:click="(history.length > 1) ? history.back() : (window.location.href = '{{ route('crm') }}')"
            class=" btn btn-primary" title="Return to module selection">
        <span>
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                  viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg> Return
        </span>
    </button>
    <!-- Reset button -->
    <button hx-on:click="window.location.reload()" class="btn btn-secondary" title="Refresh data only">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-arrow-clockwise"
                 viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
            <path
                d="M8 1.5a.5.5 0 0 1 .496.438l.008.062v2.75l1.071-1.07a.5.5 0 1 1 .707.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .707-.708L7.5 4.75V2a.5.5 0 0 1 .5-.5z"/>
        </svg> Refresh
        </span>
    </button>
    <!-- Excel Export button -->
    <button hx-on:click="exporter.exportToExcel()" class="btn btn-success"
            title="Export current data to an Excel spreadsheet">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
            <path
                d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.233a.5.5 0 0 0 .768.64L8 10.754l2.233 2.232a.5.5 0 1 0 .768-.641L8.651 10l2.232-2.233a.5.5 0 0 0-.768-.64L8 9.246z"/>
            <path
                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
        </svg>  Excel
        </span>
    </button>
    <!-- CSV Export button -->
    <button hx-on:click="exporter.exportToCSV()" class="btn btn-info" title="Export current data to a CSV file">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
            <path
                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM12 9H4v1h8zm0 2H4v1h8zM4 8h8V7H4z"/>
        </svg>  CSV
        </span>
    </button>
</div>
