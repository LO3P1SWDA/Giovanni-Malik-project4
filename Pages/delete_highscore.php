<?php
session_start();
include "../headerNfooter/header.php";

$conn = new mysqli("localhost", "root", "", "pixelplayground");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is set in POST data
if (isset($_POST['user_id'])) {
    // Prepare SQL statement to delete the highscore from the database
    $stmt = $conn->prepare("DELETE FROM highscores WHERE gebruiker_id = ?");
    $stmt->bind_param("i", $_POST['user_id']);

    // Execute the SQL statement
    if ($stmt->execute() === TRUE) {
        echo "Highscore deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "User ID not received";
}

// Close the database connection
$conn->close();

include "../headerNfooter/footer.php";
?>
