<link rel="stylesheet" href="{{ asset('css/trackingdisplay.css') }}">

<x-tracking-layout title="Client Order Status">
    <div class="layout-container">
        <div class="main-content">
            <a href="/tracking?lang={{ request('lang', 'en') }}" class="regular-button" data-i18n="goBack"></a>
            <h2 data-i18n="orderStatus"></h2>
            <div id="tracking-status-body">
                <div id="product-status-div">
                @php
                    $statusObj = $order->getStatus();
                    $rawStatus = is_object($statusObj) && method_exists($statusObj, '__toString')
                        ? strtoupper((string) $statusObj)
                        : strtoupper((string) ($statusObj->name ?? ''));
            @endphp

                    <p>
                        <b data-i18n="currentStatus"></b>: 
                        <span id="current-status" data-i18n="{{ strtolower(str_replace('_', '', $rawStatus)) }}"></span>
                    </p>
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
                    <h3 data-i18n="productDetails"></h3>
                    <p><b data-i18n="materialName"></b>: {{ $order->getProduct()->getMaterialName() }}</p>
                    <p><b data-i18n="size"></b>: {{ $order->getProduct()->getSlabWidth() }} x {{ $order->getProduct()->getSlabHeight() }}</p>
                    <p><b data-i18n="slabThickness"></b>: {{ $order->getProduct()->getSlabThickness() }}</p>
                    <p><b data-i18n="slabSquareFootage"></b>: {{ $order->getProduct()->getSlabSquareFootage() }}</p>
                    <p><b data-i18n="sink"></b>: {{ $order->getProduct()->getSinkType() }}</p>
                    <p>
                        <b data-i18n="finishing"></b>: 
                        <span data-i18n="{{ $order->getOrderCompletedDate() == null ? 'notknown' : '' }}">
                            {{ $order->getOrderCompletedDate() == null ? '' : $order->getOrderCompletedDate()->format("Y/m/d") }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    const lang = new URLSearchParams(window.location.search).get("lang") || localStorage.getItem("lang") || "en";

    const translations = {
        en: {
            measuring: "Measuring",
            orderingmaterial: "Ordering Material",
            fabricating: "Fabricating",
            readyforhandover: "Ready for Handover",
            installed: "Installed",
            pickedup: "Picked Up"
        },
        fr: {
            measuring: "Mesure",
            orderingmaterial: "Commande de matériel",
            fabricating: "Fabrication",
            readyforhandover: "Prêt pour la remise",
            installed: "Installé",
            pickedup: "Récupéré"
        }
    };

    const rawStatus = document.getElementById("current-status").getAttribute("data-i18n").toUpperCase();

    const steps = [
        { key: "MEASURING", i18n: "measuring" },
        { key: "ORDERING_MATERIAL", i18n: "orderingmaterial" },
        { key: "FABRICATING", i18n: "fabricating" },
        { key: "READY_FOR_HANDOVER", i18n: "readyforhandover" },
        { key: "INSTALLED", i18n: "installed" }
    ];

    let currentStepIndex = steps.findIndex(step => step.key === rawStatus);
    if (rawStatus === "PICKED_UP") {
        currentStepIndex = steps.findIndex(step => step.key === "INSTALLED");
    }

    const sections = document.querySelectorAll(".progress-section");
    sections.forEach((section, index) => {
        if (index <= currentStepIndex) {
            section.classList.add("active");
            const labelKey = (index === 4 && rawStatus === "PICKED_UP") ? "pickedup" : steps[index].i18n;
            const labelText = translations[lang][labelKey] || labelKey;
            section.innerHTML = `<span class="label">${labelText}</span>`;
        } else {
            section.classList.remove("active");
            section.innerHTML = "";
        }
    });
});
</script>



</x-tracking-layout>
