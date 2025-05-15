<link rel="stylesheet" href="{{ asset('css/trackingdisplay.css') }}">

<x-tracking-layout title="Client Order Status">
    <div class="layout-container">
        <div class="main-content">
            <a href="/tracking?lang={{ session('lang', 'en') }}" class="regular-button">{{ _("Go Back")}}</a>
            <h2>{{ _("ORDER STATUS")}}</h2>
            <div id="tracking-status-body">
                <div id="product-status-div">
                    <p><b>{{ _("Current status")}}: </b><span id="current-status">{{$order->getStatus()}}</span></p>
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
                    <h3>{{ _("Product Details")}}:</h3>
                    <p><b>{{ _("Material Name")}}:</b><span> {{$order->getProduct()->getMaterialName()}}</span></p>
                    <p><b>{{ _("Size")}}:</b><span> {{$order->getProduct()->getSlabWidth()}} x {{$order->getProduct()->getSlabHeight()}}</span></p>
                    <p><b>{{ _("Slab Thickness")}}:</b><span> {{$order->getProduct()->getSlabThickness()}}</span></p>
                    <p><b>{{ _("Slab Square Footage")}}:</b><span> {{$order->getProduct()->getSlabSquareFootage()}}</span></p>
                    <p><b>{{ _("Sink")}}:</b><span> {{$order->getProduct()->getSinkType()}}</span></p>
                    <p><b>{{ _("Finishing")}}:</b><span> {{$order->getOrderCompletedDate() == null ? "Not known yet" : $order->getOrderCompletedDate()->format("Y/m/d")}}</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const rawStatus = document.getElementById("current-status").innerText.trim().toUpperCase();
        const statusMap = {
            "MEASURING": "{{ _('Measuring') }}",
            "ORDERING_MATERIAL": "{{ _('Ordering Material') }}",
            "FABRICATING": "{{ _('Fabricating') }}",
            "READY_FOR_HANDOVER": "{{ _('Ready for Handover') }}",
            "INSTALLED": "{{ _('Installed') }}",
            "PICKED_UP": "{{ _('Picked Up') }}"
        };
        const steps = [
            "MEASURING",
            "ORDERING_MATERIAL",
            "FABRICATING",
            "READY_FOR_HANDOVER",
            "INSTALLED" 
        ];
        let currentStepIndex = steps.indexOf(rawStatus);
        if (rawStatus === "PICKED_UP") {
            currentStepIndex = steps.indexOf("INSTALLED");
        }
        const sections = document.querySelectorAll(".progress-section");
        sections.forEach((section, index) => {
            if (index <= currentStepIndex) {
                section.classList.add("active");
                let labelKey = steps[index];
                if (index === 4) {
                    labelKey = (rawStatus === "PICKED_UP" || rawStatus === "INSTALLED") ? rawStatus : ""; // If it's the final step, decide whether to show "Installed" or "Picked Up"
                }
                const label = statusMap[labelKey] || "";
                section.innerHTML = `<span class="label">${label}</span>`;
            } else {
                section.classList.remove("active");
                section.innerHTML = "";
            }
        });
    });
</script>



</x-tracking-layout>
