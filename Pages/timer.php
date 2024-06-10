<?php include "../headerNfooter/header.php"; ?>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$user_id = $_POST['user_id']; // Assuming you're passing the user ID
$time_taken = $_POST['time_taken']; // Assuming you're passing the time taken

// Calculate highscore based on time taken
$highscore = 10000 - $time_taken; // Adjust this calculation as needed

// Insert highscore into the database
$sql = "INSERT INTO highscores (game_id, gebruiker_id, highscore) VALUES (2, $user_id, $highscore)"; // Assuming Connect 4 has game ID 2

if ($conn->query($sql) === TRUE) {
    echo "Highscore recorded successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<?php include "../headerNfooter/footer.php"; ?>