<?php
// includes/header.php
// Shared top of every page: <head>, group header and navigation.
// Before including this file, set $pageTitle and load data/members.php ($group).
require_once __DIR__ . "/helpers.php";

// Which menu item should look selected on this page
$currentPage = basename($_SERVER["SCRIPT_NAME"]);
$navTeam     = ($currentPage === "member.php") ? "is-active" : "";
$navContact  = ($currentPage === "contact.php") ? "is-active" : "";
$group = [
    "name"    => "Group Profile Project",
    "logo"    => "img/logo1.jpg",
    "tagline" => "Meet the people behind this project.",
    "welcome" => "Welcome to our group profile website. Get to know each member of our team, search for a specific member, and send us a message.",
    "about"   => "We are a group of students who built this website as our final project. It combines everything we learned in our midterm and final exercises: HTML and CSS, PHP, GET and POST forms, JSON, XMLHttpRequest, the Fetch API, and XML."
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?> - <?= e($group['name']) ?></title>

    <link rel="icon" href="<?= e($group['logo']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <!-- HEADER: logo, group name and navigation (Midterm Exercise 1) -->
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="index.php#home">
                <img class="brand-logo"
                     src="<?= e($group['logo']) ?>"
                     alt="<?= e($group['name']) ?> logo">
                <span class="brand-name"><?= e($group['name']) ?></span>
            </a>

            <button class="nav-toggle" type="button" id="navToggle"
                    aria-expanded="false" aria-controls="siteNav" aria-label="Open menu">
                <span class="nav-toggle-bars"></span>
            </button>

            <nav class="site-nav" id="siteNav" aria-label="Main navigation">
                <a href="index.php#home">Home</a>
                <a href="index.php#about">About Us</a>
                <a href="index.php#team" class="<?= $navTeam ?>">Meet the Team</a>
                <a href="index.php#fetch">Notes</a>
                <a href="index.php#data">Data</a>
                <a href="contact.php" class="<?= $navContact ?>">Contact Us</a>
            </nav>
        </div>
    </header>
