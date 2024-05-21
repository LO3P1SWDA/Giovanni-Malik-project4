
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Deze website is voor de periode 4 project">
    <meta name="author" content="Malik Omri & Giovanni Krapels">
    <meta name="keywords" content="project 4, opdracht, Mbo, Rijnland, Leiden">
    <title>Project</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/home.js" defer></script>
</head>

<body>
    <header>
        <img class="logo" src="https://static.wixstatic.com/media/72c1e2_3044305cde3e46d19101e9905d33a180~mv2.png/v1/fill/w_370,h_230,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/Pixel%20Playground%20_Logo%20full%20colors%20%2B%20elements%20NO%20R.png" alt="logo">
        <nav>
            <a href="pages/login.php">Login</a>
            <a href="#">Profiel</a>
            <a href="#">Games</a>
        </nav>
    </header>
<main>
        <h1>Welkom op onze game website!</h1><br>
        <p>Hier vind je een verzameling van leuke en uitdagende games om te spelen. Onze website is ontworpen om jou de ultieme gamingervaring te bieden, met een gebruiksvriendelijke interface en een breed scala aan spellen om uit te kiezen.</p>
        <div class="slideshow">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/Tic_tac_toe.svg/1200px-Tic_tac_toe.svg.png" alt="Game 1" onclick="openGamePage('game1.html')">
                <img src="https://cdn.iconscout.com/icon/free/png-256/free-hang-1551091-1315157.png" alt="Game 2" onclick="openGamePage('game2.html')">
                <img src="https://kmtools.com/cdn/shop/products/Connect4CoverPic.png?v=1666200673&width=3333" alt="Game 3" onclick="openGamePage('game3.html')">
                <img src="https://1000logos.net/wp-content/uploads/2023/05/Wordle-Emblem.png" alt="Game 4" onclick="openGamePage('game4.html')">
        </div>
</main>

<footer>
    <p class="pixel"><a href="index.php"><strong>Pixel Playground</strong></a></p>
    <p class="copyright">&copy; 2024 Malik Omri & Giovanni Krapels. Alle rechten voorbehouden.</p>
    <section class="socials">
        <a href="https://www.facebook.com/jouwfacebookpagina">Facebook</a>
        <a href="https://www.twitter.com/jouwtwitterpagina">Twitter</a>
        <a href="https://www.instagram.com/jouwinstagrampagina">Instagram</a>
    </section>
</footer>

</body>

</html>