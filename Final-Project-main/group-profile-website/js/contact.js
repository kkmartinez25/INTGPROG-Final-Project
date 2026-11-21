// js/contact.js
// Friendly checks before the contact form is sent with POST (Midterm 4).
// PHP checks the same fields again on the server, so nothing is skipped
// if JavaScript is turned off.

(function () {
    const form = document.getElementById("contactForm");

    if (!form) {
        return;
    }

    const rules = [
        { id: "name", error: "nameError", empty: "Enter your name." },
        { id: "email", error: "emailError", empty: "Enter your email address.", invalid: "Enter a valid email address, like name@example.com." },
        { id: "message", error: "messageError", empty: "Enter a message." }
    ];

    function check(rule) {
        const field = document.getElementById(rule.id);
        const output = document.getElementById(rule.error);
        const value = field.value.trim();
        let problem = "";

        if (value === "") {
            problem = rule.empty;
        } else if (rule.id === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            problem = rule.invalid;
        }

        field.classList.toggle("is-invalid", problem !== "");
        output.textContent = problem;

        return problem === "";
    }

    rules.forEach(function (rule) {
        const field = document.getElementById(rule.id);

        // Re-check as the person fixes the field
        field.addEventListener("input", function () {
            if (field.classList.contains("is-invalid")) {
                check(rule);
            }
        });

        field.addEventListener("blur", function () {
            if (field.value.trim() !== "") {
                check(rule);
            }
        });
    });

    form.addEventListener("submit", function (event) {
        let allGood = true;
        let firstBad = null;

        rules.forEach(function (rule) {
            if (!check(rule)) {
                allGood = false;

                if (firstBad === null) {
                    firstBad = document.getElementById(rule.id);
                }
            }
        });

        if (!allGood) {
            event.preventDefault();
            firstBad.focus();
        }
    });
})();
