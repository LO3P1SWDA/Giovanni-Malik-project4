<?php include "../headerNfooter/header.php"; ?>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$friend_id = $_GET['friend_id'] ?? 0;

$sql = "SELECT gebruikersnaam FROM gebruikers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $friend_username = $result->fetch_assoc()['gebruikersnaam'];
    echo "<h1>Profiel van $friend_username</h1>";
} else {
    echo "<h1>Gebruiker niet gevonden</h1>";
    exit();
}
$stmt->close();

$sql = "SELECT 
            g.game_name AS `Game Name`,
            ranked.highscore AS `Highscore`,
            ranked.timestamp AS `Timestamp`
        FROM 
            (SELECT 
                h.game_id,
                h.highscore,
                h.timestamp,
                h.gebruiker_id,
                ROW_NUMBER() OVER (PARTITION BY h.game_id, h.gebruiker_id ORDER BY h.highscore DESC) AS rank
            FROM 
                highscores h) ranked
        JOIN 
            games g ON ranked.game_id = g.id
        WHERE 
            ranked.rank <= 5 AND ranked.gebruiker_id = ?
        ORDER BY 
            g.game_name, ranked.rank";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$result = $stmt->get_result();

$current_game = '';
echo "<h1>HIGHSCORES:</h1><br>";
while ($row = $result->fetch_assoc()) {
    if ($current_game != $row['Game Name']) {
        if ($current_game != '') {
            echo "</ul>"; 
        }
        $current_game = $row['Game Name'];
        echo "<h2>" . htmlspecialchars($current_game) . "</h2><ul>";
    }
    echo "<p class='ProfileHS'>Highscore: " . htmlspecialchars($row['Highscore']) . " - Timestamp: " . htmlspecialchars($row['Timestamp']) . "</p>";
}
if ($current_game != '') {
    echo "</ul>"; 
}
$stmt->close();

$sql = "SELECT b.naam, b.image 
        FROM gebruiker_badge gb
        JOIN badges b ON gb.badge_id = b.id
        WHERE gb.gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1 class='ProfileBadges'>BADGES:</h1><br><ul>";
while ($row = $result->fetch_assoc()) {
    $badge_name = htmlspecialchars($row['naam']);
    $badge_image = htmlspecialchars($row['image']);
    echo "<li><img class='badgesFoto' src='$badge_image' alt='$badge_name' title='$badge_name'></li><br>";
}
echo "</ul>";

$stmt->close();
$conn->close();
?>
<?php include "../headerNfooter/footer.php"; ?>
