<link rel="stylesheet" href="{{ asset('css/ordertrackingdisplay.css') }}">

<x-tracking-layout title="Client Order Status">
<div class="content-container">
        <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>ORDER STATUS</h2>
            <div id="tracking-status-body">
                <div id="product-status-div">
                    <p><b>Position:</b><span>#</span></p>
                    <div class="progress-bar">
                        <div class="measuring">#</div> <!-- Measuring  -->
                        <div class="ordering_material">#</div> <!-- Ordering material  -->
                        <div class="fabricating">#</div> <!-- Fabricating -->
                        <div class="ready_for_handover">#</div> <!-- Ready for handover -->
                        <div class="installed-pickedup">#</div> <!-- Installed or Picked up -->
                    </div>
                </div>
                <div id="product-details-div">
                    <p><b>Product Details:</b><span>#</span></p>
                    <p><b>Size:</b><span>#</span></p>
                    <p><b>Slab Width::</b><span>#</span></p>
                    <p><b>Material Name::</b><span>#</span></p>
                    <p><b>Color:</b><span>#</span></p>
                    <p><b>Sink:</b><span>#</span></p>
                    <p><b>Finishing:</b><span>#</span></p>
                </div>
            </div>
        </div>
    </div>
</x-tracking-layout>
