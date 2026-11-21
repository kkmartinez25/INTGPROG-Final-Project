<?php
// includes/helpers.php
// Small display helpers shared by every page. They only change how text is
// shown on screen; the data in data/members.php and data/members.xml is untouched.

// Escape text before printing it into HTML.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

// "JOHN DAVE BOMBALES" -> "John Dave Bombales" (easier to read in headings).
function display_name($name)
{
    return ucwords(strtolower((string) $name));
}

// Shows a friendly line while a member's bio is still the template text.
function display_bio($bio)
{
    if (stripos((string) $bio, "goes here") !== false) {
        return "This member's bio will be added soon.";
    }

    return (string) $bio;
}
?>
