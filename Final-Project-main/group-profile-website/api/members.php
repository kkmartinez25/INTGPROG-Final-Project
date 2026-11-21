<?php
// api/members.php
// Final Exercise 1 (JSON): a PHP endpoint that returns JSON, like lab3_api.php.
//   api/members.php        -> every member
//   api/members.php?id=2   -> one member
//   api/members.php?search=web -> members whose name, course or role contains "web"
//                                 (used by the live search in js/xhr.js)

header("Content-Type: application/json");

require_once __DIR__ . "/../data/members.php";

if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    foreach ($members as $member) {
        if ($member["id"] === $id) {
            echo json_encode([
                "status" => "success",
                "member" => $member
            ]);
            exit;
        }
    }

    http_response_code(404);
    echo json_encode([
        "status"  => "error",
        "message" => "Member not found"
    ]);
    exit;
}

// Same matching rule as the ?search= filter in index.php
$search = (isset($_GET["search"]) && is_string($_GET["search"])) ? trim($_GET["search"]) : "";
$found  = [];

foreach ($members as $member) {
    if ($search === ""
        || stripos($member["name"], $search) !== false
        || stripos($member["course"], $search) !== false
        || stripos($member["role"], $search) !== false) {

        $found[] = $member;
    }
}

echo json_encode([
    "status"  => "success",
    "search"  => $search,
    "count"   => count($found),
    "members" => $found
]);
?>
