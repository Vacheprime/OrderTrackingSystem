
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


