<?php include "../headerNfooter/header.php"; ?>
<div class="friend-page">
    <input type="text" id="searchBox" placeholder="Zoek naar een vriend...">
    <ul id="userList">
        <?php
        $conn = new mysqli("localhost", "root", "", "pixelplayground");
        if ($conn->connect_error) {
            die("Verbinding mislukt: " . $conn->connect_error);
        }

        
        session_start();
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT id, gebruikersnaam FROM gebruikers WHERE NOT id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<section class='voegVriend'>" . $row["gebruikersnaam"] .
                    " <form action='verzoek.php' method='post' style='display:inline;'>
                        <input type='hidden' name='vriend_id' value='" . $row["id"] . "'>
                        <button class='voegBtn' type='submit'>Voeg toe als vriend</button></form></section>";
            }
        } else {
            echo "Geen gebruikers gevonden.";
        }
        $conn->close();
        ?>
    </ul>
</div>

<a class="verzoek" href="verzoeklijst.php">verzoeken</a>
<?php include "../headerNfooter/footer.php"; ?>