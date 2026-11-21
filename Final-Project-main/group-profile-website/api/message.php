<?php
// api/message.php
// Final Exercise 1 (JSON): receives JSON with php://input and answers with JSON,
// like lab4_input.php and lab5.php. Used by the Fetch API quick note.
// The note is only confirmed, it is not stored anywhere.

header("Content-Type: application/json");

require_once __DIR__ . "/../data/members.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "status"  => "error",
        "message" => "Please send the note with the POST method."
    ]);
    exit;
}

// Read the raw JSON sent by fetch() and turn it into a PHP array
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "The request did not contain valid JSON."
    ]);
    exit;
}

$memberId = isset($data["member_id"]) ? (int) $data["member_id"] : 0;
$name     = (isset($data["name"]) && is_string($data["name"])) ? trim($data["name"]) : "";
$message  = (isset($data["message"]) && is_string($data["message"])) ? trim($data["message"]) : "";

// Find who the note is for
$memberName = "";

foreach ($members as $member) {
    if ($member["id"] === $memberId) {
        $memberName = $member["name"];
        break;
    }
}

if ($memberName === "") {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Please choose a member to send the note to."
    ]);
    exit;
}

if ($name === "" || $message === "") {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Please enter your name and a note."
    ]);
    exit;
}

echo json_encode([
    "status"  => "success",
    "message" => "Thank you, " . $name . "! Your note for " . $memberName . " was received."
]);
?>
