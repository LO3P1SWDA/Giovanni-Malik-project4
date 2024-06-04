<?php include "../headerNfooter/header.php";?>
<?php
session_start();
$request_id = $_POST['request_id'];
$action = $_POST['action'];

$conn = new mysqli("localhost", "root", "", "pixelplayground");
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($action == 'accept') {
    // Update the request to accepted
    $sql = "UPDATE vriendschaps_verzoek SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    if ($stmt->execute()) {
        // Add to vrienden table
        $stmt = $conn->prepare("SELECT sender_id, receiver_id FROM vriendschaps_verzoek WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt = $conn->prepare("INSERT INTO vrienden (gebruiker_id, vriend_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $row['sender_id'], $row['receiver_id']);
        $stmt->execute();
    }
} elseif ($action == 'ignore') {
    // Update the request to ignored
    $sql = "UPDATE vriendschaps_verzoek SET status = 'ignored' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
}

$conn->close();
header("Location: verzoeklijst.php");
?>
<?php include "../headerNfooter/footer.php";?>