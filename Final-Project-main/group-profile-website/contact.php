<?php
// contact.php
// Midterm Exercise 4 (PHP POST method):
// the form and its result are on the same page, PHP checks the POST values
// with isset() and cleans them with htmlspecialchars() before showing them.
require_once "data/members.php";
require_once "includes/helpers.php";

$submitted = false;
$errors = [];
$name = "";
$email = "";
$message = "";

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])
    && is_string($_POST["name"]) && is_string($_POST["email"]) && is_string($_POST["message"])) {

    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Check each field and remember a short message for every problem
    if ($name === "") {
        $errors["name"] = "Enter your name.";
    }

    if ($email === "") {
        $errors["email"] = "Enter your email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email address, like name@example.com.";
    }

    if ($message === "") {
        $errors["message"] = "Enter a message.";
    }

    if (count($errors) === 0) {
        $submitted = true;
    }
}

// Used by the form below to mark fields and show messages
$hasErrors = (count($errors) > 0);
$errName = isset($errors["name"]) ? $errors["name"] : "";
$errEmail = isset($errors["email"]) ? $errors["email"] : "";
$errMessage = isset($errors["message"]) ? $errors["message"] : "";
$badName = ($errName !== "") ? "is-invalid" : "";
$badEmail = ($errEmail !== "") ? "is-invalid" : "";
$badMessage = ($errMessage !== "") ? "is-invalid" : "";

$pageTitle = "Contact Us";
include "includes/header.php";
?>

<main id="main">
    <div class="container contact-layout">

        <div class="contact-copy">
            <h1>Contact us</h1>
            <p>Have a question or an inquiry for our group? Send us a message and we will reply to the email address you give us.</p>
            <p>Want to reach one teammate directly? Leave them a quick note from the team page.</p>
            <a class="btn btn-secondary" href="index.php#fetch">Send a quick note</a>
        </div>

        <div>
            <?php if ($submitted): ?>

                <div class="card success-card">
                    <span class="success-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg>
                    </span>
                    <h2>Thank you, <?= $name ?>!</h2>
                    <p class="card-lead">We received your message and will reply to <strong><?= $email ?></strong>.</p>

                    <div class="receipt">
                        <p><strong>Your message</strong><?= nl2br($message) ?></p>
                    </div>

                    <div class="member-actions">
                        <a class="btn btn-primary" href="contact.php">Send another message</a>
                        <a class="btn btn-secondary" href="index.php#home">Back to Home</a>
                    </div>
                </div>

            <?php else: ?>

                <div class="card">
                    <h2>Send a message</h2>
                    <p class="card-lead">All fields are required.</p>

                    <?php if ($hasErrors): ?>
                        <p class="alert" role="alert" style="margin-bottom: 20px;">Please fix the highlighted fields and send your message again.</p>
                    <?php endif; ?>

                    <form class="form" id="contactForm" method="POST" action="" novalidate>
                        <div class="form-row">
                            <label for="name">Your name</label>
                            <input class="field <?= $badName ?>" type="text" id="name" name="name" maxlength="60" autocomplete="name" value="<?= $name ?>">
                            <span class="field-error" id="nameError"><?= $errName ?></span>
                        </div>

                        <div class="form-row">
                            <label for="email">Your email</label>
                            <input class="field <?= $badEmail ?>" type="email" id="email" name="email" maxlength="100" autocomplete="email" value="<?= $email ?>">
                            <span class="field-error" id="emailError"><?= $errEmail ?></span>
                        </div>

                        <div class="form-row">
                            <label for="message">Message</label>
                            <textarea class="field <?= $badMessage ?>" id="message" name="message" rows="5" maxlength="1000"><?= $message ?></textarea>
                            <span class="field-error" id="messageError"><?= $errMessage ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary">Send message</button>
                    </form>
                </div>

            <?php endif; ?>
        </div>

    </div>
</main>

<script src="js/contact.js"></script>

<?php include "includes/footer.php"; ?>
