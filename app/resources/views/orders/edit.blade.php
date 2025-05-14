<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<x-layout title="Edit Order">
    <h1 class="content-title">Edit ORDER</h1>
    <div class="content-container">
        <form method="POST" action="{{route('orders.update', $order->getOrderId())}}" class="create-edit-form">
            @csrf
            @method("PUT")
            <div id="orders-create-content" class="main-content">
                <div class="create-edit-header">
                    <a href="/orders" class="regular-button">Go Back</a>
                    <h2>Order Information</h2>
                    <div class="filler-div"></div>
                </div>
                <h3>Order Details</h3>
                <div id="order-details-div" class="details-div">
                    <x-text-input-property labelText="Invoice Number" name="invoice-number"
                                           :value="$order->getInvoiceNumber()"/>
                    <x-text-input-property labelText="Total Price" name="total-price" :value="$order->getPrice()"/>
                    <x-select-input-property labelText="Status" name="order-status">
                        <option
                            value="measuring" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::MEASURING ? "selected" : "" }}>
                            Measuring
                        </option>
                        <option
                            value="ordering_material" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::ORDERING_MATERIAL ? "selected" : "" }}>
                            Ordering material
                        </option>
                        <option
                            value="fabricating" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::FABRICATING ? "selected" : "" }}>
                            Fabricating
                        </option>
                        <option
                            value="ready_to_handover" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::READY_TO_HANDOVER ? "selected" : "" }}>
                            Ready for handover
                        </option>
                        <option
                            value="installed" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::INSTALLED ? "selected" : "" }}>
                            Installed
                        </option>
                        <option
                            value="picked_up" {{$order->getStatus() == \app\Doctrine\ORM\Entity\Status::PICKED_UP ? "selected" : "" }}>
                            Picked up
                        </option>
                    </x-select-input-property>
                    <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"
                                           :value="asset($order->getProduct()->getPlanImagePath())"/>
                </div>

                <h3>Date Details</h3>
                <div id="date-details-div" class="details-div">
                    <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date"
                                           :value="$order->getFabricationStartDate() == null ? '' : $order->getFabricationStartDate()->format('Y-m-d')"/>
                    <x-date-input-property labelText="Estimated Installation Date" name="estimated-installation-date"
                                           :value="$order->getEstimatedInstallDate() == null ? '' : $order->getEstimatedInstallDate()->format('Y-m-d')"/>
                </div>

                <h3>Product Details</h3>
                <div id="product-details-div" class="details-div">
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
                    <x-area-input-property labelText="Product Description" name="product-description"
                                           :value="$order->getProduct()->getProductDescription()"/>
                    <x-area-input-property labelText="Product Notes" name="product-notes"
                                           :value="$order->getProduct()->getProductNotes()"/>
                </div>
                <div class="action-input-div">
                    <button class="regular-button" type="submit">Create</button>
                    <a href="/orders" class="regular-button">Cancel</a>
                </div>
            </div>

        </form>
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
