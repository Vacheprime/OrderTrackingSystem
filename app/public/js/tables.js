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


function refreshOrderTable() {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
    // url.searchParams.set('searchby', document.getElementById("search-by-input").value);
    // url.searchParams.set('orderby', document.getElementById("order-by-input").value);

    fetch(url, {
        headers: {
            'x-refresh-table': true,
        }
    }).then(response => response.text())
        .then(text => {
            window.history.pushState({}, '', url);
            document.querySelector(".search-table-div").innerHTML = text;
            initializeOrderRowClickEvents();
            highlightOrderFirstRow();
        });
}

function refreshClientTable() {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
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


function refreshEmployeeTable() {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
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


function refreshPaymentTable() {
    const url = new URL(window.location.href);
    url.searchParams.set('search', document.getElementById("search-bar-input").value);
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
