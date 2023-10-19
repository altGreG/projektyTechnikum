<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka - Logowanie</title>
    <link rel="stylesheet" href="../css/logowanie.css">
    <link rel="stylesheet" href="../css/glowny.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.ico">
</head>
<body>
<script src="../js/logowanie.js" defer></script>
    <?php
       session_start(); // wymagane do działania modułu sesji
    //warunek sprawdzający czy użytkownik jest już zalogowany 
       if(isset($_SESSION['login'])){
            header('Location: ./strona_glowna.php');
        }
    ?>
    <div class="top">
        <h1>Witaj na stronie logowania!</h1>
    </div>
    <hr>
    <form action="./logowanie.php" method="post">
        <label for="login">Podaj login:</label>
        <input type="text" name="login" id="login">
        <label for="haslo">Podaj hasło:</label>
        <input type="password" name="haslo" id="haslo">
        <span><input type="checkbox" onclick="sprawdzenieHasla()">Sprawdź hasło</span>
        <input type="submit" value="Zaloguj">
    </form>


<?php
    //warunek sprawdza czy został uzupełniony form
    if(isset($_POST["login"]) and isset($_POST["haslo"]) and $_POST["login"]!="" and $_POST["haslo"]!=""){
        $login = $_POST["login"];
        $haslo =$_POST["haslo"];
        require_once "./connection.php";
        $conn = laczenie($login, $haslo);
        //warunek sprawdzający czy zostało nawiązane połączenie
        if($conn){
            //w przypadku sukcesu, są tworzone tokeny sesji, które zawierają login i hasło użytkownika baza

            //dzięki nim wiemy czy użytkownik jest zalogowany ale i też na innych stronach niż logowanie.php możemy korzystać z tych danych w celu nawiązania połączenia z bazą
            $_SESSION['login'] = $login;
            $_SESSION['haslo'] = $haslo;
            sqlsrv_close( $conn );
            header('Location: ./strona_glowna.php');
        }else{
            echo "<br><br>";
            echo "<div ".'class="info">'."Połączenie nie mogło zostać nawiązane. Podano złe dane!"."</div>"."<br>";
            //die( print_r(sqlsrv_errors(), true));  <-- wypisanie treści błędu
        }
    }else{
        echo "<br><br>";
        echo "<div ".'class="info">'."Uzupełnij puste pola!"."</div>";
    }

?>

</body>
</html>