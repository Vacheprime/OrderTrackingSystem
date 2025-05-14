<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<x-layout title="Edit Order">
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}">
                <button class="regular-button">Go Back</button>
            </a>
            <h2>Edit Order</h2>
            <form method="POST" action="{{route('orders.update', $order->getOrderId())}}" class="create-edit-form">
                @csrf
                @method("PUT")
                <h3>Order Details</h3>
                <div class="details-div">
                    <x-text-input-property labelText="Invoice Number" name="invoice-number"
                                           :value="$order->getInvoiceNumber()"/>
                    <x-text-input-property labelText="Total Price" name="total-price" :value="$order->getPrice()"/>
                    <x-select-input-property labelText="Status" name="order-status">
                        <option value="measuring" {{$order->getStatus() == "MEASURING" ? "selected" : "" }}>Measuring</option>
                        <option value="ordering_material" {{$order->getStatus() == "ORDERING_MATERIAL" ? "selected" : "" }}>Ordering material</option>
                        <option value="fabricating" {{$order->getStatus() == "FABRICATING" ? "selected" : "" }}>Fabricating</option>
                        <option value="ready_for_handover" {{$order->getStatus() == "READY_TO_HANDOVER" ? "selected" : "" }}>Ready for handover</option>
                        <option value="installed" {{$order->getStatus() == "INSTALLED" ? "selected" : "" }}>Installed</option>
                        <option value="picked_up" {{$order->getStatus() == "PICKED_UP" ? "selected" : "" }}>Picked up</option>
                    </x-select-input-property>
                    <div class="image-upload">
                        <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image" :value="asset($order->getProduct()->getPlanImagePath())"/>
                    </div>
                </div>

                <h3>Date Details</h3>
                <div class="details-div">
                    <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date" :value="$order->getFabricationStartDate() == null ? '' : $order->getFabricationStartDate()->format('Y-m-d')"/>
                    <x-date-input-property labelText="Installation Start Date" name="installation-start-date" :value="$order->getEstimatedInstallDate() == null ? '' : $order->getEstimatedInstallDate()->format('Y-m-d')"/>
                </div>

                <h3>Product Details</h3>
                <div class="details-div">
                    <x-text-input-property labelText="Material Name" name="material-name"
                                           :value="$order->getProduct()->getMaterialName()"/>
                    <x-text-input-property labelText="Slab Height" name="slab-height"
                                           :value="$order->getProduct()->getSlabHeight()"/>
                    <x-text-input-property labelText="Slab Width" name="slab-width"
                                           :value="$order->getProduct()->getSlabWidth()"/>
                    <x-text-input-property labelText="Slab Thickness" name="slab-thickness"
                                           :value="$order->getProduct()->getSlabThickness()"/>
                    <x-text-input-property labelText="Slab Square Footage" name="slab-square-footage"
                                           :value="$order->getProduct()->getSlabSquareFootage()"/>
                    <x-text-input-property labelText="Sink Type" name="sink-type"
                                           :value="$order->getProduct()->getSinkType()"/>
                    <div class="textarea-group">
                        <label id="productDescription" for="productDescription-input">Product Description</label>
                        <textarea id="productDescription-input" placeholder="Product Description">
                            {{$order->getProduct()->getProductDescription()}}
                        </textarea>
                        @error("product-description")
                        <p class="error-input">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="textarea-group">
                        <label id="productNotes" for="productNotes-input">Product Notes</label>
                        <textarea id="productNotes-input" placeholder="Product Notes">
                            {{  $order->getProduct()->getProductNotes()}}
                        </textarea>
                        @error("product-notes")
                        <p class="error-input">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="action-input-div">
                    <input class="regular-button" type="submit" value="Save"/>
                    <a href="/orders" class="regular-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>


<!-- ********************************************************************************* DO NOT DELETE THE FOLLOWING CODE, THIS IS THE EDIT ORDER PAGE IBRAHIM VERSION, WHILE WHAT IS ABOVE IS ALEXANDRU OLD VERSION BUT UPDATED *********************************************************************************

<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<x-layout title="Edit Order">
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Edit Order</h2>
            <form action="/orders/store" class="create-edit-form">
            <h3>Order Details</h3>
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

                    <div class="image-upload">
                        <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"/>
                    </div>

                    <div class="action-input-div">
                        <input class="regular-button" type="submit" value="Save"/>
                        <a href="/orders"> <button class="regular-button">Cancel</button> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
