<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Edit Order">
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button>Go Back</button></a>
            <form method="PATCH" action="/orders/{{$order->getOrderId()}}" class="create-edit-form">
                <h2>Edit Order</h2>
                <x-text-input-property labelText="Client ID" name="client-id" />
                <x-text-input-property labelText="Measured By" name="measured-by" />
                <x-text-input-property labelText="Reference Number" name="reference-number" />
                <x-text-input-property labelText="Invoice Number" name="invoice-number" />
                <x-text-input-property labelText="Total Price" name="total-price" />
                <x-select-input-property labelText="Status" name="order-status">
                    <option value="confirmedMsNotReady" selected>Confirmed ms not ready</option>
                    <option value="confirmedMsReady">Confirmed ms ready</option>
                    <option value="readyForMs">Ready for ms</option>
                    <option value="pickedUp">Picked up</option>
                    <option value="installed">Installed</option>
                </x-select-input-property>
                <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date"/>
                <x-date-input-property labelText="Installation Start Date" name="installation-start-date"/>
                <x-date-input-property labelText="Pickup Start Date" name="pickup-start-date"/>
                <x-text-input-property labelText="Material Name" name="material-name" />
                <x-text-input-property labelText="Slab Height" name="slab-height" />
                <x-text-input-property labelText="Slab Width" name="slab-width" />
                <x-text-input-property labelText="Slab Thickness" name="slab-thickness" />
                <x-text-input-property labelText="Slab Square Footage" name="slab-square-footage" />
                <x-text-input-property labelText="Sink Type" name="sink-type" />
                <x-file-input-property labeText="Fabrication Plan Image" name="fabrication-image"/>
                <x-text-input-property labelText="Product Description" name="product-description" />
                <x-text-input-property labelText="Product Notes" name="product-notes" />
                <input class="regular-button" type="submit" value="Save"/>
            </form>
            <a href="/orders">
                <button class="regular-button">Cancel</button>
            </a>
        </div>
    </div>
</x-layout>
