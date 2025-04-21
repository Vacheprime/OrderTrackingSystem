<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout>
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <form>
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

                <x-input-property property="Client ID" propertyName="clientid" />
                <x-input-property property="Client ID" propertyName="clientid" />
                <x-input-property property="Client ID" propertyName="clientid" />
                <x-input-property property="Client ID" propertyName="clientid" />


                <label for="materialName">Material name</label>
                <input type="text" id="materialName" name="materialName" value="Null">
                <br>
                <label for="slabHeight">Slab height</label>
                <input type="text" id="slabHeight" name="slabHeight" value="Null">
                <br>
                <label for="slabWidth">Slab width</label>
                <input type="text" id="slabWidth" name="slabWidth" value="Null">
                <br>
                <label for="slabThickness">Slab thickness</label>
                <input type="text" id="slabThickness" name="slabThickness" value="Null">
                <br>
                <label for="slabSquareFootage">Slab square footage</label>
                <input type="text" id="slabSquareFootage" name="slabSquareFootage" value="Null">
                <br>
                <label for="sinkType">Sink type</label>
                <input type="text" id="sinkType" name="sinkType" value="Null">
                <br>
                <div class="uploadFabPlanImage" onclick="">
                    <img src="cloud-icon.png" alt="Upload Icon">
                    <p>Fabrication plan image</p>
                </div>
                <input type="file" id="uploadedImage" style="display: none;">
                <br>
                <label for="productDescription">Product Description</label>
                <input type="text" id="productDescription" name="productDescription" value="Null">
                <br>
                <label for="productNotes">Product Notes</label>
                <input type="text" id="productNotes" name="productNotes" value="Null">
                <br>
            </form>
        </div>
    </div>
</x-layout>
