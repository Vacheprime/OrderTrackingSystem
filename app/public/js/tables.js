/* The following method is simply for refreshing the table based on the filters and search inputs*/
function resetClientTable() { 
    const url = new URL(window.location.href);
    // /clients/filterby/{filterby}/searchby/{searchby}/searchinput/{searchinput}/selectedid/{selectedid}
    url.searchParams.set('value', document.getElementById("select-input").value);
    url.searchParams.set('value', document.getElementById("search-by").value);
    url.searchParams.set('value', document.getElementById("filter-by").value);

    fetch (url, {
        headers: {
            // in web.php include a thing that returns only the table when refreshes.
            // https://youtu.be/Fuz-jLIo2g8?si=S4ZrQbpS6BIPviq3&t=320
            'x-refresh': true
        }
    })
        .then(response => response.text)
        .then(text => {
            document.getElementById('value').innerHTML = text;
            initializeRowClickEvents(); // Reinitialize row click events
            window.history.pushState({}, '', url);
        });
}

function selectClientEntry(clientid) {
    const url = new URL(window.location.href);
    url.searchParams.set('value', clientid)
    fetch (url, {
        headers: {
            // in web.php include a thing that returns only the table when refreshes.
            'x-clicked':true
        }
    })
        .then(response => response.text)
        .then(text => {
            document.getElementById('value').innerHTML = text;
            window.history.pushState({}, '', url);
        });
}

/* This is to highlight the selected row*/
function selectRecord(record) {
    record.classList.add('active');
    document.querySelectorAll('tr').forEach((row) => {
        if (row !== record) {
            row.classList.add('inactive');
        } else {
            row.classList.remove('inactive');
        }
    });
}

// This is to initialize row click events
function initializeRowClickEvents() {
    document.querySelectorAll('tr').forEach((row) => {
        row.addEventListener('click', function () {
            selectRecord(row);
        });
    });
}

// to highlight the first row by default
function highlightFirstRow() {
    const firstRow = document.querySelector('.search-table tbody tr');
    if (firstRow) {
        selectRecord(firstRow);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    initializeRowClickEvents(); 
    highlightFirstRow();
});
