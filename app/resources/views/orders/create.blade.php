<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<script src="{{ asset('js/order.js') }}"></script>

@php
    $shouldDisplayClientInfo = ($client == "new");
@endphp

<x-layout title="Create Order">
    <h1 class="content-title">CREATING ORDER</h1>
    <div class="content-container">
        <form method="POST" action="/orders" class="create-edit-form" enctype="multipart/form-data">
            @csrf
            <div id="orders-create-content" class="main-content">
                <div class="create-edit-header">
                    <a href="{{$clientId == "" ? "/orders" : "/clients"}}" class="regular-button">Go Back</a>
                    <h2>Order Information</h2>
                    <div class="filler-div"></div>
                </div>
                <h3 id="order-details-h3">Order Details <button id="client-id-btn" type="button" onclick="showClientSidePanel()" @if($shouldDisplayClientInfo || isset($clientId)) style="display: none;" @endif>Create New Client?</button></h3>
                <div id="order-details-div" class="details-div">

                    <!-- Hidden input type used to determine whether the user is creating by client ID or with client information -->
                    <input id="create-option-input" type="hidden" name="with-existing-client" value={{ isset($clientId) ? "1" : "0" }}>

                    <!-- Display only if creating by client ID -->
                    <x-text-input-property labelText="Client ID" name="client-id" :display="!$shouldDisplayClientInfo" :value="$clientId" :readonly="isset($clientId)"/>
                    
                    <x-text-input-property labelText="Employee ID" name="measured-by"/>
                    <x-text-input-property labelText="Invoice Number" name="invoice-number"/>
                    <x-text-input-property labelText="Total Price" name="total-price"/>
                    <x-select-input-property labelText="Status" name="order-status">
                        <option value="measuring">Measuring</option>
                        <option value="ordering_material">Ordering material</option>
                        <option value="fabricating">Fabricating</option>
                        <option value="ready_to_handover">Ready for handover</option>
                        <option value="installed">Installed</option>
                        <option value="picked_up">Picked up</option>
                    </x-select-input-property>
                    <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"/>
                </div>

                <h3>Date Details</h3>
                <div id="date-details-div" class="details-div">
                    <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date"/>
                    <x-date-input-property labelText="Estimated Installation Date" name="estimated-installation-date"/>
                </div>

                <h3>Product Details</h3>
                <div id="product-details-div" class="details-div">
                    <x-text-input-property labelText="Material Name" name="material-name"/>
                    <x-text-input-property labelText="Slab Height" name="slab-height"/>
                    <x-text-input-property labelText="Slab Width" name="slab-width"/>
                    <x-text-input-property labelText="Slab Thickness" name="slab-thickness"/>
                    <x-text-input-property labelText="Slab Square Footage" name="slab-square-footage"/>
                    <x-text-input-property labelText="Sink Type" name="sink-type"/>
                    <x-area-input-property labelText="Product Description" name="product-description"/>
                    <x-area-input-property labelText="Product Notes" name="product-notes"/>
                </div>
                <div class="action-input-div">
                    <button class="regular-button" type="submit">Create</button>
                    <a href="/orders" class="regular-button">Cancel</a>
                </div>
            </div>
            <!-- Display if creating with client info -->
            <x-client-panel :display="$shouldDisplayClientInfo" />
        </form>
    </div>
</x-layout>
