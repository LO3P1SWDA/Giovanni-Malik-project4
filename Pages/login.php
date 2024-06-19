<?php include "../headerNfooter/header.php";?>
<body class="login_body">
    <div class="main_login">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="login.php" method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="username" placeholder="User name" class="input-field" required>
                <input type="password" name="password" placeholder="Password" class="input-field" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="input-field" required>
                <div class="secret-question">
                    <select name="secret_question" required>
                        <option value="" disabled selected>Select a secret question</option>
                        <option value="pet">What is the name of your first pet?</option>
                        <option value="school">What is the name of your primary school?</option>
                        <option value="birthplace">In what city were you born?</option>
                    </select>
                </div>
                <input type="text" name="secret_answer" placeholder="Answer to secret question" class="input-field" required>
                <button type="submit" name="register">Sign up</button>
            </form>
        </div>
        <div class="login">
            <form action="login.php" method="POST" class="login-form">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" class="input-login" required>
                <input type="password" name="password" placeholder="Password" class="input-login" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>

<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli("localhost", "root", "", "pixelplayground");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['register'])) {
        // Registratie logica
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $secret_question = $_POST['secret_question'];
        $secret_answer = $_POST['secret_answer'];

        if ($password !== $confirm_password) {
            echo "Passwords do not match!";
            exit();
        }
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $secret_answer_hashed = password_hash($secret_answer, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO gebruikers (gebruikersnaam, wachtwoord, secret_question, secret_answer) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password_hashed, $secret_question, $secret_answer_hashed);

        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['login'])) {
        // Inlog logica
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $hashed_password = $row['wachtwoord'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $row['gebruikersnaam'];

                // Sla de gebruikersnaam op in localStorage
                echo "<script>localStorage.setItem('username', '" . $row['gebruikersnaam'] . "');</script>";

                header("Location: profile.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<?php include "../headerNfooter/footer.php";?>
