@props(['title' => "Tracking Order"])


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <script src="{{ asset('js/main.js') }}"></script>
</head>
<body>
<x-header :logout="false" :language="true"/>
<div class="main-layout">
    <main>
        {{ $slot }}
    </main>
</div>

<script>
const translations = {
    en: {
        orderStatus: "ORDER STATUS",
        currentStatus: "Current status",
        productDetails: "Product Details",
        materialName: "Material Name",
        size: "Size",
        slabThickness: "Slab Thickness",
        slabSquareFootage: "Slab Square Footage",
        sink: "Sink",
        finishing: "Finishing",
        goBack: "Go Back",
        trackOrder: "Track Order",
        refNumber: "Reference Number",
        inputMessage: "Please enter your reference number to track your order status. If you need help finding it, check your confirmation email or contact our support team.",
        measuring: "Measuring",
        orderingmaterial: "Ordering Material",
        fabricating: "Fabricating",
        readyforhandover: "Ready for Handover",
        installed: "Installed",
        pickedup: "Picked Up",
        notknown: "Not known yet"
    },
    fr: {
        orderStatus: "STATUT DE LA COMMANDE",
        currentStatus: "Statut actuel",
        productDetails: "Détails du produit",
        materialName: "Nom du matériau",
        size: "Taille",
        slabThickness: "Épaisseur de la dalle",
        slabSquareFootage: "Superficie de la dalle",
        sink: "Évier",
        finishing: "Finition",
        goBack: "Retour",
        trackOrder: "Suivre la commande",
        refNumber: "Numéro de Référence",
        inputMessage: "Veuillez entrer votre numéro de référence pour suivre l'état de votre commande. Si vous avez besoin d'aide pour le trouver, consultez votre e-mail de confirmation ou contactez notre équipe de support.",
        measuring: "Mesure",
        orderingmaterial: "Commande de matériel",
        fabricating: "Fabrication",
        readyforhandover: "Prêt pour la remise",
        installed: "Installé",
        pickedup: "Récupéré",
        notknown: "Inconnu"
    }
};

function applyLanguage(lang) {
    document.querySelectorAll("[data-i18n]").forEach(el => {
        const key = el.getAttribute("data-i18n");
        if (translations[lang] && translations[lang][key]) {
            el.innerText = translations[lang][key];
        }
    });
    localStorage.setItem("lang", lang);
}

document.addEventListener("DOMContentLoaded", () => {
    const lang = new URLSearchParams(window.location.search).get("lang") || localStorage.getItem("lang") || "en";
    applyLanguage(lang);

    const langSelect = document.querySelector(".selectLanguage");
    if (langSelect) {
        langSelect.value = lang;
        langSelect.addEventListener("change", () => {
            const newLang = langSelect.value;
            const url = new URL(window.location.href);
            url.searchParams.set("lang", newLang);
            window.location.href = url.toString();
        });
    }
});
</script>



</body>
</html>

