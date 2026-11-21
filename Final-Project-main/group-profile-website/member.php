<?php
// member.php
// Midterm Exercise 3 (PHP GET method):
// the member id travels in the URL (member.php?id=2) and PHP reads it
// from $_GET["id"] to show that one member.
require_once "data/members.php";
require_once "includes/helpers.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// Find the member whose id matches the one in the URL
$member = null;
$position = null;

foreach ($members as $index => $m) {
    if ($m["id"] === $id) {
        $member = $m;
        $position = $index;
        break;
    }
}

$prev = null;
$next = null;

if ($member === null) {
    http_response_code(404);
} else {
    // Neighbours for the Previous / Next links
    $prev = ($position > 0) ? $members[$position - 1] : null;
    $next = ($position < count($members) - 1) ? $members[$position + 1] : null;
}

$pageTitle = ($member !== null) ? display_name($member["name"]) : "Member not found";

include "includes/header.php";
?>

<main id="main">

    <?php if ($member !== null): ?>

        <div class="container page-top">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="index.php#home">Home</a>
                <span>/</span>
                <a href="index.php#team">Meet the Team</a>
                <span>/</span>
                <span><?= e(display_name($member['name'])) ?></span>
            </nav>
        </div>

        <section class="profile-page">
            <div class="container">

                <div class="member-layout">
                    <img class="member-photo"
                         src="<?= e($member['image']) ?>"
                         alt="Photo of <?= e(display_name($member['name'])) ?>"
                         onerror="this.onerror=null;this.src='img/members/who.jpg';">

                    <div class="member-info">
                        <h1><?= e(display_name($member['name'])) ?></h1>

                        <dl class="member-facts">
                            <div class="fact">
                                <dt>Course and year</dt>
                                <dd><?= e($member['course']) ?></dd>
                            </div>
                            <div class="fact">
                                <dt>Role in the group</dt>
                                <dd><?= e($member['role']) ?></dd>
                            </div>
                        </dl>

                        <div class="member-bio">
                            <h2>Biography</h2>
                            <p><?= e(display_bio($member['bio'])) ?></p>
                        </div>

                        <div class="member-actions">
                            <a class="btn btn-primary" href="index.php#team">Back to Team</a>
                            <a class="btn btn-secondary" href="contact.php">Contact Us</a>
                            <a class="btn btn-secondary" href="api/members.php?id=<?= (int) $member['id'] ?>" target="_blank" rel="noopener">View as JSON</a>
                        </div>
                    </div>
                </div>

                <div class="pager">
                    <?php if ($prev !== null): ?>
                        <a class="pager-prev" href="member.php?id=<?= (int) $prev['id'] ?>">
                            <small>Previous member</small>
                            <strong><?= e(display_name($prev['name'])) ?></strong>
                        </a>
                    <?php endif; ?>

                    <?php if ($next !== null): ?>
                        <a class="pager-next" href="member.php?id=<?= (int) $next['id'] ?>">
                            <small>Next member</small>
                            <strong><?= e(display_name($next['name'])) ?></strong>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </section>

    <?php else: ?>

        <div class="container">
            <div class="not-found">
                <h1>Member not found</h1>
                <p>There is no member with that id. Go back to the team list and pick a member from there.</p>
                <a class="btn btn-primary" href="index.php#team">Back to Team</a>
            </div>
        </div>

    <?php endif; ?>

</main>

<?php include "includes/footer.php"; ?>
