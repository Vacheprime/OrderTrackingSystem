document.addEventListener("DOMContentLoaded", () => {
    const arrow = document.getElementById("sidebar-arrow");
    const sidebar = document.getElementById("sidebar");

    arrow.addEventListener("click", () => {
        arrow.classList.toggle("rotate");
        sidebar.classList.toggle("shrink");
        document
            .querySelectorAll("#sidebar .nav-link-a")
            .forEach((p) => p.classList.toggle("remove"));
    });

    // Highlight the active sidebar link
    const currentPath = window.location.pathname;
    document.querySelectorAll("#sidebar .nav-link").forEach((link) => {
        if (currentPath.startsWith(new URL(link.href).pathname)) {
            link.classList.add("nav-link-active");
        } else {
            link.classList.remove("nav-link-active");
        }
    });
});
