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
        changePage(refreshOrderTable, page, parseInt(totalPages));
    } catch (error) {
        console.error("Failed to refresh order table:", error);
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
    changePage(refreshClientTable, page, parseInt(totalPages));
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
            initializeRowClickEvents(changeEmployeeDetails);
            highlightFirstRow();
            window.history.pushState({}, '', url);
        });
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
            func(1);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }
    // Add a go to previous page button if more than 1 page and not on the first page
    if (pages > 1 && page !== 1) {
        const button = createButton("paginated-prev-btn", "regular-button", "<", () => {
            changePage(func, page - 1, pages);
            func(page - 1);
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
                func(curPage, true);
            });
        // Append the button to the pagination div
        div.appendChild(button);
    }
    // Add a go to next page button if more than 1 page and not on the last page
    if (pages > 1 && pages - page > 0) {
        // Create a button for going to the next page
        const button = createButton("paginated-next-btn", "regular-button", ">", () => {
            changePage(func, page + 1, pages);
            func(page + 1);
        });
        // Append the button to the pagination div
        div.appendChild(button);
    }

    // Add a go to last page button if more than 5 pages and not on the last page
    if (pages > 5 && pages - page > 0) {
        // Create a button for going to the last page
        const button = createButton("paginated-next-btn", "regular-button", ">>", () => {
            changePage(func, pages, pages);
            func(pages);
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