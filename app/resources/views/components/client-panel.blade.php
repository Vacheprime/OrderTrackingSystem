@props(['display' => true])
<script src="{{ asset('js/order.js') }}"></script>

<div id="orders-create-side-content" class="side-content" @if(!$display) style="display: none;" @endif>
    <div class="create-edit-header">
        <h2>Client Information</h2>
    </div>
    <h3>Client Details</h3>
    <div id="client-details-div" class="details-div">
        <x-text-input-property labelText="First Name" name="first-name" :display="$display"/>
        <x-text-input-property labelText="Last Name" name="last-name" :display="$display"/>
        <x-text-input-property labelText="Street Name" name="street-name" :display="$display"/>
        <x-text-input-property labelText="Appartment Number" name="appartment-number" :display="$display"/>
        <x-text-input-property labelText="Postal Code" name="postal-code" :display="$display"/>
        <x-text-input-property labelText="Area (Neighborhood)" name="area" :display="$display"/>
    </div>
    <h3>Contact Details</h3>
    <div id="contact-details-div" class="details-div">
        <x-text-input-property labelText="Reference Number" name="reference-number" :display="$display"/>
        <x-text-input-property labelText="Phone Number" name="phone-number" :display="$display"/>
    </div>
    <button onclick="togglePanel(false)" type="button" class="regular-button">Enter Client Id</button>
</div>
