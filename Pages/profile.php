<?php include "../headerNfooter/header.php";?>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout']) && $_POST['logout'] == '1') {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['username'])) {
    echo "<h1>Welkom " . '<strong>' . $_SESSION['username'] . " !</strong></h1>";
} else {
    header('Location: login.php');
    exit();
}
?>

<a class="myV" href="Mijnvrienden.php">Mijn Vrienden</a>

<?php
$user_id = $_SESSION['user_id'] ?? 1; 

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
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$current_game = '';
echo "<h1>HIGHSCORES:</h1>";
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

// Fetch badges after closing the previous statement
$sql = "SELECT badges.id, badges.naam, badges.badge_condition, badges.image 
        FROM gebruiker_badge 
        INNER JOIN badges ON gebruiker_badge.badge_id = badges.id 
        WHERE gebruiker_id = $user_id";
$result = $conn->query($sql);
echo "<h1>Badges:</h1>";
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<h3>{$row['naam']}</h3>";
        echo "<img class='badgesFoto' src='{$row['image']}' alt='{$row['naam']}'><br><br>";
    }
} else {
    echo "No badges earned yet.<br><br>";
}

// Close database connection
$conn->close();
?>

<a class="wSwitch" href="wachtwoord.php">Wachtwoord Veranderen</a>
<a class="gSwitch" href="gebruikersnaam.php">Gebruikersnaam Veranderen</a>

<form action="" method="POST">
    <input type="hidden" name="logout" value="1">
    <button type="submit">Log Uit</button>
</form>

<?php include "../headerNfooter/footer.php";?>
