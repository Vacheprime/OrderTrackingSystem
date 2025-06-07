function withConfirmation(message, callback) {
    const title = 'Confirmation Required';

    // Check if a confirmation dialog already exists and remove it
    let existingDialog = document.getElementById('js-confirmation-dialog');
    if (existingDialog) {
        existingDialog.remove();
    }

    // Create dialog element
    const dialog = document.createElement('dialog');
    dialog.id = 'js-confirmation-dialog';
    dialog.className = 'confirmation-dialog';

    // Build dialog HTML
    dialog.innerHTML = `
        <div class="confirmation-container">
            <div class="confirmation-header">
                <h3>${title}</h3>
            </div>
            
            <div class="confirmation-body">
                <p>${message}</p>
            </div>
            
            <div class="confirmation-actions">
                <button type="button" class="btn confirm-yes">Confirm</button>
                <button type="button" class="btn confirm-no">Cancel</button>
            </div>
        </div>
    `;

    // Add dialog to the body
    document.body.appendChild(dialog);

    // Setup event handlers
    const confirmBtn = dialog.querySelector('.confirm-yes');
    const cancelBtn = dialog.querySelector('.confirm-no');

    // Cancel the operation
    cancelBtn.addEventListener('click', () => {
        dialog.close();
    });

    // Confirm the operation
    confirmBtn.addEventListener('click', () => {
        dialog.close();
        callback(); // Call the provided callback function
        console.log('Operation confirmed');
    });

    // Show the dialog
    dialog.showModal();
}
