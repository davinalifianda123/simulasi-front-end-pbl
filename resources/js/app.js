import './bootstrap';
import 'flowbite';
import * as simpleDatatables from 'simple-datatables';
import './dashboard';
import Alpine from 'alpinejs';

window.Alpine = Alpine
Alpine.start()

if (document.getElementById("export-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const exportCustomCSV = function(dataTable, userOptions = {}) {
        // A modified CSV export that includes a row of minuses at the start and end.
        const clonedUserOptions = {
            ...userOptions
        }
        clonedUserOptions.download = false
        const csv = simpleDatatables.exportCSV(dataTable, clonedUserOptions)
        // If CSV didn't work, exit.
        if (!csv) {
            return false
        }
        const defaults = {
            download: true,
            lineDelimiter: "\n",
            columnDelimiter: ";"
        }
        const options = {
            ...defaults,
            ...clonedUserOptions
        }
        const separatorRow = Array(dataTable.data.headings.filter((_heading, index) => !dataTable.columns.settings[index]?.hidden).length)
            .fill("+")
            .join("+"); // Use "+" as the delimiter

        const str = separatorRow + options.lineDelimiter + csv + options.lineDelimiter + separatorRow;

        if (userOptions.download) {
            // Create a link to trigger the download
            const link = document.createElement("a");
            link.href = encodeURI("data:text/csv;charset=utf-8," + str);
            link.download = (options.filename || "datatable_export") + ".txt";
            // Append the link
            document.body.appendChild(link);
            // Trigger the download
            link.click();
            // Remove the link
            document.body.removeChild(link);
        }

        return str
    }

    // Function to add action column after table initialization
    const addActionColumn = function() {
        // Wait for table to be fully rendered
        setTimeout(() => {
            const tableElement = document.querySelector('#export-table');
            if (!tableElement) return;

            // Add "Aksi" header
            const headerRow = tableElement.querySelector('thead tr');
            if (showActionButtons && headerRow && !headerRow.querySelector('th.aksi-header')) {
                const aksiHeader = document.createElement('th');
                aksiHeader.textContent = 'Aksi';
                aksiHeader.className = 'aksi-header text-center';
                headerRow.appendChild(aksiHeader);
            }

            // Add action buttons to each body row
            const bodyRows = tableElement.querySelectorAll('tbody tr');
            bodyRows.forEach((row, index) => {
                const firstCell = row.querySelector('td');
                if (firstCell) {
                    const id = firstCell.textContent.trim();
                    row.setAttribute('data-id', id);
                }

                if (showActionButtons && !row.querySelector('td.aksi-cell')) {
                    const aksiCell = document.createElement('td');
                    aksiCell.className = 'aksi-cell text-center';
                    aksiCell.innerHTML = `
                        <div class="flex space-x-2 justify-center">
                            <a onclick="viewData(${index})" 
                                    class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800 transition-all duration-200 shadow-sm hover:shadow-md" 
                                    title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            ${isEditable ? `
                            <a onclick="editData(${index})" 
                                    class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 shadow-sm hover:shadow-md" 
                                    title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a> `: ''}
                            ${isDeleteable ? `
                            <a onclick="deactivateData(${index})" 
                                    class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition-all duration-200 shadow-sm hover:shadow-md" 
                                    title="Hapus Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </a> `: ''}
                        </div>
                    `;
                    row.appendChild(aksiCell);
                }
            });
        }, 100);
    }

    // Get the table element to retrieve data attributes
    const tableElement = document.getElementById("export-table");
    window.createRoute = tableElement ? tableElement.dataset.createRoute : '#';
    window.resourceName = tableElement ? tableElement.dataset.resourceName : 'Baru';
    window.routeName = tableElement ? tableElement.dataset.routeName : '';
    window.isEditable = tableElement.dataset.editable === 'true';
    window.isDeleteable = tableElement.dataset.deleteable === 'true';
    window.userRole = tableElement.dataset.userRole || null;
    window.showActionButtons = tableElement.dataset.showAction !== 'false';


    const table = new simpleDatatables.DataTable("#export-table", {
        perPageSelect: [2, 5, 10, 20, 50],
        template: (options, dom) => "<div class='" + options.classes.top + "'>" +
            "<div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>" +
            // Start of the added button and export button group
            "<div class='flex items-center space-x-3 rtl:space-x-reverse'>" + // Added wrapper div for alignment
            "<button id='exportDropdownButton' type='button' class='flex w-full items-center justify-center rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:w-auto'>" +
            "Export as" +
            "<svg class='-me-0.5 ms-1.5 h-4 w-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>" +
            "<path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7' />" +
            "</svg>" +
            "</button>" +
            (createRoute !== '#' ?
            "<a href='" + createRoute + "' class=\"bg-[#161A30] text-white px-4 py-2 rounded-lg transition duration-200\">" +
            "+ Tambah " + resourceName +
            "</a>" : "") +
            "</div>" +
            // End of the added button and export button group
            "<div id='exportDropdown' class='z-10 hidden w-52 divide-y divide-gray-100 rounded-lg bg-white shadow-sm data-popper-placement='bottom'>" +
            "<ul class='p-2 text-left text-sm font-medium text-gray-500 ' aria-labelledby='exportDropdownButton'>" +
            "<li>" +
            "<button id='export-csv' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900'>" +
            "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
            "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z' clip-rule='evenodd'/>" +
            "</svg>" +
            "<span>Export CSV</span>" +
            "</button>" +
            "</li>" +
            "<li>" +
            "<button id='export-json' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900'>" +
            "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
            "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm-.293 9.293a1 1 0 0 1 0 1.414L9.414 14l1.293 1.293a1 1 0 0 1-1.414 1.414l-2-2a1 1 0 0 1 0-1.414l2-2a1 1 0 0 1 1.414 0Zm2.586 1.414a1 1 0 0 1 1.414-1.414l2 2a1 1 0 0 1 0 1.414l-2 2a1 1 0 0 1-1.414-1.414L14.586 14l-1.293-1.293Z' clip-rule='evenodd'/>" +
            "</svg>" +
            "<span>Export JSON</span>" +
            "</button>" +
            "</li>" +
            "<li>" +
            "<button id='export-txt' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900'>" +
            "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
            "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z' clip-rule='evenodd'/>" +
            "</svg>" +
            "<span>Export TXT</span>" +
            "</button>" +
            "</li>" +
            "<li>" +
            "<button id='export-sql' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900'>" +
            "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
            "<path d='M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z'/>" +
            "</svg>" +
            "<span>Export SQL</span>" +
            "</button>" +
            "</li>" +
            "</ul>" +
            "</div>" + "</div>" +
            (options.searchable ?
                "<div class='" + options.classes.search + "'>" +
                "<input class='" + options.classes.input + "' placeholder='" + options.labels.placeholder + "' type='search' title='" + options.labels.searchTitle + "'" + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
                "</div>" : ""
            ) +
            "</div>" +
            "<div class='" + options.classes.container + "'" + (options.scrollY.length ? " style='height: " + options.scrollY + "; overflow-Y: auto;'" : "") + "></div>" +
            "<div class='" + options.classes.bottom + "'>" +
            (options.paging ?
                "<div class='flex items-center'>" +
                "<div class='" + options.classes.info + "'></div>" +
                (options.paging && options.perPageSelect ?
                    "<div class='ml-6'>" +
                    "<select class='" + options.classes.selector + " rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50'></select>" +
                    "</div>" : ""
                ) +
                "</div>" : ""
            ) +
            "<nav class='" + options.classes.pagination + "'></nav>" +
            "</div>"
    })
    
    // Add action buttons after table is initialized
    table.on('datatable.init', () => {
        addActionColumn();
    });

    // Also add after pagination or search events
    table.on('datatable.page', () => {
        addActionColumn();
    });

    table.on('datatable.search', () => {
        addActionColumn();
    });

    table.on('datatable.sort', () => {
        addActionColumn();
    });
    
    const $exportButton = document.getElementById("exportDropdownButton");
    const $exportDropdownEl = document.getElementById("exportDropdown");
    const dropdown = new Dropdown($exportDropdownEl, $exportButton);

    document.getElementById("export-csv").addEventListener("click", () => {
        simpleDatatables.exportCSV(table, {
            download: true,
            lineDelimiter: "\n",
            columnDelimiter: ";"
        })
    })
    document.getElementById("export-sql").addEventListener("click", () => {
        simpleDatatables.exportSQL(table, {
            download: true,
            tableName: "export_table"
        })
    })
    document.getElementById("export-txt").addEventListener("click", () => {
        simpleDatatables.exportTXT(table, {
            download: true
        })
    })
    document.getElementById("export-json").addEventListener("click", () => {
        simpleDatatables.exportJSON(table, {
            download: true,
            space: 3
        })
    })
}

// Global functions for button actions
window.viewData = function(index) {
    const row = document.querySelectorAll('#export-table tbody tr')[index];
    const id = row ? row.dataset.id : null;
    if (window.routeName && id) {
        window.location.href = `/${window.routeName}/${id}`;
    }
};

window.editData = function(index) {
    const row = document.querySelectorAll('#export-table tbody tr')[index];
    const id = row ? row.dataset.id : null;
    if (window.routeName && id) {
        window.location.href = `/${window.routeName}/${id}/edit`;
    }
};

// Updated deactivateData function to use Alpine.js dialog
window.deactivateData = function(index) {
    const row = document.querySelectorAll('#export-table tbody tr')[index];
    const id = row ? row.dataset.id : null;
    const isSuperAdmin = window.userRole === 'SuperAdmin';
    const isDetailRoute = window.routeName === 'detail-gudangs';

    if (!isSuperAdmin && !isDetailRoute) {
        // Show error dialog using global dialog reference
        if (window.dialogBox) {
            window.dialogBox.openError('Akses ditolak. Hanya SuperAdmin yang dapat menghapus data.');
        } else {
            // Fallback jika dialog belum ready
            setTimeout(() => {
                if (window.dialogBox) {
                    window.dialogBox.openError('Akses ditolak. Hanya SuperAdmin yang dapat menghapus data.');
                }
            }, 200);
        }
        return;
    }

    if (window.routeName && id) {
        // Show confirmation dialog using global dialog reference
        if (window.dialogBox) {
            window.dialogBox.openConfirm(index, id);
        } else {
            // Fallback jika dialog belum ready
            setTimeout(() => {
                if (window.dialogBox) {
                    window.dialogBox.openConfirm(index, id);
                }
            }, 200);
        }
    }
};

// Function to be called when user confirms deletion
window.deactivateDataConfirmed = function(index, id) {
    const url = `/${window.routeName}/${id}/deactivate`;

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 403) {
            // Show error dialog
            if (window.dialogBox) {
                window.dialogBox.openError('Akses ditolak. Anda tidak memiliki izin untuk menghapus data ini.');
            }
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.status) {
            location.reload();
        } else {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error dialog
        if (window.dialogBox) {
            window.dialogBox.openError('Terjadi kesalahan saat menonaktifkan data.');
        }
    });
};