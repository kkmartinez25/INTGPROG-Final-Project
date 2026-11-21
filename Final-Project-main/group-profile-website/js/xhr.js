// js/xhr.js
// Final Exercise 2 (XMLHttpRequest): live member search.
// While the visitor types in the search bar, the matching members are loaded
// from api/members.php?search=... and the cards are replaced in place,
// without reloading the page. Same pattern as xhr-demo.html:
// xhr.open(), xhr.send(), onreadystatechange, readyState, status, onerror.
//
// Without JavaScript the form still works: it submits ?search=... to index.php.

const searchForm    = document.getElementById("searchForm");
const searchInput   = document.getElementById("search");
const searchClear   = document.getElementById("searchClear");
const teamResults   = document.getElementById("teamResults");

let searchTimer = null;   // waits for a short pause in typing
let searchXhr   = null;   // the request that is currently running

function buildCard(member) {
    const card = makeElement("article", "profile");
    card.dataset.name = member.name;

    const photo = document.createElement("img");
    photo.className = "profile-photo";
    photo.src = member.image;
    photo.alt = "Photo of " + formatName(member.name);
    photo.loading = "lazy";
    photo.onerror = function () {
        this.onerror = null;
        this.src = "img/members/who.jpg";
    };
    card.appendChild(photo);

    const body = makeElement("div", "profile-body");
    body.appendChild(makeElement("h3", "", formatName(member.name)));
    body.appendChild(makeElement("p", "course", member.course));
    body.appendChild(makeElement("span", "chip role", member.role));
    body.appendChild(makeElement("p", "bio", formatBio(member.bio)));

    const actions = makeElement("div", "profile-actions");
    const link = makeElement("a", "btn btn-secondary btn-block", "View Profile");
    link.href = "member.php?id=" + encodeURIComponent(member.id);
    actions.appendChild(link);
    body.appendChild(actions);

    card.appendChild(body);
    return card;
}

function showResults(search, members) {
    teamResults.textContent = "";

    if (search !== "") {
        teamResults.appendChild(
            makeElement("p", "result-note", members.length + ' result(s) for "' + search + '"')
        );
    }

    if (members.length === 0) {
        const empty = makeElement("div", "empty-state");
        empty.appendChild(makeElement("h3", "", "No members found"));
        empty.appendChild(makeElement("p", "", 'Nobody matches "' + search + '". Try a different name, course or role.'));

        const showAll = makeElement("button", "btn btn-primary", "Show all members");
        showAll.type = "button";
        showAll.addEventListener("click", clearSearch);
        empty.appendChild(showAll);

        teamResults.appendChild(empty);
        return;
    }

    const grid = makeElement("div", "team-grid teamProfile");
    members.forEach(function (member) {
        grid.appendChild(buildCard(member));
    });
    teamResults.appendChild(grid);
}

function showSearchError(text) {
    teamResults.textContent = "";
    teamResults.appendChild(makeElement("div", "output error", "Error: " + text));
}

function runSearch() {
    const search = searchInput.value.trim();

    // Keep the address bar in step with the box (so a refresh shows the same list)
    const url = search === "" ? "index.php" : "index.php?search=" + encodeURIComponent(search);
    history.replaceState(null, "", url + "#team");
    searchClear.hidden = (search === "");

    // A newer search makes the older one pointless
    if (searchXhr !== null) {
        searchXhr.abort();
    }

    const xhr = new XMLHttpRequest();
    searchXhr = xhr;

    xhr.onreadystatechange = function () {
        if (xhr.readyState !== XMLHttpRequest.DONE || searchXhr !== xhr) {
            return;   // not finished yet, or an older request that was replaced
        }

        searchXhr = null;

        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                showResults(search, response.members);
            } catch (error) {
                showSearchError("Unable to process the server response.");
            }

        } else if (xhr.status !== 0) {
            showSearchError(xhr.status + " - " + (xhr.statusText || "Request failed"));
        }
    };

    xhr.onerror = function () {
        if (searchXhr === xhr) {
            searchXhr = null;
            showSearchError("Network problem or server could not be reached.");
        }
    };

    xhr.open("GET", "api/members.php?search=" + encodeURIComponent(search), true);
    xhr.send();
}

function clearSearch() {
    searchInput.value = "";
    clearTimeout(searchTimer);
    runSearch();
    searchInput.focus();
}

// Search as the visitor types, after a short pause so we do not send a request per key
searchInput.addEventListener("input", function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(runSearch, 250);
});

// Enter or the Search button: search right away, no page reload
searchForm.addEventListener("submit", function (event) {
    event.preventDefault();
    clearTimeout(searchTimer);
    runSearch();
});

// "Show all" link: same, without leaving the page
searchClear.addEventListener("click", function (event) {
    event.preventDefault();
    clearSearch();
});
