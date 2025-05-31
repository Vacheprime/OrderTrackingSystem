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
    // Log the resource details for debugging
    console.log(resourceDetails);
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
        if (element.tagName === 'IMG') {
            element.src = value;
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
    });
}

function changeEmployeeDetails(employeeIdString) {
    const url = new URL(window.location.href);
    url.searchParams.set('employeeId', employeeIdString.substring(employeeIdString.lastIndexOf("-") + 1));
    fetch(url, {
        headers: {
            method: "GET",
            'x-change-details': true,
        }
    }).then(response => response.json())
        .then(employee => {
            document.getElementById("detail-edit-btn").href = `/employees/${employee.employeeId}/edit`;
            document.getElementById("detail-employee-id").innerText = employee.employeeId;
            document.getElementById("detail-initials").innerText = employee.initials;
            document.getElementById("detail-first-name").innerText = employee.firstName;
            document.getElementById("detail-last-name").innerText = employee.lastName;
            document.getElementById("detail-position").innerText = employee.position;
            document.getElementById("detail-email").innerText = employee.email;
            document.getElementById("detail-phone-number").innerText = employee.phoneNumber;
            document.getElementById("detail-address-street").innerText = employee.addressStreet;
            document.getElementById("detail-address-apt-num").innerText = employee.addressAptNum;
            document.getElementById("detail-postal-code").innerText = employee.postalCode;
            document.getElementById("detail-area").innerText = employee.area;
            document.getElementById("detail-account-status").innerText = employee.accountStatus;
            document.getElementById("detail-admin-status").innerText = employee.adminStatus;
        });
}

function changePage(func, page, pages) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }
    func(page);
    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";
    if (pages > 5 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onclick="changePage(${func}, 1, ${pages})"><<</button>`
    }
    if (pages > 1 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onclick="changePage(${func}, ${page - 1}, ${pages})"><</button>`
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
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        div.innerHTML += `<button id="paginated-btn-${curPage}"
            class="paginated-btn regular-button ${page === curPage ? "" : "paginated-inactive"}"
            onclick="changePage(${func}, ${curPage}, ${pages})">${curPage}</button>`

    }
    if (pages > 1 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button"
            onclick="changePage(${func}, ${page + 1}, ${pages})">></button>`;
    }
    if (pages > 5 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button"
            onclick="changePage(${func}, ${pages}, ${pages})">>></button>`;
    }
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
        placeholder="Go Page"/></div><button class="regular-button"
        onclick="changePage(${func}, parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
    }
}


async function refreshOrderTable(page, isSearch) {
    // Current url
    const url = new URL(window.location.href);
    // Get current query parameters
    const search = url.searchParams.get('search');
    const searchBy = url.searchParams.get('searchby');
    const orderBy = url.searchParams.get('orderby');
    // Get the new query parameters if applicable
    const newSearch = document.getElementById("search-bar-input").value;
    const newSearchBy = document.getElementById("search-by-select").value;
    const newOrderBy = document.getElementById("order-by-select").value;

    // Check whether the query params have changed
    console.log(search , newSearch, searchBy , newSearchBy, orderBy , newOrderBy)
    let queryHasChanged = !(search == newSearch || search == null && searchBy == newSearchBy || searchBy == null && orderBy == newOrderBy || orderBy == null);
    // Set the page
    page = queryHasChanged ? 1 : page;

    // Set the url parameters
    url.searchParams.set('page', page);
    if (isSearch) {
        url.searchParams.set('search', newSearch);
        url.searchParams.set('searchby', newSearchBy);
        url.searchParams.set('orderby', newOrderBy);
    }

    // Fetch the new table
    try {
        const response = await fetch(url, {
            headers: {
                'x-refresh-table': true,
            }
        });

        if (response.status === 300) {
            const text = await response.text();
            document.querySelector("#search-bar-input").parentElement.innerHTML +=
                `<p class="error-input">${text}</p>`;
            return;
        }

        document.querySelectorAll('.error-input').forEach(element => element.remove());
        const text = await response.text();
        window.history.pushState({}, '', url);
        document.querySelector(".search-table-div").innerHTML = text;
        initializeRowClickEvents(changeOrderDetails);
        highlightFirstRow(changeOrderDetails);
        // Get the number of pages
        const totalPages = response.headers.get("x-total-pages");
        // Update the pagination buttons
        changeOrderPage(page, parseInt(totalPages), false);
    } catch (error) {
        console.error("Failed to refresh order table:", error);
    }
}

function changeOrderPage(page, pages, refreshTable = true) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }

    // Only refresh if necessary
    if (refreshTable) {
        refreshOrderTable(page, false);
    }

    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";
    if (pages > 5 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onclick="changeOrderPage(1, ${pages})"><<</button>`
    }
    if (pages > 1 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onclick="changeOrderPage(${page - 1}, ${pages})"><</button>`
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
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        div.innerHTML += `<button id="paginated-btn-${curPage}"
                            class="paginated-btn regular-button ${page === curPage ? "" : "paginated-inactive"}"
                            onclick="changeOrderPage(${curPage}, ${pages})">${curPage}</button>`

    }
    if (pages > 1 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeOrderPage(${page + 1}, ${pages})">></button>`;
    }
    if (pages > 5 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeOrderPage(${pages}, ${pages})">>></button>`;
    }
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
                                                            placeholder="Go Page"/></div><button class="regular-button" onclick="changeOrderPage(parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
    }
}

async function refreshClientTable(page, isSearch) {
    // Current URL
    const url = new URL(window.location.href);
    // Get the current query params
    const search = url.searchParams.get("search");
    const searchBy = url.searchParams.get("searchby");
    // Get the new query params
    const newSearch = document.getElementById("search-bar-input").value;
    const newSearchBy = document.getElementById("search-by-select").value;

    // Check whether query has changed
    let queryHasChanged = search != newSearch || searchBy != newSearchBy;

    // Set the page. If query changed, reset to 1.
    page = queryHasChanged ? 1 : page;

    // Set params if it is a search
    if (isSearch) {
        url.searchParams.set('search', newSearch);
        url.searchParams.set('searchby', newSearchBy);
    }
    url.searchParams.set('page', page);
    
    // Fetch the results
    let response = await fetch(url, {
        headers: {
            'Accept': "application/json",
            'x-refresh-table': true,
        }
    });

    // Get the body of the response
    let text = await response.text();

    // Remove previous errors
    if (isSearch) {
        document.querySelectorAll('.error-input').forEach(element => element.remove());
    }
    
    // Check if an error occured
    if (!response.ok) {
        if (response.status == 422) {
            // Display errors
            let jsonReponse = JSON.parse(text);
            let errors = jsonReponse.errors;
            // Loop over every field
            Object.entries(errors).forEach(([field, errorMessages]) => {
                // Get the input
                const input = document.querySelector(`[name="${field}"]`);
                // Get the first error message
                const firstError = errorMessages[0];
                // Add the error message
                input.parentElement.innerHTML += `<p class="error-input">${firstError}</p>`;
            })
            // End
            return;
        }
    }

    // Push the new URL
    window.history.pushState({}, '', url);

    // Set the table to the new table
    document.querySelector(".search-table-div").innerHTML = text;

    // Get number of pages
    const totalPages = response.headers.get("x-total-pages");

    // Add event handlers for row clicks and select the first row
    initializeRowClickEvents(changeClientDetails);

    // Check if there are any results
    updateDetailsFunc = !response.headers.get("x-is-empty") ? null : changeClientDetails;
    highlightFirstRow(changeClientDetails);
    
    // Update the pagination buttons
    changeClientPage(page, parseInt(totalPages), false);
}

function changeClientPage(page, pages, refreshTable = true) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }
    // Refresh only if necessary
    if (refreshTable) {
        refreshClientTable(page, false);
    }
    
    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";
    if (pages > 5 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changeClientPage(1, ${pages})"><<</button>`
    }
    if (pages > 1 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changeClientPage(${page - 1}, ${pages})"><</button>`
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
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        div.innerHTML += `<button id="paginated-btn-${curPage}"
                            class="paginated-btn regular-button ${page === curPage ? "" : "paginated-inactive"}"
                            onclick="changeClientPage(${curPage}, ${pages})">${curPage}</button>`

    }
    if (pages > 1 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeClientPage(${page + 1}, ${pages})">></button>`;
    }
    if (pages > 5 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeClientPage(${pages}, ${pages})">>></button>`;
    }
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
                                                            placeholder="Go Page"/></div><button class="regular-button" onclick="changeClientPage(parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
    }
}

function refreshEmployeeTable(page, isSearch) {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
    url.searchParams.set('page', page);
    // url.searchParams.set('searchby', document.getElementById("search-by-input").value);
    // url.searchParams.set('orderby', document.getElementById("order-by-input").value);

    fetch(url, {
        headers: {
            'x-refresh-table': true,
        }
    }).then(response => response.text())
        .then(text => {
            document.querySelector(".search-table-div").innerHTML = text;
            initializeEmployeeRowClickEvents();
            highlightFirstRow();
            window.history.pushState({}, '', url);
        });
}

function changeEmployeePage(page, pages) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }
    refreshEmployeeTable(page, false);
    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";
    if (pages > 5 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changeEmployeePage(1, ${pages})"><<</button>`
    }
    if (pages > 1 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changeEmployeePage(${page - 1}, ${pages})"><</button>`
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
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        div.innerHTML += `<button id="paginated-btn-${curPage}"
                            class="paginated-btn regular-button ${page === curPage ? "" : "paginated-inactive"}"
                            onclick="changeEmployeePage(${curPage}, ${pages})">${curPage}</button>`

    }
    if (pages > 1 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeEmployeePage(${page + 1}, ${pages})">></button>`;
    }
    if (pages > 5 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changeEmployeePage(${pages}, ${pages})">>></button>`;
    }
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
                                                            placeholder="Go Page"/></div><button class="regular-button" onclick="changeEmployeePage(parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
    }
}

function refreshPaymentTable(page, isSearch) {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
    url.searchParams.set('page', page);
    // url.searchParams.set('searchby', document.getElementById("search-by-input").value);
    // url.searchParams.set('orderby', document.getElementById("order-by-input").value);

    fetch(url, {
        headers: {
            'x-refresh-table': true,
        }
    }).then(response => response.text())
        .then(text => {
            document.querySelector(".search-table-div").innerHTML = text;
            initializeRowClickEvents(changePaymentDetails);
            highlightFirstRow(changePaymentDetails);
            window.history.pushState({}, '', url);
        });
}

function changePaymentPage(page, pages) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }
    refreshPaymentTable(page, false);
    const div = document.querySelector(".search-table-pagination-div");
    div.innerHTML = "";
    if (pages > 5 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changePaymentPage(1, ${pages})"><<</button>`
    }
    if (pages > 1 && page !== 1) {
        div.innerHTML += `<button id="paginated-prev-btn" class="regular-button"
                onClick="changePaymentPage(${page - 1}, ${pages})"><</button>`
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
    for (let curPage = firstPage; curPage <= lastPage; curPage++) {
        div.innerHTML += `<button id="paginated-btn-${curPage}"
                            class="paginated-btn regular-button ${page === curPage ? "" : "paginated-inactive"}"
                            onclick="changePaymentPage(${curPage}, ${pages})">${curPage}</button>`

    }
    if (pages > 1 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changePaymentPage(${page + 1}, ${pages})">></button>`;
    }
    if (pages > 5 && pages - page > 0) {
        div.innerHTML += `<button id="paginated-next-btn" class="regular-button" onclick="changePaymentPage(${pages}, ${pages})">>></button>`;
    }
    if (pages > 5) {
        div.innerHTML += `<div class="text-input-property-div"><input pattern="[0-9]" id="go-page-input" name="go-page"
                                                            placeholder="Go Page"/></div><button class="regular-button" onclick="changePaymentPage(parseInt(document.querySelector('#go-page-input').value), ${pages})">Go</button>`
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

// Kept for compatibility with the old code
function initializeEmployeeRowClickEvents() {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changeEmployeeDetails(row.id);
        });
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