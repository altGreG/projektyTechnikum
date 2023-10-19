<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka</title>
    <link rel="stylesheet" href="../../css/glowny.css">
    <link rel="stylesheet" href="../../css/elementy_stron_css/top-nav.css">
    <link rel="icon" type="image/x-icon" href="../../images/logo.ico">
    <script src="../../js/strona_glowna.js" defer></script>
</head>
<body> -->

<!-- pamiętaj o dostosowanoiu tego co powyżej!!! -->

<div class="menu">
    <!-- inicjalizacja sesji / sprawdzenie czy użytkownik jest zalogowany-->
        <?php
            session_start();
                if(!isset($_SESSION['login'])){
                    header('Location: ./logowanie.php');
                }
        ?>
    <!-- inicjalizacja sesji -->
    <!-- menu -->
        <div class="top">
            <span>
                <h1>Baza - Biblioteka</h1>
                <?php
                    echo "<span>"."Użytkujący bazę: "."</span>"."<span>".$_SESSION['login']."</span>";
                ?>
            </span>
            <span>
                <a href="wylogowywanie.php">Wyloguj</a>
            </span>
        </div>
        <hr>
            <span class="nav-btn">Menu</span>
            <ul class="nav">
                <li><a href="./strona_glowna.php">Strona główna</a></li>
                <li></li>
                <li><a href="./raporty.php">Raporty</a></li>
                <li></li>
                <li>Formularze</li>
                <li></li>
                <li>Kwerendy</li>
                <li></li>
                <li>Inne</li>
                <li></li>
                <li>--------</li>
                <li></li>
                <li>--------</li>
                <li></li>
                <li>--------</li>
            </ul>
    <!-- menu -->
</div>