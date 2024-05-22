<?php include "../headerNfooter/header.php";?>

<body class="login_body">
    <div class="main_login">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
            <form action="login.php" method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="username" placeholder="User name" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <select name="secret_question" required>
                    <option value="" disabled selected>Select a secret question</option>
                    <option value="pet">What is the name of your first pet?</option>
                    <option value="school">What is the name of your primary school?</option>
                    <option value="birthplace">In what city were you born?</option>
                </select>
                <input type="text" name="secret_answer" placeholder="Answer to secret question" required>
                <button type="submit">Sign up</button>
            </form>
        </div>
        <div class="login">
            <form action="login.php" method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
</div>
</div>
</body>

<?php
// Start the session


// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "pixelplayground");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $secret_question = $_POST['secret_question'];
    $secret_answer = $_POST['secret_answer'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password and secret answer
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    $secret_answer_hashed = password_hash($secret_answer, PASSWORD_BCRYPT
);

// Prepare the SQL query using prepared statements
$stmt = $conn->prepare("INSERT INTO gebruikers (gebruikersnaam, wachtwoord, secret_question, secret_answer) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password_hashed, $secret_question, $secret_answer_hashed);

// Execute the query
if ($stmt->execute()) {
    // Redirect to the login page after successful registration
    header("Location: login.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();
}

// Close the connection
$conn->close();
?>

<?php
// Start the session
session_start();

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "pixelplayground");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("SELECT id, gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $hashed_password = $row['wachtwoord'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $row['gebruikersnaam'];
            header("Location: profile.php");
            echo "test";
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
print_r($_SESSION);
?>

<?php include "../headerNfooter/footer.php";?>