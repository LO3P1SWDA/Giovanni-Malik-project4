<?php include "../headerNfooter/header.php"; ?>

<?php
session_start();

// Establish database connection
$conn = new mysqli("localhost", "root", "", "pixelplayground");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get badge ID from form submission
$badge_id = $_POST['badge_id'];

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Define badge conditions
$badge_conditions = [
    1 => 1, // Example: Badge ID 1 requires 1 friend
    2 => 3, // Example: Badge ID 2 requires 3 friends
    // Add other badge conditions here
    999 => 0 // Secret badge condition, assuming no specific requirement
];

// Check if the user has already claimed the badge
$sql = "SELECT * FROM gebruiker_badge WHERE gebruiker_id = ? AND badge_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $badge_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "You have already claimed this badge.";
} else {
    // Check if the user meets the condition for the badge
    $badge_condition = $badge_conditions[$badge_id] ?? 0;

    $sql = "SELECT 
                (SELECT COUNT(*) FROM vrienden WHERE gebruiker_id = ?) + 
                (SELECT COUNT(*) FROM vrienden WHERE vriend_id = ?) AS friend_count";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($friend_count);
    $stmt->fetch();
    $stmt->close();

    if ($friend_count >= $badge_condition) {
        // Insert record into gebruiker_badge table
        $sql = "INSERT INTO gebruiker_badge (gebruiker_id, badge_id) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $badge_id);
        if ($stmt->execute()) {
            echo "Badge claimed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "You need at least $badge_condition friends to earn this badge.";
    }
}

// Close database connection
$conn->close();
?>
<?php include "../headerNfooter/footer.php"; ?>
