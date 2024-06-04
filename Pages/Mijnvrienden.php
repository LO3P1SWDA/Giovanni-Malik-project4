<?php include "../headerNfooter/header.php"; ?>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Afhandelen van uitlogverzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout']) && $_POST['logout'] == '1') {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    session_destroy();
    header("Location: login.php");
    exit();
}

// Controleer of gebruiker ingelogd is
if (isset($_SESSION['username'])) {
    echo "<h1>Welkom " . '<strong>' . $_SESSION['username'] . " !</strong></h1>";
} else {
    header('Location: login.php');
    exit();
}

// Functie om vrienden te verwijderen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_friend'])) {
    $friend_id = $_POST['friend_id'];
    $user_id = $_SESSION['user_id'];
    $delete_sql = "DELETE FROM vrienden WHERE (gebruiker_id = ? AND vriend_id = ?) OR (gebruiker_id = ? AND vriend_id = ?)";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Haal vriendenlijst op
$user_id = $_SESSION['user_id'];
$sql = "SELECT DISTINCT g.id AS vriend_id, g.gebruikersnaam 
        FROM gebruikers g 
        JOIN vrienden v ON (v.vriend_id = g.id OR v.gebruiker_id = g.id)
        WHERE (v.gebruiker_id = ? OR v.vriend_id = ?) AND g.id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Vriendenlijst:</h1><ul>";
while ($row = $result->fetch_assoc()) {
    $friend_id = htmlspecialchars($row['vriend_id']);
    $friend_username = htmlspecialchars($row['gebruikersnaam']);
    echo "<section class='voegVriend'>
            <a class='Friend' href='VriendProfile.php?friend_id=$friend_id'>$friend_username</a>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='friend_id' value='$friend_id'>
                <button class='vwVriend' type='submit' name='delete_friend'>Verwijderen</button>
            </form>"
        . "</section>";
}
echo "</ul>";

$stmt->close();
$conn->close();
?>
</form>

<?php include "../headerNfooter/footer.php"; ?>
