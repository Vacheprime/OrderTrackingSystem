// Button event handler for displaying the client side panel
// This method shows the client info side panel, hides the client ID input,
// and hides the create new client button.
function showClientSidePanel() {
    // Get the current URL and append the client query string.
    // This is so that when the page reloads, the client side panel
    // stays visible.
    const url = new URL(window.location.href);
    url.searchParams.set("client", "new");
    window.history.pushState({}, '', url);

    // Get the side panel, client ID field, and create client button
    sidePanel = document.getElementById("orders-create-side-content");
    clientIdField = document.getElementById("client-id-input");
    clientIdFieldContainer = document.querySelector("div.text-input-property-div:has(input#client-id-input)");
    newClientButton = document.getElementById("client-id-btn");

    // Disable and hide the client ID field and new client button
    clientIdField.disabled = true;
    clientIdFieldContainer.style.display = "none";
    newClientButton.style.display = "none";
    
    // Get all of the side panel's inputs
    inputs = document.querySelectorAll("div#orders-create-side-content input");
    console.log(inputs);
    
    // Show the side panel and enable all fields
    sidePanel.style.display = "";
    inputs.forEach(field => {
        field.disabled = false;
    });

    // Set the value of the create option input
    createOption = document.getElementById("create-option-input");
    createOption.value = "0";
}

function hideClientSidePanel() {
    // Get the current URL and append the client query string.
    // This is so that when the page reloads, the client side panel
    // stays closed.
    const url = new URL(window.location.href);
    url.searchParams.set("client", "existing");
    window.history.pushState({}, '', url);

    // Get the side panel, client ID field, and create client button
    sidePanel = document.getElementById("orders-create-side-content");
    clientIdField = document.getElementById("client-id-input");
    clientIdFieldContainer = document.querySelector("div.text-input-property-div:has(input#client-id-input)");
    newClientButton = document.getElementById("client-id-btn");

    // Enable and show the client ID field and new client button
    clientIdField.disabled = false;
    clientIdFieldContainer.style.display = ""; // Revert to CSS
    newClientButton.style.display = ""; // Revert to CSS

    // Get all of the side panel's inputs
    inputs = document.querySelectorAll("div#orders-create-side-content input");
    console.log(inputs);

    // Hide the client side panel and disable its inputs
    sidePanel.style.display = "none";
    inputs.forEach(field => {
        field.disabled = true;
        field.style.display = "";
    })

    // Set the value of the create option input
    createOption = document.getElementById("create-option-input");
    createOption.value = "1";
}
