<link rel="stylesheet" href="{{ asset('css/trackingdisplay.css') }}">

<x-tracking-layout title="Client Order Status">
    <div class="layout-container">
        <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>ORDER STATUS</h2>
            <div id="tracking-status-body">
                <div id="product-status-div">
                    <p><b>Current status: </b><span id="current-status">{{$order->getStatus()}}</span></p>
                    <br>
                    <div class="progress-bar">
                        <div class="progress-section measuring"></div>
                        <div class="progress-section ordering_material"></div>
                        <div class="progress-section fabricating"></div>
                        <div class="progress-section ready_for_handover"></div>
                        <div class="progress-section installed-pickedup"></div>
                    </div>
                </div>
                <br>
                <div id="product-details-div">
                    <h3>Product Details:</h3>
                    <p><b>Material Name:</b><span> {{$order->getProduct()->getMaterialName()}}</span></p>
                    <p><b>Size:</b><span> {{$order->getProduct()->getSlabWidth()}} x {{$order->getProduct()->getSlabHeight()}}</span></p>
                    <p><b>Slab Thickness:</b><span> {{$order->getProduct()->getSlabThickness()}}</span></p>
                    <p><b>Slab Square Footage:</b><span> {{$order->getProduct()->getSlabSquareFootage()}}</span></p>
                    <p><b>Sink:</b><span> {{$order->getProduct()->getSinkType()}}</span></p>
                    <p><b>Finishing:</b><span> {{$order->getOrderCompletedDate() == null ? "Not known yet" : $order->getOrderCompletedDate()->format("Y/m/d")}}</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const status = "Installed"; // TEMPORARY: force it to always show all sections
        const sectionLabels = [
            "Measuring",
            "Ordering Material",
            "Fabricating",
            "Ready for Handover",
            status === "Installed" ? "Installed" : "Picked Up"
        ];

        const sections = document.querySelectorAll(".progress-section");

        sections.forEach((section, index) => {
            section.classList.add("active");
            const labelText = sectionLabels[index];
            section.innerHTML = `<span class="label">${labelText}</span>`;
        });
    });
</script>

</x-tracking-layout>
