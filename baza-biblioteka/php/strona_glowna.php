<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka - Strona Główna</title>
    <link rel="stylesheet" href="../css/glowny.css">
    <link rel="stylesheet" href="../css/strona_glowna.css">
    <link rel="stylesheet" href="../css/elementy_stron_css/top-nav.css">
    <link rel="stylesheet" href="../css/elementy_stron_css/tabela_na_dane.css">
    <link rel="icon" type="image/x-icon" href="../images/logo.ico">
    <script src="../js/top_nav.js" defer></script>
</head>
<body>

<?php
// Pobranie zawartości pliku z menu dla bazy
require_once "./elementy_stron/top-nav.php";
?>

<div class="content">
        <span>
            <h1>Lista książek w bazie</h1>
            <form method="post">
                <label for="poczatek">Rekordy od: </label>
                <input type="number" name="poczatek" id="poczatek" min="1" placeholder="1">
                <label for="koniec"> do: </label>
                <input type="number" name="koniec" id="koniec" min="1" placeholder="10">
                <input type="submit" value="OK">
            </form>
        </span>
        <table>
            <tr>
                <td>ID</td>
                <td>TYTUŁ</td>
                <td>LICZBA STRON</td>
                <td>DATA WYDANIA</td>
                <td>Wydawca</td>
            </tr>
        
        <?php
        if(isset($_POST["poczatek"]) and isset($_POST["koniec"]) and $_POST["poczatek"] != 0 and $_POST["koniec"] != 0){
            $poczatek = $_POST["poczatek"];
            $koniec = $_POST["koniec"];
            if($poczatek > $koniec){
                $pomocnicza = $koniec;
                $koniec = $poczatek;
                $poczatek = $pomocnicza;
            }
        }else{
            $poczatek = 1;
            $koniec = 10;
        }
        require_once "connection.php";
            $conn = laczenie($_SESSION['login'], $_SESSION['haslo']);
            $sql = "SELECT id_ksiazki, tytul, liczba_stron, data_wydania, nazwa FROM ksiazki as k JOIN wydawcy as w on k.id_wydawcy = w.id_wydawcy Where id_ksiazki between ".$poczatek." and ".$koniec."ORDER BY id_ksiazki ASC ;";

            $stmt = sqlsrv_query( $conn, $sql);
            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                echo "<tr>";
                echo "<td>".$row['id_ksiazki']."</td>";
                echo "<td>".$row['tytul']."</td>";
                echo "<td>".$row['liczba_stron']."</td>";
                $data = $row['data_wydania']->format('Y-m-d');
                echo "<td>".$data."</td>";
                echo "<td>".$row['nazwa']."</td>";
                echo "</tr>";
            }

            sqlsrv_free_stmt( $stmt);
            echo "</table>";

            $sql2 = "select count(*) as liczba_rekordow from ksiazki;";

            $stmt2 = sqlsrv_query( $conn, $sql2);
            while($row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC)){
            echo '<span class="rekordy_info">'."Rekordy od ".$poczatek." do ".$koniec. " z liczby ".$row2["liczba_rekordow"]." znajdujących się w bazie"."</span>";
            }
            sqlsrv_free_stmt( $stmt2);


            // Zamknięcie połączenie
            sqlsrv_close( $conn );
        ?>
        
    </div>
</body>
</html>