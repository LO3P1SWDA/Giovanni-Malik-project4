<?php include "../headerNfooter/header.php";?>

<h2>Wachtwoord Veranderen</h2><br>
<form class="WachtwoordSwitch" method="POST">
    <label for="old_password">Oud Wachtwoord:</label>
    <input type="password" id="old_password" name="old_password" required><br>

    <label for="new_password">Nieuw Wachtwoord:</label>
    <input type="password" id="new_password" name="new_password" required><br>

    <label for="confirm_new_password">Bevestig Nieuw Wachtwoord:</label>
    <input type="password" id="confirm_new_password" name="confirm_new_password" required><br>
    <button type="submit">Wachtwoord Veranderen</button>
</form>

<?php
$conn = new mysqli("localhost", "root", "", "pixelplayground");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? 1; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_SESSION['user_id']; 
    $old = $_POST['old_password'];
    $sql = "SELECT `wachtwoord` FROM `gebruikers` WHERE `id` = '$user_id'";
    $result = $conn->query($sql);
    while($row = $result->fetch_object()){
        $verify = password_verify($old, $row->wachtwoord);
        if($verify){
            echo "password ok";
            $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $sql = "UPDATE `gebruikers` SET `wachtwoord` = '$new' WHERE `gebruikers`.`id` = '$user_id'";
            $conn->query($sql);
            echo $sql;
        }else{
            echo "password not the same";
        }
    }

   
}


$conn->close();
?>

<?php include "../headerNfooter/footer.php";?>