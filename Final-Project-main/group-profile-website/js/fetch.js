// js/fetch.js
// Final Exercise 3 (Fetch API) with Final Exercise 1 (JSON).
// Same pattern as fetch-demo: fetch(), .then(), response.ok, response.json(), .catch().

const rosterOutput = document.getElementById("fetchOutput");
const noteResult = document.getElementById("fetchResult");

function showFetchError(box, message) {
    box.className = "output error";
    box.textContent = "Error: " + message;
}

// =========================
// GET REQUEST: team roster
// =========================

document.getElementById("fetchLoad").addEventListener("click", function () {

    rosterOutput.className = "output";
    rosterOutput.textContent = "Loading...";

    fetch("api/members.php")

        .then(response => {

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return response.json();
        })

        .then(data => {

            rosterOutput.className = "output filled";
            rosterOutput.textContent = "";

            const heading = makeElement("p", "roster-head", "Team roster (" + data.count + " members)");
            rosterOutput.appendChild(heading);

            const list = makeElement("ul", "roster-list");

            data.members.forEach(member => {
                const item = document.createElement("li");
                item.appendChild(makeElement("span", "roster-name", formatName(member.name)));
                item.appendChild(makeElement("span", "roster-meta", member.role + " - " + member.course));
                list.appendChild(item);
            });

            rosterOutput.appendChild(list);
        })

        .catch(error => {
            showFetchError(rosterOutput, error.message);
        });
});

// =========================
// POST REQUEST: quick note
// =========================

document.getElementById("fetchForm").addEventListener("submit", function (event) {

    // Stop the normal form submit so the page does not reload
    event.preventDefault();

    const form = this;

    const memberId = document.getElementById("noteMember").value;
    const name = document.getElementById("noteName").value;
    const message = document.getElementById("noteText").value;

    noteResult.className = "output";
    noteResult.textContent = "Sending note...";

    fetch("api/message.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            member_id: Number(memberId),
            name: name,
            message: message
        })

    })

        .then(response => {

            if (!response.ok) {
                // The server explains the problem in its JSON reply, so show that
                return response.json()
                    .catch(() => ({}))
                    .then(data => {
                        throw new Error(data.message || `HTTP error! Status: ${response.status}`);
                    });
            }

            return response.json();
        })

        .then(data => {

            noteResult.className = "output success";
            noteResult.textContent = data.message;

            form.reset();
        })

        .catch(error => {
            showFetchError(noteResult, error.message);
        });
});
