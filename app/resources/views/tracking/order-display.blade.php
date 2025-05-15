<link rel="stylesheet" href="{{ asset('css/trackingdisplay.css') }}">

<x-tracking-layout title="Client Order Status">
    <div class="layout-container">
        <div class="main-content">
            <a href="/tracking" class="regular-button">Go Back</a>
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
    const rawStatus = document.getElementById("current-status").innerText.trim();

    // Normalize backend status to match display labels
    const statusMap = {
        "MEASURING": "Measuring",
        "ORDERING_MATERIAL": "Ordering Material",
        "FABRICATING": "Fabricating",
        "READY_FOR_HANDOVER": "Ready for Handover",
        "INSTALLED": "Installed",
        "PICKED_UP": "Picked Up"
    };

    const status = statusMap[rawStatus.toUpperCase()] || "Measuring";

    const steps = [
        "Measuring",
        "Ordering Material",
        "Fabricating",
        "Ready for Handover",
        "Installed", // or Picked Up – dynamically assigned below
    ];

    const sections = document.querySelectorAll(".progress-section");

    let currentStepIndex = steps.indexOf(status);
    if (status === "Picked Up") currentStepIndex = steps.indexOf("Installed");

    sections.forEach((section, index) => {
        if (index <= currentStepIndex) {
            section.classList.add("active");

            let label = steps[index];
            if (index === 4) {
                label = (rawStatus === "PICKED_UP" || rawStatus === "INSTALLED")
                    ? statusMap[rawStatus.toUpperCase()]
                    : "";
            }

            section.innerHTML = `<span class="label">${label}</span>`;
        } else {
            section.classList.remove("active");
            section.innerHTML = "";
        }
    });
});
</script>



</x-tracking-layout>
