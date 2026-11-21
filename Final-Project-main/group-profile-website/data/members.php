<?php
// data/members.php
// The one place where all group and member information is stored.
// Midterm Exercise 2 (PHP arrays): every page reads from here, so you only
// edit your members in this file.

$group = [
    "name"    => "Group Profile Project",
    "logo"    => "img/logo.jpg",
    "tagline" => "Meet the people behind this project.",
    "welcome" => "Welcome to our group profile website. Get to know each member of our team, search for a specific member, and send us a message.",
    "about"   => "We are a group of students who built this website as our final project. It combines everything we learned in our midterm and final exercises: HTML and CSS, PHP, GET and POST forms, JSON, XMLHttpRequest, the Fetch API, and XML."
];

// PLACEHOLDER VALUES: replace "course", "role" and "bio" for each member
// with the real details. "image" is the file name inside img/members/.
$members = [
    [
        "id"     => 1,
        "name"   => "DANILO LUCBAN",
        "image"  => "img/members/dan.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Web Project Manager",
        "bio"    => "Passionate about technology, teamwork, and project organization. 
                    Enjoys coordinating ideas, managing tasks, and bringing people together to turn concepts into successful digital projects."
    ],
    [
        "id"     => 2,
        "name"   => "JOSHUA CABIGON",
        "image"  => "img/members/joshua.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Front-End Developer",
        "bio"    => "Interested in front-end development and creating engaging digital experiences. 
                    Enjoys building responsive interfaces and exploring modern web technologies to make websites functional and easy to navigate."
    ],
    [
        "id"     => 3,
        "name"   => "JOHN DAVE BOMBALES",
        "image"  => "img/members/dave.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "UI/UX Designer",
        "bio"    => "Creative and detail-oriented, with an interest in UI/UX design and visual storytelling. 
                    Enjoys developing clean layouts and intuitive designs that provide users with a smooth and enjoyable experience."
    ],
    [
        "id"     => 4,
        "name"   => "MARCO VILLANUEVA",
        "image"  => "img/members/marco.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Back-End Developer",
        "bio"    => "Focused on programming, logical problem-solving, and back-end development. 
                    Enjoys working with server-side technologies and understanding the systems that keep websites running efficiently."
    ],
    [
        "id"     => 5,
        "name"   => "IVAN PUSING",
        "image"  => "img/members/ivan.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Web Designer",
        "bio"    => "Has an interest in visual creativity and modern web design. 
                    Enjoys experimenting with colors, typography, and layouts to create attractive and well-organized website designs.."
    ],
    [
        "id"     => 6,
        "name"   => "Zymhonne Kyle",
        "image"  => "img/members/zymhonne.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Website Administrator",
        "bio"    => "Interested in website management, organization, and system maintenance. 
                    Values reliability and consistency while ensuring that website content and features remain properly maintained."
    ],
    [
        "id"     => 7,
        "name"   => "Kianne Kyle Martinez",
        "image"  => "img/members/kyle.png",
        "course" => "BSIT - 3rd year",
        "role"   => "Web Tester",
        "bio"    => "Detail-oriented and interested in software quality and testing. 
                    Enjoys identifying errors, evaluating website functionality, and finding ways to improve performance and user experience."
    ],
    [
        "id"     => 8,
        "name"   => "Jennifer Bucani",
        "image"  => "img/members/jennifer.jpg",
        "course" => "BSIT - 3rd year",
        "role"   => "Web Content Manager",
        "bio"    => "Interested in digital communication, content organization, and information management. 
                    Enjoys creating clear and engaging content that helps visitors understand and navigate a website."
    ]

];
