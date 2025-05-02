<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<x-layout title="Create Order">
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Create Order</h2>
            <form action="/orders/store" class="create-edit-form">
            <h3>Order Details</h3>
                <div class="details-div">
                    <x-text-input-property labelText="Client ID" name="client-id" />
                    <a href="" class="createClient">Inexistant client? Create one</a>
                    <x-text-input-property labelText="Measured By" name="measured-by" />
                    <x-text-input-property labelText="Reference Number" name="reference-number" />
                    <x-text-input-property labelText="Invoice Number" name="invoice-number" />
                    <x-text-input-property labelText="Total Price" name="total-price" />
                    <x-select-input-property labelText="Status" name="order-status">
                        <option value="measuring" selected>Measuring</option>
                        <option value="ordering_material">Ordering material</option>
                        <option value="fabricating">Fabricating</option>
                        <option value="ready_for_handover">Ready for handover</option>
                        <option value="installed">Installed</option>
                        <option value="picked_up">Picked up</option>
                    </x-select-input-property>
                    <div class="image-upload">
                            <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"/>
                    </div>
                </div>

                <h3>Date Details</h3>
                <div class="details-div">
                <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date"/>
                <x-date-input-property labelText="Installation Start Date" name="installation-start-date"/>
                <x-date-input-property labelText="Pickup Start Date" name="pickup-start-date"/>
                </div>

                <h3>Product Details</h3>
                <div class="details-div">
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
                </div>
                <div class="action-input-div">
                <input class="regular-button" type="submit" value="Create"/>
                <a href="/orders">
                <button class="regular-button">Cancel</button>
                </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>


<!-- ********************************************************************************* DO NOT DELETE THE FOLLOWING CODE, THIS IS THE CREATE ORDER PAGE IBRAHIM VERSION, WHILE WHAT IS ABOVE IS ALEXANDRU OLD VERSION BUT UPDATED *********************************************************************************

<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<x-layout title="Create Order">
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Create Order</h2>
            <form action="/orders/store" class="create-edit-form">
            <h3>Order Details</h3>
                <div class="details-div">
                    <x-text-input-property labelText="Client ID" name="client-id" />
                    <a href="" class="createClient">Inexistant client? Create one</a>
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

                    <div class="image-upload">
                        <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"/>
                    </div>

                    <div class="action-input-div">
                        <input class="regular-button" type="submit" value="Create"/>
                        <a href="/orders"> <button class="regular-button">Cancel</button> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout> -->
