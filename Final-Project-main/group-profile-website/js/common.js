// js/common.js
// Small helpers shared by xhr.js and fetch.js. They only change how text is
// displayed; the data from the JSON endpoints is not modified.

// "JOHN DAVE BOMBALES" -> "John Dave Bombales"
function formatName(name) {
    return String(name).toLowerCase().replace(/\b\w/g, function (letter) {
        return letter.toUpperCase();
    });
}

// Shows a friendly line while a bio is still the template text
function formatBio(bio) {
    if (String(bio).toLowerCase().indexOf("goes here") !== -1) {
        return "This member's bio will be added soon.";
    }

    return String(bio);
}

// Builds <tag class="className">text</tag> (textContent keeps the text safe)
function makeElement(tag, className, text) {
    const element = document.createElement(tag);

    if (className) {
        element.className = className;
    }

    if (text !== undefined) {
        element.textContent = text;
    }

    return element;
}
