
function searchTable() {
    const url = new URL(window.location.href);

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
