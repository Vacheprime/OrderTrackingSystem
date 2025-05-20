@props(['display' => 'default'])
<script src="{{ asset('js/order.js') }}"></script>

@php
    $displayStyle = "";
    if ($display != "default") {
        $displayStyle = "style=\"display: $display\"";
    }
@endphp

<div id="orders-create-side-content" class="side-content" {{ $displayStyle }}>
    <div class="create-edit-header">
        <h2>Client Information</h2>
    </div>
    <h3>Client Details</h3>
    <div id="client-details-div" class="details-div">
        <x-text-input-property labelText="First Name" name="first-name"/>
        <x-text-input-property labelText="Last Name" name="last-name"/>
        <x-text-input-property labelText="Street Name" name="street-name"/>
        <x-text-input-property labelText="Appartment Number" name="appartment-number"/>
        <x-text-input-property labelText="Postal Code" name="postal-code"/>
        <x-text-input-property labelText="Area (Neighborhood)" name="area"/>
    </div>
    <h3>Contact Details</h3>
    <div id="contact-details-div" class="details-div">
        <x-text-input-property labelText="Reference Number" name="reference-number"/>
        <x-text-input-property labelText="Phone Number" name="phone-number"/>
    </div>
    <button onclick="togglePanel(false)" type="button" class="regular-button">Enter Client Id</button>
</div>
