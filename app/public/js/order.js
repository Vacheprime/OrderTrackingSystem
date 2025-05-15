function toggleInput(value) {
    if (!value) {
        document.getElementById("client-id-input").parentElement.remove();
        document.getElementById("client-id-btn").remove();
    } else {
        const url = new URL(window.location.href);
        fetch(url, {
            headers: {
                'x-add-client-input': true,
            }
        }).then(response => response.text()).then(text => {
                document.querySelector("#order-details-h3").innerHTML += `<button id="client-id-btn" type="button" onclick="togglePanel(true)">Create New Client?</button>`;
                document.querySelector("#order-details-div").innerHTML = text + document.querySelector("#order-details-div").innerHTML;
            }
        );
    }
}

function togglePanel(value) {
    if (!value) {
        document.getElementById("orders-create-side-content").remove();
        toggleInput(true);
    } else {
        const url = new URL(window.location.href);
        fetch(url, {
            headers: {
                'x-add-client-panel': true,
            }
        }).then(response => response.text()).then(text => {
                toggleInput(false);
                document.querySelector(".create-edit-form").innerHTML += text
            }
        );
    }
}
