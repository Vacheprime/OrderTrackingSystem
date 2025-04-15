<?php

function SaveChangesConfirmationDialogBox() {
    echo '<div class="dialog">
    <h1 class="title">Save Changes</h1>
    <p class="text">Are you sure you want to save your updates? This will overwrite the existing content.</p>
    <button class="executeButton">Save</button>
    <button class="cancelButton">Cancel</button>
    </div>';
}

function DeleteOrderConfirmationDialogBox() {
    echo '<div class="dialog">
    <h1 class="title">Delete Order</h1>
    <p class="text">You are about to permanently delete this order. This action cannot be reversed. Please confirm to proceed.</p>
    <button class="executeButton">Delete</button>
    <button class="cancelButton">Cancel</button>
    </div>';
}

function DeletePaymentConfirmationDialogBox() {
    echo '<div class="dialog">
    <h1 class="title">Delete Payment</h1>
    <p class="text">You are about to permanently delete this payment. This action cannot be reversed. Please confirm to proceed.</p>
    <button class="executeButton">Delete</button>
    <button class="cancelButton">Cancel</button>
    </div>';
}

function CancelChangesConfirmationDialogBox() {
    echo '<div class="dialog">
    <h1 class="title">Cancel Changes</h1>
    <p class="text">If you cancel now, any unsaved changes will be lost. Are you sure you want to continue without saving?</p>
    <button class="executeButton">Discard Changes</button>
    <button class="cancelButton">Cancel</button>
    </div>';
}