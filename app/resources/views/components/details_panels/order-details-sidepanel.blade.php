

<div id="orders-side-content" class="side-content">
    <div class="side-content-container">
        <div class="side-content-header">
            <h2>ORDER DETAILS</h2>
            <hr>
            <h3><b>ORDER ID:</b><span id="detail-order-id">{{ $order->getOrderId() }}</span></h3>
        </div>
        <div class="side-content-scrollable">
            <p><b>CLIENT ID:</b><span id="detail-client-id">{{ $order->getClient()->getClientId() }}</span></p>
            <p><b>Measured By:</b><span id="detail-measured-by">{{ $order->getMeasuredBy()->getInitials() }}</span></p>
            <p><b>Reference Number:</b><span id="detail-reference-number">{{ $order->getReferenceNumber() }}</span></p>
            <p><b>Invoice Number:</b><span id="detail-invoice-number">{{ $order->getInvoiceNumber() }}</span></p>
            <p><b>Total Price:</b><span id="detail-total-price">{{ $order->getPrice() }}</span></p>
            <p><b>Status:</b><span id="detail-order-status">{{ $order->getStatus() }}</span></p>
            <p><b>Fabrication Start Date:</b><span id="detail-fabrication-start-date">{{ $order->getFabricationStartDate() == null ? "-" : $order->getFabricationStartDate()->format("Y / m / d") }}</span></p>
            <p><b>Installation Start Date:</b><span id="detail-installation-start-date">{{ $order->getEstimatedInstallationDate == null ? "-" : $order->getEstimatedInstallationDate->format("Y / m / d") }}</span></p>
            <p><b>Completed Date:</b><span id="detail-order-completed-date">{{ $order->getOrderCompletedDate() == null ? "-" : $order->getOrderCompletedDate()->format("Y / m / d") }}</span></p>
            <p><b>Material Name:</b><span id="detail-material-name">{{ $order->getProduct()->getMaterialName() }}</span></p>
            <p><b>Slab Height:</b><span id="detail-slab-height">{{ $order->getProduct()->getSlabHeight() }}</span></p>
            <p><b>Slab Width:</b><span id="detail-slab-width">{{ $order->getProduct()->getSlabWidth() }}</span></p>
            <p><b>Slab Thickness:</b><span id="detail-slab-thickness">{{ $order->getProduct()->getSlabThickness() }}</span></p>
            <p><b>Slab Square Footage:</b><span id="detail-slab-square-footage">{{ $order->getProduct()->getSlabSquareFootage() }}</span></p>
            <p><b>Sink Type:</b><span id="detail-sink-type">{{ $order->getProduct()->getSinkType() }}</span></p>
            <p><b>Fabrication Plan Image:</b><a id="detail-fabrication-plan-image" target="_blank" href="">{{ $order->getProduct()->getPlanImagePath() ? basename($order->getProduct()->getPlanImagePath()): "No fabrication plan." }}</a></p>
            <p><b>Product Description:</b><x-area-input-property name="detail-product-description" labelText="Product Description" :isLabel="false" :readonly="true" :value="$order->getProduct()->getProductDescription()"/></p>
            <p><b>Product Notes:</b><x-area-input-property name="detail-product-notes" labelText="Product Notes" :isLabel="false" :readonly="true" :value="$order->getProduct()->getProductNotes()"/></p>
        </div>
    </div>
    <div class="side-content-details-options">
        <a id="detail-edit-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button"
            onclick="">Edit</a>
        <a id="detail-add-payment-btn" {{-- HREF is ADDED Dynamically --}} class="regular-button"
            onclick="">Add Payment</a>
    </div>
</div>