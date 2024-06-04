<?php include "../headerNfooter/header.php";?>

<h2>Gebruikersnaam Aanpassen</h2><br>
<form class="GebruikersnaamSwitch" method="POST">
    <label for="new_username">Nieuwe Gebruikersnaam:</label>
    <input type="text" id="new_username" name="new_username" required><br>

    <label for="confirm_new_username">Bevestig Nieuwe Gebruikersnaam:</label>
    <input type="text" id="confirm_new_username" name="confirm_new_username" required><br>

    <label for="security_answer">Antwoord op Geheime Vraag:</label>
    <input type="text" id="security_answer" name="security_answer" required><br>

    <button type="submit">Verander Gebruikersnaam</button>
</form>

<?php
$conn = new mysqli("localhost", "root", "", "pixelplayground");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$user_id = $_SESSION['user_id'] ?? 1; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['new_username'];
    $confirm_new_username = $_POST['confirm_new_username'];
    $security_answer = $_POST['security_answer'];

    if ($new_username === $confirm_new_username) {
        $sql = "SELECT `secret_answer` FROM `gebruikers` WHERE `id` = '$user_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_answer = $row['secret_answer'];

            if (password_verify($security_answer, $hashed_answer)) {
                $stmt = $conn->prepare("UPDATE `gebruikers` SET `gebruikersnaam` = ? WHERE `id` = ?");
                $stmt->bind_param("si", $new_username, $user_id);

                if ($stmt->execute()) {
                    echo "Gebruikersnaam succesvol aangepast.";
                } else {
                    echo "Er is een fout opgetreden bij het updaten van de gebruikersnaam.";
                }
                $stmt->close();
            } else {
                echo "Het antwoord op de geheime vraag is onjuist.";
            }
        } else {
            echo "Gebruiker niet gevonden.";
        }
    } else {
        echo "De nieuwe gebruikersnaam en de bevestiging komen niet overeen.";
    }
}

$conn->close();
?>

<?php include "../headerNfooter/footer.php";?>
