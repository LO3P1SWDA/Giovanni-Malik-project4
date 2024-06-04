<?php include "../headerNfooter/header.php"; ?>
<div class="friend-requests-page">
    <h2>Vriendschapverzoeken</h2>
    <ul id="friendRequestList">
        <?php
        session_start();
        $user_id = $_SESSION['user_id'];

        $conn = new mysqli("localhost", "root", "", "pixelplayground");
        if ($conn->connect_error) {
            die("Verbinding mislukt: " . $conn->connect_error);
        }

        $sql = "SELECT vv.id AS request_id, g.gebruikersnaam, vv.sender_id 
                FROM vriendschaps_verzoek vv
                JOIN gebruikers g ON vv.sender_id = g.id
                WHERE vv.receiver_id = ? AND vv.status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["gebruikersnaam"] .
                    " <form action='Vhandle.php' method='post' style='display:inline;'>
                        <input type='hidden' name='request_id' value='" . $row["request_id"] . "'>
                        <input type='hidden' name='action' value='accept'>
                        <button type='submit'>Accepteren</button>
                    </form>
                    <form action='Vhandle.php' method='post' style='display:inline;'>
                        <input type='hidden' name='request_id' value='" . $row["request_id"] . "'>
                        <input type='hidden' name='action' value='ignore'>
                        <button type='submit'>Negeren</button>
                    </form></li>";
            }
        } else {
            echo "Geen vriendschapverzoeken.";
        }
        $conn->close();
        ?>
    </ul>
</div>
<?php include "../headerNfooter/footer.php"; ?>
