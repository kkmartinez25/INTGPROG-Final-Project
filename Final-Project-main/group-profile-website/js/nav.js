// js/nav.js
// Mobile menu toggle and "you are here" highlight for the home page sections.

(function () {
    const toggle = document.getElementById("navToggle");
    const nav = document.getElementById("siteNav");

    if (!toggle || !nav) {
        return;
    }

    function setOpen(open) {
        nav.classList.toggle("is-open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");
        toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    }

    toggle.addEventListener("click", function () {
        setOpen(!nav.classList.contains("is-open"));
    });

    // Close the menu after choosing a link, or with the Escape key
    nav.addEventListener("click", function (event) {
        if (event.target.closest("a")) {
            setOpen(false);
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            setOpen(false);
        }
    });

    // Highlight the menu link of the section that is on screen (home page only)
    if (!("IntersectionObserver" in window)) {
        return;
    }

    const links = {};

    nav.querySelectorAll("a").forEach(function (link) {
        const href = link.getAttribute("href") || "";

        if (href.indexOf("index.php#") === 0 && document.getElementById(href.split("#")[1])) {
            links[href.split("#")[1]] = link;
        }
    });

    const ids = Object.keys(links);

    if (ids.length === 0) {
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                ids.forEach(function (id) {
                    links[id].classList.toggle("is-active", id === entry.target.id);
                });
            }
        });
    }, { rootMargin: "-45% 0px -50% 0px" });

    ids.forEach(function (id) {
        observer.observe(document.getElementById(id));
    });
})();
