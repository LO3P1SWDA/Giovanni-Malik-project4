<?php include "../headerNfooter/header.php"; ?>
<?php
session_start();

// Establish database connection
$conn = new mysqli("localhost", "root", "", "pixelplayground");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the session
$user_id = $_SESSION['user_id']; // Assuming you have user ID stored in session

// Define the ID of the secret badge
$secret_badge_id = 999; // Change this to the actual ID of your secret badge

// Fetch the secret badge details from the database
$sql = "SELECT * FROM badges WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $secret_badge_id);
$stmt->execute();
$badge_result = $stmt->get_result();

if ($badge_result->num_rows > 0) {
    $badge = $badge_result->fetch_assoc();
    $badge_name = $badge['naam'];
    $badge_image = $badge['image'];
    $badge_condition = $badge['badge_condition'];
} else {
    echo "Secret badge not found.";
    exit();
}

// Check if the user has already claimed the badge
$sql = "SELECT * FROM gebruiker_badge WHERE gebruiker_id = ? AND badge_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $secret_badge_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "You have already claimed this badge.";
} else {
    echo "<section class='badge'><h3>{$badge_name}</h3>"; 
    echo "<img class='badgesFoto' src='{$badge_image}' alt='Secret Badge'><br>";
    echo "<p>Voldoe aan deze eis: {$badge_condition}</p></section>";
    echo "<form action='claim_badge.php' method='post'>";
    echo "<input type='hidden' name='badge_id' value='{$secret_badge_id}'>";
    echo "<button class='BadgesKnop' type='submit'>Claim Secret Badge</button>";
    echo "</form>";
}

$stmt->close();
$conn->close();
?>
<?php include "../headerNfooter/footer.php"; ?>
