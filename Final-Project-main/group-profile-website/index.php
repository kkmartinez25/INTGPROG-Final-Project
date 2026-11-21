<?php
// index.php
// Midterm Exercise 2: member data comes from a PHP array (data/members.php)
//                     and the cards are generated with foreach.
// Midterm Exercise 3: the search form sends its value with GET ($_GET["search"]).
// Final Exercise 1:   json_encode() / json_decode() in the data section below.
// Final Exercise 2:   live member search with XMLHttpRequest (js/xhr.js).
// Final Exercise 3:   Fetch API section (js/fetch.js).
// Final Exercise 4:   data/members.xml is read with PHP (simplexml_load_file).
require_once "data/members.php";

// ---------- Midterm 3: read the search text from the URL (?search=...) ----------
$search = (isset($_GET["search"]) && is_string($_GET["search"])) ? trim($_GET["search"]) : "";

// Keep only the members that match the search (all members if it is empty)
$visibleMembers = [];

foreach ($members as $member) {
    if ($search === ""
        || stripos($member["name"], $search) !== false
        || stripos($member["course"], $search) !== false
        || stripos($member["role"], $search) !== false) {

        $visibleMembers[] = $member;
    }
}

// ---------- Final 4: read data/members.xml with PHP ----------
$xmlPath = __DIR__ . "/data/members.xml";
$xml = null;
$xmlError = "";

if (!file_exists($xmlPath)) {
    $xmlError = "The file data/members.xml could not be found.";
} else {
    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($xmlPath);

    if ($xml === false) {
        $xml = null;
        $xmlError = "The file data/members.xml is not well-formed XML.";
    }
}

// The first member written out as XML text, one tag per line
$xmlSnippet = "";

if ($xml !== null && isset($xml->member[0])) {
    $xmlSnippet = "<member>\n";

    foreach ($xml->member[0]->children() as $tag => $value) {
        $xmlSnippet .= "    <" . $tag . ">" . htmlspecialchars((string) $value, ENT_XML1) . "</" . $tag . ">\n";
    }

    $xmlSnippet .= "</member>";
}

// ---------- Final 1: the same member as JSON (like lab1 and lab2) ----------
$firstMember = $members[0];
$json = json_encode($firstMember, JSON_PRETTY_PRINT);   // PHP array -> JSON text
$asObject = json_decode($json);                         // JSON text -> object
$asArray  = json_decode($json, true);                   // JSON text -> array

// ---------- Display values used by the page below ----------
$resultCount   = count($visibleMembers);
$avatarMembers = array_slice($members, 0, 5);
$memberTotal   = count($members);

$pageTitle = "Finals";
include "includes/header.php";
?>

<main id="main">

    <!-- HOME: introduction and welcome message -->
    <section class="hero" id="home">
        <div class="container hero-grid">
            <div>
                <h1><?= e($group['tagline']) ?></h1>
                <p class="hero-lead"><?= e($group['welcome']) ?></p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#team">Meet Our Team</a>
                    <a class="btn btn-light" href="contact.php">Contact Us</a>
                </div>

                <div class="hero-people">
                    <div class="avatar-stack">
                        <?php foreach ($avatarMembers as $avatar): ?>
                            <img src="<?= e($avatar['image']) ?>"
                                 alt="<?= e(display_name($avatar['name'])) ?>"
                                 onerror="this.onerror=null;this.src='img/members/who.jpg';">
                        <?php endforeach; ?>
                    </div>
                    <span><?= (int) $memberTotal ?> members, one team</span>
                </div>
            </div>

            <div class="hero-visual">
                <img src="<?= e($group['logo']) ?>" alt="<?= e($group['name']) ?> logo">
            </div>
        </div>
    </section>

    <!-- ABOUT OUR GROUP -->
    <section class="section" id="about">
        <div class="container about-grid">
            <div class="about-text">
                <h2>About our group</h2>
                <p><?= e($group['about']) ?></p>
            </div>

            <ul class="about-list">
                <li>
                    <h3>Team profiles</h3>
                    <p>Every member has a profile card and a full profile page, built from one PHP array.</p>
                </li>
                <li>
                    <h3>Search and contact</h3>
                    <p>Find a member by name, course or role, or send the group a message with the contact form.</p>
                </li>
                <li>
                    <h3>Live team data</h3>
                    <p>Load member information without reloading the page, and read the same team data from JSON and XML.</p>
                </li>
            </ul>
        </div>
    </section>

    <!-- MEET THE TEAM: search (GET, and live with XMLHttpRequest) and profile cards built with foreach -->
    <section class="section section-alt" id="team">
        <div class="container">
            <div class="section-head section-head-row">
                <div>
                    <h2>Meet the team</h2>
                    <p>Get to know the people behind the project. Search by name, course or role.</p>
                </div>

                <form class="search-form" id="searchForm" method="get" action="index.php#team">
                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="M20 20l-3.5-3.5"></path></svg>
                        <input type="text" id="search" name="search"
                               placeholder="Search members"
                               aria-label="Search members by name, course or role"
                               value="<?= e($search) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>

                    <a class="btn btn-secondary" id="searchClear" href="index.php#team"<?= $search === "" ? " hidden" : "" ?>>Show all</a>
                </form>
            </div>

            <!-- js/xhr.js replaces everything inside #teamResults while the visitor types -->
            <div id="teamResults" aria-live="polite">

            <?php if ($search !== ""): ?>
                <p class="result-note">
                    <?= (int) $resultCount ?> result(s) for "<?= e($search) ?>"
                </p>
            <?php endif; ?>

            <?php if ($resultCount === 0): ?>

                <div class="empty-state">
                    <h3>No members found</h3>
                    <p>Nobody matches "<?= e($search) ?>". Try a different name, course or role.</p>
                    <a class="btn btn-primary" href="index.php#team">Show all members</a>
                </div>

            <?php else: ?>

                <div class="team-grid teamProfile">

                    <?php foreach ($visibleMembers as $index => $member): ?>

                        <article class="profile"
                                 data-name="<?= e($member['name']) ?>"
                                 data-index="<?= (int) $index ?>">

                            <img class="profile-photo"
                                 src="<?= e($member['image']) ?>"
                                 alt="Photo of <?= e(display_name($member['name'])) ?>"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='img/members/who.jpg';">

                            <div class="profile-body">
                                <h3><?= e(display_name($member['name'])) ?></h3>
                                <p class="course"><?= e($member['course']) ?></p>
                                <span class="chip role"><?= e($member['role']) ?></span>
                                <p class="bio"><?= e(display_bio($member['bio'])) ?></p>

                                <!-- GET: passes the member id in the URL (member.php?id=1) -->
                                <div class="profile-actions">
                                    <a class="btn btn-secondary btn-block" href="member.php?id=<?= (int) $member['id'] ?>">View Profile</a>
                                </div>
                            </div>
                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- FETCH API: GET and POST without reloading (js/fetch.js) -->
    <section class="section section-alt" id="fetch">
        <div class="container">
            <div class="section-head">
                <h2>Team roster and quick notes</h2>
                <p>Load the full roster or leave a note for a teammate. Everything updates in place.</p>
            </div>

            <div class="tool-grid">
                <div class="card">
                    <div class="card-head">
                        <h3>Team roster</h3>
                        <span class="tag">Fetch API (GET)</span>
                    </div>
                    <p class="card-lead">Loads every member from our JSON endpoint.</p>

                    <button type="button" class="btn btn-primary" id="fetchLoad">Load team roster</button>
                    <div class="output" id="fetchOutput" aria-live="polite">Click the button to load the roster.</div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h3>Send a quick note</h3>
                        <span class="tag">Fetch API (POST)</span>
                    </div>
                    <p class="card-lead">Your note is sent as JSON and the reply appears below.</p>

                    <form class="form" id="fetchForm">
                        <div class="form-row">
                            <label for="noteMember">To</label>
                            <select class="field" id="noteMember" required>
                                <option value="">Select a member</option>
                                <?php foreach ($members as $member): ?>
                                    <option value="<?= (int) $member['id'] ?>"><?= e(display_name($member['name'])) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <label for="noteName">Your name</label>
                            <input class="field" type="text" id="noteName" maxlength="60" required>
                        </div>

                        <div class="form-row">
                            <label for="noteText">Note</label>
                            <textarea class="field" id="noteText" rows="3" maxlength="300" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send note</button>
                    </form>

                    <div class="output" id="fetchResult" aria-live="polite">Your reply will appear here.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- XML AND JSON: the same team data in two formats, processed by PHP -->
    <section class="section" id="data">
        <div class="container">
            <div class="section-head">
                <h2>Team data in XML and JSON</h2>
                <p>Our team information is stored in two structured formats. PHP reads the XML file and builds the roster table below.</p>
            </div>

            <div class="stack">

                <div class="card">
                    <div class="card-head">
                        <h3>Team roster</h3>
                        <span class="tag">XML</span>
                    </div>
                    <p class="card-lead">Read from <code>data/members.xml</code> with PHP.</p>

                    <?php if ($xmlError !== ""): ?>

                        <p class="alert"><?= e($xmlError) ?></p>

                    <?php else: ?>

                        <div class="table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Course and year</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($xml->member as $m): ?>
                                        <tr>
                                            <td><?= e((string) $m->id) ?></td>
                                            <td><?= e((string) $m->name) ?></td>
                                            <td><?= e((string) $m->course) ?></td>
                                            <td><?= e((string) $m->role) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>
                </div>

                <!-- <div class="card">
                    <div class="card-head">
                        <h3>One member, two formats</h3>
                        <span class="tag">JSON</span>
                    </div>
                    <p class="card-lead">The same member written as XML and as JSON.</p>

                    <div class="formats">
                        <div>
                            <h4>XML</h4>
                            <pre><?= e($xmlSnippet !== "" ? $xmlSnippet : "XML data is not available.") ?></pre>
                        </div>
                        <div>
                            <h4>JSON</h4>
                            <pre><?= e($json) ?></pre>
                        </div>
                    </div>

                    <p class="decoded">
                        Decoded with <code>json_decode()</code>:
                        as an object, <code>name</code> is <strong><?= e($asObject->name) ?></strong>;
                        as an array, <code>role</code> is <strong><?= e($asArray["role"]) ?></strong>.
                    </p>

                    <div class="api-links">
                        <a class="btn btn-secondary btn-sm" href="api/members.php" target="_blank" rel="noopener">Open JSON: all members</a>
                        <a class="btn btn-secondary btn-sm" href="api/members.php?id=2" target="_blank" rel="noopener">Open JSON: one member</a>
                    </div>
                </div> -->

            </div>
        </div>
    </section>

</main>

<script>
    // Clicking a card highlights it. Delegated, because js/xhr.js re-creates the cards.
    document.getElementById("teamResults").addEventListener("click", function (event) {
        const profile = event.target.closest(".profile");

        if (profile === null) {
            return;
        }

        this.querySelectorAll(".profile").forEach(function (card) {
            card.classList.remove("active");
        });

        profile.classList.add("active");
    });
</script>
<script src="js/common.js"></script>
<script src="js/xhr.js"></script>
<script src="js/fetch.js"></script>

<?php include "includes/footer.php"; ?>
