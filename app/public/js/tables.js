/**
 * Converts a string to kebab case.
 * 
 * @param {string} str - The string to convert to kebab case.
 * @returns {string} - The kebab case version of the string.
 */
function toKebabCase(str) {
    return str.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
}

// Change the sidebar details for a resource
// This function fetches the details for a resource and updates the sidebar
async function changeSidebarDetails(resourceId, resourceIdString, prefix = "detail-", afterUpdatePostProcess = null) {
    // Get the current URL
    const url = new URL(window.location.href);
    url.searchParams.set(resourceId, resourceIdString.substring(resourceIdString.lastIndexOf("-") + 1));
    // Fetch the details for the resource
    let response = await fetch(url, {
        headers: {
            method: "GET",
            'x-change-details': true,
        }
    });
    // Check if the response is ok
    if (!response.ok) {
        if (response.status === 401) {
            // Get the redirect URL from the response body
            const body = await response.json();
            const redirectUrl = body.redirectTo;
            window.location.href = redirectUrl;
        }
        return; // TODO: Handle error with error page?
    }
    // Get the JSON response
    let resourceDetails = await response.json();
    // Update the sidebar details
    updateDetailsFromJson(resourceDetails, prefix);
    // Execute additional function 
    if (typeof afterUpdatePostProcess === "function") {
        afterUpdatePostProcess(resourceDetails);
    }
}

/**
 * Updates the sidebar details from a JSON object.
 * @param {Object} json - The JSON object containing the details.
 * @param {string} prefix - The prefix for the detail IDs (default is "detail-").
 */
function updateDetailsFromJson(json, prefix = "detail-") {
    // Update the sidebar details from a JSON object
    Object.entries(json).forEach(([key, value]) => {
        // Get the element by ID
        const kebabKey = toKebabCase(key);
        const element = document.getElementById(`${prefix}${kebabKey}`);

        // Check if the element exists
        if (!element) return;

        // Update the element based on its type
        if (element.id === 'detail-fabrication-plan-image') {
            // Disable the link if the value is empty
            if (value === "-") {
                element.innerText = "No fabrication plan";
                element.classList.add("disabled-image");
                return;
            }
            // Reenable the link if the value is not empty
            element.classList.remove("disabled-image");
            // Set the link text
            element.innerText = "View Plan";
            // Set the href to the fabrication plan URL
            element.href = "plans/" + value;
        } else if ('value' in element) {
            element.value = value;
        } else {
            element.innerText = value;
        }
    });
}

/**
 * Changes the order details in the sidebar.
 * 
 * @param {string} orderIdString - The order ID string.
 */
function changeOrderDetails(orderIdString) {
    changeSidebarDetails("orderId", orderIdString, "detail-", (order) => {
        document.getElementById("detail-edit-btn").href = `/orders/${order.orderId}/edit`;
        document.getElementById("detail-add-payment-btn").href = `/payments/create?orderId=${order.orderId}`;
        document.getElementById("detail-product-description-input").innerText = order.productDescription;
        document.getElementById("detail-product-notes-input").innerText = order.productNotes;
    });
}

/**
 * Changes the client details in the sidebar.
 * 
 * @param {string} clientIdString - The client ID string.
 */
function changeClientDetails(clientIdString) {
    changeSidebarDetails("clientId", clientIdString, "detail-", (client) => {
        document.getElementById("detail-edit-btn").href = `/clients/${client.clientId}/edit`;
        document.getElementById("detail-add-order-btn").href = `/orders/create?client=existing&clientId=${client.clientId}`;
    });
}

/**
 * Changes the payment details in the sidebar.
 * 
 * @param {string} paymentIdString - The payment ID string.
 */
function changePaymentDetails(paymentIdString) {
    changeSidebarDetails("paymentId", paymentIdString, "detail-", (payment) => {
        document.getElementById("detail-edit-btn").href = `/payments/${payment.paymentId}/edit`;
        document.getElementById("detail-delete-form").action = `/payments/${payment.paymentId}`;
    });
}

/**
 * Changes the employee details in the sidebar.
 * 
 * @param {string} employeeIdString - The employee ID string.
 */
function changeEmployeeDetails(employeeIdString) {
    changeSidebarDetails("employeeId", employeeIdString, "detail-", (employee) => {
        document.getElementById("detail-edit-btn").href = `/employees/${employee.employeeId}/edit`;
    });
}

/**
 * Generic function to refresh a table for any resource.
 * @param {Object} options - Options for refreshing the table.
 * @param {string} options.resource - Resource name (e.g., 'order', 'client', 'employee', 'payment').
 * @param {number} options.page - Page number to fetch.
 * @param {boolean} options.isSearch - Whether this is a search action.
 * @param {Function} options.changeDetailsFunction - Function to update sidebar/details for a row.
 * @param {Array} options.searchFields - Array of objects: { param: 'search', elementId: 'search-bar-input' }.
 * @param {string} [options.tableSelector='.search-table-div'] - Selector for the table container.
 * @param {string} [options.paginationSelector='.search-table-pagination-div'] - Selector for pagination container.
 */
async function refreshTable({
    resource,
    page = 1,
    isSearch = false,
    changeDetailsFunction,
    searchFields = [
        { param: 'search', elementId: 'search-bar-input' },
        { param: 'searchby', elementId: 'search-by-select' },
        { param: 'orderby', elementId: 'order-by-select' }
    ],
    tableSelector = '.search-table-div',
    paginationSelector = '.search-table-pagination-div'
}) {
    const url = new URL(window.location.href);

    // Reset page if the query has changed
    page = isSearch ? 1 : page;

    // Set params
    url.searchParams.set('page', page);
    if (isSearch) {
        for (const field of searchFields) {
            const inputElem = document.getElementById(field.elementId);
            if (inputElem) url.searchParams.set(field.param, inputElem.value);
        }
    }

    // Fetch the table
    try {
        const response = await fetch(url, {
            headers: {
                'x-refresh-table': true,
                'Accept': 'application/json'
            }
        });
        const text = await response.text();

        // Remove previous errors
        document.querySelectorAll('.error-input').forEach(element => element.remove());

        // Handle validation errors (422)
        if (!response.ok && response.status == 422) {
            let jsonResponse = {};
            try { jsonResponse = JSON.parse(text); } catch {}
            let errors = jsonResponse.errors || {};
            Object.entries(errors).forEach(([field, errorMessages]) => {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    const firstError = errorMessages[0];
                    input.parentElement.innerHTML += `<p class="error-input">${firstError}</p>`;
                }
            });
            return;
        }
        // Handle unauthorized access (401)
        if (response.status === 401) {
            // Get the redirect URL from the response body
            const body = JSON.parse(text);
            const redirectUrl = body.redirectTo;
            window.location.href = redirectUrl;
            return;
        }

        // Update table and URL
        window.history.pushState({}, '', url);
        document.querySelector(tableSelector).innerHTML = text;

        // Row click events and highlight
        initializeRowClickEvents(changeDetailsFunction);
        highlightFirstRow(changeDetailsFunction);

        // Pagination
        const totalPages = parseInt(response.headers.get("x-total-pages") || "1");
        changePage(
            (p, s) => refreshTable({
                resource,
                page: p,
                isSearch: !!s,
                changeDetailsFunction,
                searchFields,
                tableSelector,
                paginationSelector
            }),
            page,
            totalPages
        );
    } catch (error) {
        console.error(`Failed to refresh ${resource} table:`, error);
    }
}

function changePage(func, page, pages) {
    // Create a helper function to create a button
    function createButton(id, classNames, text, onClick) {
        const button = document.createElement("button");
        button.id = id;
        // Accept array of classes or a single class name
        if (Array.isArray(classNames) && classNames.length > 0) {
            button.classList.add(...classNames.filter(cls => cls != ""));
        } else if (typeof classNames === "string") {
            button.className = classNames;
        }
        button.innerHTML = text;
        button.onclick = onClick;
        return button;
    }

    // Validate the page number
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }

    // Get the pagination div
    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";

    // Add a go to first page button if more than 5 pages and not on the first page
    if (pages > 5 && page !== 1) {
        // Create a button for going to the first page
        const button = createButton("paginated-prev-btn", "regular-button", "<<", () => {
            changePage(func, 1, pages);
            func(1, false);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }
    // Add a go to previous page button if more than 1 page and not on the first page
    if (pages > 1 && page !== 1) {
        const button = createButton("paginated-prev-btn", "regular-button", "<", () => {
            changePage(func, page - 1, pages);
            func(page - 1, false);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }
    let firstPage = 1;
    let lastPage = pages;
    if (pages > 5) {
        let firstPage = page - 2;
        let lastPage = page + 2;
        if (firstPage <= 0) {
            if (firstPage <= -1) {
                lastPage += 2;
            } else {
                lastPage += 1
            }
            firstPage = 1;
        } else if (lastPage >= pages) {
            if (lastPage >= pages + 2) {
                firstPage -= 2;
            } else {
                firstPage -= 1
            }
            lastPage = pages;
        }
    }
    // Generate buttons for each page in the range
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        console.log("Creating button for page:", curPage);
        // Create a button for going to the specified page
        const button = createButton(`paginated-btn-${curPage}`,
            ["paginated-btn", "regular-button", page === curPage ? "" : "paginated-inactive"],
            curPage,
            () => {
                changePage(func, curPage, pages);
                func(curPage, false);
            });
        // Append the button to the pagination div
        div.appendChild(button);
    }
    // Add a go to next page button if more than 1 page and not on the last page
    if (pages > 1 && pages - page > 0) {
        // Create a button for going to the next page
        const button = createButton("paginated-next-btn", "regular-button", ">", () => {
            changePage(func, page + 1, pages);
            func(page + 1, false);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }

    // Add a go to last page button if more than 5 pages and not on the last page
    if (pages > 5 && pages - page > 0) {
        // Create a button for going to the last page
        const button = createButton("paginated-next-btn", "regular-button", ">>", () => {
            changePage(func, pages, pages);
            func(pages, false);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }

    // Add a go to page input if more than 5 pages
    // Should this be kept?
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
        placeholder="Go Page"/></div><button class="regular-button"
        onclick="changePage(${func}, parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
    }
}

/* This is to highlight the selected row*/
function selectRecord(record) {
    record.classList.remove('active');
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        if (row !== record) {
            row.classList.add('inactive');
        } else {
            row.classList.remove('inactive');
            record.classList.add('active');
        }
    });
}

// This is to initialize row click events
function initializeRowClickEvents(changeDetailsFunction) {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changeDetailsFunction(row.id);
        });
    });
}

/**
 * Highlights the first row in the table and calls the provided function with the row id.
 * @param {Function|null} changeDetailsFunction - The function to call with the first row's id, or null.
 */
function highlightFirstRow(changeDetailsFunction = null) {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
        if (typeof changeDetailsFunction === "function") {
            changeDetailsFunction(firstRow.id);
        }
    }
}

/**
 * Refreshes the order table.
 * 
 * @param {number} [page=1] - The page number to refresh.
 * @param {boolean} [isSearch=false] - Whether this is a search action.
 */
async function refreshOrderTable(page = 1, isSearch = false) {
    refreshTable({
        resource: 'order',
        page,
        isSearch,
        changeDetailsFunction: changeOrderDetails,
        searchFields: [
            { param: 'search', elementId: 'search-bar-input' },
            { param: 'searchby', elementId: 'search-by-select' },
            { param: 'orderby', elementId: 'order-by-select' }
        ],
        tableSelector: '.search-table-div',
        paginationSelector: '.search-table-pagination-div'
    });
}

/**
 * Refreshes the client table.
 * 
 * @param {number} [page=1] - The page number to refresh.
 * @param {boolean} [isSearch=false] - Whether this is a search action.
 */
async function refreshClientTable(page = 1, isSearch = false) {
    refreshTable({
        resource: 'client',
        page,
        isSearch,
        changeDetailsFunction: changeClientDetails,
        searchFields: [
            { param: 'search', elementId: 'search-bar-input' },
            { param: 'searchby', elementId: 'search-by-select' },
            { param: 'orderby', elementId: 'order-by-select' }
        ],
        tableSelector: '.search-table-div',
        paginationSelector: '.search-table-pagination-div'
    });
}

/**
 * Refreshes the employee table.
 * 
 * @param {number} [page=1] - The page number to refresh.
 * @param {boolean} [isSearch=false] - Whether this is a search action.
 */
async function refreshEmployeeTable(page = 1, isSearch = false) {
    refreshTable({
        resource: 'employee',
        page,
        isSearch,
        changeDetailsFunction: changeEmployeeDetails,
        searchFields: [
            { param: 'search', elementId: 'search-bar-input' },
            { param: 'searchby', elementId: 'search-by-select' },
            { param: 'orderby', elementId: 'order-by-select' }
        ],
        tableSelector: '.search-table-div',
        paginationSelector: '.search-table-pagination-div'
    });
}

/**
 * Refreshes the payment table.
 * 
 * @param {number} [page=1] - The page number to refresh.
 * @param {boolean} [isSearch=false] - Whether this is a search action.
 */
async function refreshPaymentTable(page = 1, isSearch = false) {
    refreshTable({
        resource: 'payment',
        page,
        isSearch,
        changeDetailsFunction: changePaymentDetails,
        searchFields: [
            { param: 'search', elementId: 'search-bar-input' },
            { param: 'searchby', elementId: 'search-by-select' },
            { param: 'orderby', elementId: 'order-by-select' }
        ],
        tableSelector: '.search-table-div',
        paginationSelector: '.search-table-pagination-div'
    });
}