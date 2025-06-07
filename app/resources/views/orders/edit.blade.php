<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
<link rel="stylesheet" href=" {{ asset('css/confirmation.css') }}">
<script src="{{ asset('js/confirmation.js') }}"></script>

<x-layout title="Edit Order">
    <h1 class="content-title">Edit ORDER</h1>
    <div class="content-container">
        <form id="edit-order-form" method="POST" action="{{route('orders.update', $order->getOrderId())}}" class="create-edit-form" enctype="multipart/form-data">
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
                                           :value="old('invoice-number', $order->getInvoiceNumber())"/>
                    <x-text-input-property labelText="Total Price" name="total-price" :value="old('total-price', $order->getPrice())"/>
                    <x-select-input-property labelText="Status" name="order-status">
                        <option
                            value="measuring" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::MEASURING->value ? "selected" : "" }}>
                            Measuring
                        </option>
                        <option
                            value="ordering_material" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::ORDERING_MATERIAL->value ? "selected" : "" }}>
                            Ordering material
                        </option>
                        <option
                            value="fabricating" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::FABRICATING->value ? "selected" : "" }}>
                            Fabricating
                        </option>
                        <option
                            value="ready_to_handover" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::READY_TO_HANDOVER->value ? "selected" : "" }}>
                            Ready to handover
                        </option>
                        <option
                            value="installed" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::INSTALLED->value ? "selected" : "" }}>
                            Installed
                        </option>
                        <option
                            value="picked_up" {{ strtoupper(old('order-status-select', $order->getStatus()->value)) == \app\Doctrine\ORM\Entity\Status::PICKED_UP->value ? "selected" : "" }}>
                            Picked up
                        </option>
                    </x-select-input-property>
                    <x-file-input-property labelText="Fabrication Plan Image" name="fabrication-image"
                                           :value="asset($order->getProduct()->getPlanImagePath())"/>
                </div>

                <h3>Date Details</h3>
                <div id="date-details-div" class="details-div">
                    <x-date-input-property labelText="Fabrication Start Date" name="fabrication-start-date"
                                           :value="old('fabrication-start-date-input', $order->getFabricationStartDate() == null ? '' : $order->getFabricationStartDate()->format('Y-m-d'))"/>
                    <x-date-input-property labelText="Estimated Installation Date" name="estimated-installation-date"
                                           :value="old('estimated-installation-date-input', $order->getEstimatedInstallDate() == null ? '' : $order->getEstimatedInstallDate()->format('Y-m-d'))"/>
                </div>

                <h3>Product Details</h3>
                <div id="product-details-div" class="details-div">
                    <x-text-input-property labelText="Material Name" name="material-name"
                                           :value="old('material-name', $order->getProduct()->getMaterialName())"/>
                    <x-text-input-property labelText="Slab Height" name="slab-height"
                                           :value="old('slab-height', $order->getProduct()->getSlabHeight())"/>
                    <x-text-input-property labelText="Slab Width" name="slab-width"
                                           :value="old('slab-width', $order->getProduct()->getSlabWidth())"/>
                    <x-text-input-property labelText="Slab Thickness" name="slab-thickness"
                                           :value="old('slab-thickness', $order->getProduct()->getSlabThickness())"/>
                    <x-text-input-property labelText="Slab Square Footage" name="slab-square-footage"
                                           :value="old('slab-square-footage', $order->getProduct()->getSlabSquareFootage())"/>
                    <x-text-input-property labelText="Sink Type" name="sink-type"
                                           :value="old('sink-type', $order->getProduct()->getSinkType())"/>
                    <x-area-input-property labelText="Product Description" name="product-description"
                                           :value="old('product-description', $order->getProduct()->getProductDescription())"/>
                    <x-area-input-property labelText="Product Notes" name="product-notes"
                                           :value="old('product-notes', $order->getProduct()->getProductNotes())"/>
                </div>
                <div class="action-input-div">
                    <button class="regular-button" type="button" onclick="withConfirmation('Confirm changes to this order?', () => {
                        document.getElementById('edit-order-form').submit();
                    })">Update</button>
                    <a href="/orders" class="regular-button">Cancel</a>
                </div>
            </div>

        </form>
    </div>
</x-layout>
