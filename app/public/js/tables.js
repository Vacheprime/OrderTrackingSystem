function changeOrderDetails(orderIdString) {
    const url = new URL(window.location.href);
    url.searchParams.set('orderId', orderIdString.substring(orderIdString.lastIndexOf("-") + 1));
    fetch(url, {
        headers: {
            method: "GET",
            'x-change-details': true,
        }
    }).then(response => response.json())
        .then(order => {
            document.getElementById("detail-edit-btn").href = `/orders/${order.orderId}/edit`;
            document.getElementById("detail-add-payment-btn").href = `/payments/create?orderId=${order.orderId}`;
            document.getElementById("detail-order-id").innerText = order.orderId;
            document.getElementById("detail-client-id").innerText = order.clientId;
            document.getElementById("detail-measured-by").innerText = order.measuredBy;
            document.getElementById("detail-reference-number").innerText = order.referenceNumber;
            document.getElementById("detail-invoice-number").innerText = order.invoiceNumber;
            document.getElementById("detail-total-price").innerText = order.totalPrice;
            document.getElementById("detail-status").innerText = order.orderStatus;
            document.getElementById("detail-fabrication-start-date").innerText = order.fabricationStartDate;
            document.getElementById("detail-installation-start-date").innerText = order.installationStartDate;
            document.getElementById("detail-pick-up-date").innerText = order.pickUpDate;
            // document.getElementById("detail-material-name").innerText = order.materialName;
            // document.getElementById("detail-slab-height").innerText = order.slabHeight;
            // document.getElementById("detail-slab-width").innerText = order.slabWidth;
            // document.getElementById("detail-slab-height").innerText = order.slabHeight;
            // document.getElementById("slab-thickness").innerText = order.slabThickness;
            // document.getElementById("detail-slab-square-footage").innerText = order.slabSquareFootage;
            // document.getElementById("detail-fabrication-plan-image").attributes.setNamedItem("src", order.fabricationPlanImage);
            // document.getElementById("detail-product-description").innerText = order.productDescription;
            // document.getElementById("detail-product-notes").innerText = order.productNotes;
        });
}

function changeClientDetails(clientIdString) {
    const url = new URL(window.location.href);
    url.searchParams.set('clientId', clientIdString.substring(clientIdString.lastIndexOf("-") + 1));
    fetch(url, {
        headers: {
            method: "GET",
            'x-change-details': true,
        }
    }).then(response => response.json())
        .then(client => {
            document.getElementById("detail-edit-btn").href = `/clients/${client.clientId}/edit`;
            document.getElementById("detail-add-order-btn").href = `/orders/create?clientId=${client.clientId}`;
            document.getElementById("detail-client-id").innerText = client.clientId;
            document.getElementById("detail-first-name").innerText = client.firstName;
            document.getElementById("detail-last-name").innerText = client.lastName;
            document.getElementById("detail-reference-number").innerText = client.referenceNumber;
            document.getElementById("detail-phone-number").innerText = client.phoneNumber;
            document.getElementById("detail-address").innerText = client.address;
            document.getElementById("detail-postal-code").innerText = client.postalCode;
            document.getElementById("detail-city").innerText = client.city;
            document.getElementById("detail-province").innerText = client.province;
            document.getElementById("detail-area").innerText = client.area;
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
            document.getElementById("detail-hired-date").innerText = employee.hiredDate;
            document.getElementById("detail-position").innerText = employee.position;
            document.getElementById("detail-email").innerText = employee.email;
            document.getElementById("detail-phone-number").innerText = employee.phoneNumber;
            document.getElementById("detail-address").innerText = employee.address;
            document.getElementById("detail-postal-code").innerText = employee.postalCode;
            document.getElementById("detail-city").innerText = employee.city;
            document.getElementById("detail-province").innerText = employee.province;
            document.getElementById("detail-account-status").innerText = employee.accountStatus;
        });
}


function changePaymentDetails(paymentIdString) {
    const url = new URL(window.location.href);
    url.searchParams.set('paymentId', paymentIdString.substring(paymentIdString.lastIndexOf("-") + 1));
    fetch(url, {
        headers: {
            method: "GET",
            'x-change-details': true,
        }
    }).then(response => response.json())
        .then(payment => {
            document.getElementById("detail-edit-btn").href = `/payments/${payment.paymentId}/edit`;
            document.getElementById("detail-payment-id").innerText = payment.paymentId;
            document.getElementById("detail-order-id").innerText = payment.orderId;
            document.getElementById("detail-payment-date").innerText = payment.paymentDate;
            document.getElementById("detail-amount").innerText = payment.amount;
            document.getElementById("detail-type").innerText = payment.type;
            document.getElementById("detail-method").innerText = payment.method;
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


async function refreshOrderTable(page) {
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
    let queryHasChanged = !(search == newSearch && searchBy == newSearchBy && orderBy == newOrderBy);
    // Set the page
    console.log(queryHasChanged);
    page = queryHasChanged ? 1 : page;
    console.log(page);

    // Set the url parameters
    url.searchParams.set('search', newSearch);
    url.searchParams.set('page', page);
    url.searchParams.set('searchby', newSearchBy);
    url.searchParams.set('orderby', newOrderBy);

    // Fetch the new table
    fetch(url, {
        headers: {
            'x-refresh-table': true,
        }
    }).then(response => {
 
        if (response.status === 300) {
            return response.text().then(text => {
                document.querySelector("#search-bar-input").parentElement.innerHTML +=
                    `<p class="error-input">${text}</p>`;
            });
        }

        document.querySelectorAll('.error-input').forEach(element => element.remove());
        return response.text().then(text => {
            window.history.pushState({}, '', url);
            document.querySelector(".search-table-div").innerHTML = text;
            initializeOrderRowClickEvents();
            highlightOrderFirstRow();
            // Get the number of pages
            const totalPages = response.headers.get("x-total-pages");
            // Update the pagination buttons
            changeOrderPage(page, parseInt(totalPages), false);
        });
    });
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
        refreshOrderTable(page);
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

function refreshClientTable(page) {
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
            initializeClientRowClickEvents();
            highlightClientFirstRow()
            window.history.pushState({}, '', url);
        });
}

function changeClientPage(page, pages) {
    if (page <= 0) {
        page = 1;
    }
    if (page > pages) {
        page = pages;
    }
    refreshClientTable(page);
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

function refreshEmployeeTable(page) {
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
            highlightEmployeeFirstRow();
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
    refreshEmployeeTable(page);
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

function refreshPaymentTable(page) {
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
            initializePaymentRowClickEvents();
            highlightPaymentFirstRow();
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
    refreshPaymentTable(page);
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

// This is to initialize row click events
function initializeOrderRowClickEvents() {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changeOrderDetails(row.id);
        });
    });
}

function initializeClientRowClickEvents() {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changeClientDetails(row.id);
        });
    });
}

function initializePaymentRowClickEvents() {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changePaymentDetails(row.id);
        });
    });
}

function initializeEmployeeRowClickEvents() {
    document.querySelectorAll('.search-table tbody tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
            changeEmployeeDetails(row.id);
        });
    });
}

// to highlight the first row by default
function highlightOrderFirstRow() {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
        changeOrderDetails(firstRow.id);
    }
}

function highlightClientFirstRow() {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
        changeClientDetails(firstRow.id);
    }
}

function highlightEmployeeFirstRow() {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
        changeEmployeeDetails(firstRow.id);
    }
}

function highlightPaymentFirstRow() {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
        changePaymentDetails(firstRow.id)
    }
}
