<?php include "../headerNfooter/header.php";?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>
<div class="games-overview">
    <div class="game-card">
        <img src="https://play-lh.googleusercontent.com/5ENdgpFsRhQt9y_ySp9UK_p-CL0TmhSwW5pKmmzzIW0OLFR3EvAtzAGm6c_IkkfgVg" alt="Tic Tac Toe">
        <h2>Boter kaas en eieren</h2>
        <p>Een klassiek spel waarbij twee spelers om beurten X en O op een 3x3 bord plaatsen. De eerste met drie op een rij wint.</p>
        <a href="tictactoe.html">Speel nu</a>
    </div>
    <div class="game-card">
        <img src="https://store-images.s-microsoft.com/image/apps.41929.13910108538401625.dfad4587-dfb3-4aa4-8bed-b5d2dd8fc79f.54781100-f7e4-4c22-89bf-257118f9ac23?mode=scale&q=90&h=1080&w=1920" alt="Vier op een rij">
        <h2>Vier op een rij</h2>
        <p>Probeer vier van jouw schijven op een rij te krijgen in dit strategische spel.</p>
        <a href="4-op-een-rij.php">Speel nu</a>
    </div>
    <div class="game-card">
        <img src="https://images.thimbletoys.com/images/items/2142035a.jpg" alt="memory">
        <h2>Memory</h2>
        <p>Probeer de juiste plaatjes bij elkaar te groeperen.</p>
        <a href="memory.php">Speel nu</a>
    </div>
    <div class="game-card">
        <img src="https://store-images.s-microsoft.com/image/apps.31378.14440169033196048.33ec04e1-f2d4-46ed-a05b-03b332738f93.8032cfe7-683a-4be1-8b4c-9da7dc14c2b3?h=1280" alt="Galgje">
        <h2>Galgje</h2>
        <p>Probeer het woord te raden door letters te kiezen, maar pas op voor de galg!</p>
        <p><strong>Onder constructie</strong></p>
    </div>
    <div class="game-card">
        <img src="https://brandmentions.com/wiki/images/c/cd/Wordle_logo.png" alt="Wordle">
        <h2>Wordle</h2>
        <p>Raad het vijfletterwoord binnen zes pogingen.</p>
        <p><strong>Onder constructie</strong></p>
    </div>
</div>

    <a class="BadgesKnop" href="badges.php">Badges</a>

<?php include "../headerNfooter/footer.php";?>
