<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Edit Order">
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Edit Order</h2>
            <form action="/orders/store" class="create-edit-form">
            <div class="details-div">
                    <x-text-input-property labelText="Client ID" name="client-id" />
                    <x-text-input-property labelText="Measured By(Initials)" name="measured-by" />
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
                    
                    <div class="textarea-group">
                        <label id="productDescription" for="productDescription-input">Product Description</label>
                        <textarea id="productDescription-input" placeholder="Product Description"></textarea>
                    </div>

                    <div class="textarea-group">
                        <label id="productNotes" for="productNotes-input">Product Notes</label>
                        <textarea id="productNotes-input" placeholder="Product Notes"></textarea>
                    </div>

                    <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"/>

                    <div class="action-input-div">
                        <input class="regular-button" type="submit" value="Save"/>
                        <a href="/orders"> <button class="regular-button">Cancel</button> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
