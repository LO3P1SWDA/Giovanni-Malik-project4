<?php include "../headerNfooter/header.php"; ?>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['game_id']) && isset($data['highscore'])) {
    // Sanitize the data
    $gameId = intval($data['game_id']);
    $highscore = intval($data['highscore']);

    // Get the user ID from the session or request parameters
    $userId = $_SESSION['user_id']; // Assuming you have a user ID stored in a session

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO highscores (game_id, gebruiker_id, highscore) VALUES (?, ?, ?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("iii", $gameId, $userId, $highscore);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Respond with success
    http_response_code(200);
    echo json_encode(array("message" => "Highscore saved successfully"));
} else {
    // Respond with an error
    http_response_code(400);
    echo json_encode(array("message" => "Unable to save highscore. Invalid data"));
}
?>
<?php include "../headerNfooter/footer.php"; ?>