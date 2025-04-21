<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout>
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button>Go Back</button></a>
            <form action="" class="create-edit-form">
                <h2 class="">Edit Order</h2>
                <x-input-property property="Client ID:" propertyName="client-id" />
                <x-input-property property="Measured By:" propertyName="measured-by" />
                <x-input-property property="Reference Number" propertyName="reference-number" />
                <x-input-property property="Invoice Number" propertyName="invoice-number" />
                <x-input-property property="Total Price" propertyName="total-price" />
                <label>Status:</label>
                <select class="status-dropdown">
                    <option value="" disabled selected>Choose</option>
                    <option value="confirmedMsNotReady">Confirmed ms not ready</option>
                    <option value="confirmedMsReady">Confirmed ms ready</option>
                    <option value="readyForMs">Ready for ms</option>
                    <option value="pickedUp">Picked up</option>
                    <option value="installed">Installed</option>
                </select>

                <label for="fabricationStartDate">Fabrication_start date</label>
                <input type="date" id="fabricationStartDate">

                <label for="installationDate">Installation date</label>
                <input type="date" id="installationDate">

                <label for="pickedUpDate">Picked_up date</label>
                <input type="date" id="pickedUpDate">

                <x-input-property property="Material Name" propertyName="material-name" />
                <x-input-property property="Slab Height" propertyName="slab-height" />
                <x-input-property property="Slab Width" propertyName="slab-width" />
                <x-input-property property="Slab Thickness" propertyName="slab-thickness" />
                <x-input-property property="Slab Square Footage" propertyName="slab-square-footage" />
                <x-input-property property="Sink Type" propertyName="sink-type" />

                <label for="fabrication-image">Fabrication Plan Image</label>
                <input type="file" name="fabrication-image" id="fabrication-image" class="upload-image">

                <x-input-property property="Product Description" propertyName="product-description" />
                <x-input-property property="Product Notes" propertyName="product-notes" />
            </form>
        </div>
    </div>
</x-layout>
