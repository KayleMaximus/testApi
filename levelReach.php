<?php
// Read the current scores from the JSON file
$jsonData = file_get_contents("LevelReach.json");
$level = json_decode($jsonData, true);

// Handle update request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the player's ID and new score from the request
    $playerID = $_POST["playerID"];
    $newScore = $_POST["score"];

    // Update the player's score in the scores array
    if (isset($level[$playerID])) {
        $level[$playerID] = max($level[$playerID], $newScore);
    } else {
        $level[$playerID] = $newScore;
    }

    // Save the updated scores to the JSON file
    $jsonData = json_encode($level);
    file_put_contents("LevelReach.json", $jsonData);
}

// Handle retrieve request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Get the player's ID from the request
    $playerID = $_GET["playerID"];

    // Check if the player's score exists in the scores array
    if (isset($level[$playerID])) {
        // Return the player's score as a JSON response
        echo json_encode(array("levelReach" => $level[$playerID]));
    } else {
        // Return a default score or an error message if the player is not found
        echo json_encode(array("levelReach" => 0, "error" => "Player not found"));
    }
}
?>