<?php include "../headerNfooter/header.php";?>
<?php
session_start();
$user_id = $_SESSION['user_id'];
$vriend_id = $_POST['vriend_id'];

$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "INSERT INTO vriendschaps_verzoek (sender_id, receiver_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $vriend_id);
if ($stmt->execute()) {
    echo "Vriendschapsverzoek verzonden!";
} else {
    echo "Er is een fout opgetreden. Probeer het opnieuw.";
}
$conn->close();
?>

<?php include "../headerNfooter/footer.php";?>