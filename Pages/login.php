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
                <button type="submit">Sign up</button>
            </form>
        </div>
        <div class="login">
            <form action="login.php" method="POST" class="login-form">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" class="input-login" required>
                <input type="password" name="password" placeholder="Password" class="input-login" required>
                <button type="submit">Login</button class="button-login">
                <div class="forgot-password">
                <a href="/wachtwoord-vergeten">Wachtwoord vergeten?</a>
            </div>
            </form>
        </div>
    </div>
</body>
<?php include "../headerNfooter/footer.php";?>

