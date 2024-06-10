<?php include "../headerNfooter/header.php"; ?>
<?php
// Function to fetch badges from the database
function getBadgesFromDatabase() {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "pixelplayground");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch badges except the secret badge
    $sql = "SELECT * FROM badges WHERE id != 999"; // Assuming 999 is the ID of the secret badge

    // Execute the query
    $result = $conn->query($sql);

    // Array to store badge data
    $badges = [];

    // Check if query returned any rows
    if ($result->num_rows > 0) {
        // Fetch each row and store it in the $badges array
        while ($row = $result->fetch_assoc()) {
            $badges[] = $row;
        }
    }

    // Close database connection
    $conn->close();

    // Return the array of badge data
    return $badges;
}

// Now you can use the getBadgesFromDatabase() function to fetch badges
$badges = getBadgesFromDatabase();

// Loop through $badges and display them
foreach ($badges as $badge) {
    echo "<section class='badge'><h3>{$badge['naam']}</h3>"; 
    echo "<img class='badgesFoto' src='{$badge['image']}' alt='{$badge['naam']}'><br>";
    echo "<p>Voldoe aan deze eis: {$badge['badge_condition']}</p></section>";
    
    echo "<form action='claim_badge.php' method='post'>";
    echo "<input type='hidden' name='badge_id' value='{$badge['id']}'>";
    echo "<button class='BadgesKnop' type='submit'>Claim Badge</button>";
    echo "</form>";
}
?>
<!-- easter egg -->

<script>
document.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        window.location.href = "secret_badge.php";
    }
});
</script>
<?php include "../headerNfooter/footer.php"; ?>
