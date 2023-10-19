<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka - Raporty</title>
    <link rel="stylesheet" href="../css/glowny.css">
    <link rel="stylesheet" href="../css/raporty.css">
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

<form method="post" action="./raporty.php" >



    <label>Kreator raportu</label>
    <hr>
    <br>
    <label for=tabela>Wybierz nazwę tabeli:</label>



    <!-- pobranie nazw tabel z bazy danych -->
    <select name="tabela" id="tabela" onchange="this.form.submit()">
        <?php
            require_once "connection.php";
            $conn = laczenie($_SESSION['login'], $_SESSION['haslo']);
            $sql = "SELECT TABLE_CATALOG ,TABLE_SCHEMA ,TABLE_NAME ,TABLE_TYPE FROM INFORMATION_SCHEMA.TABLES";

            $stmt = sqlsrv_query( $conn, $sql);
            if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
            }
            
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                if($row["TABLE_NAME"] != "sysdiagrams" and $row["TABLE_NAME"] != "wydawcy_adres_info" and $row["TABLE_NAME"] != "autorzy_info"){
                    if($_POST["tabela"] == $row["TABLE_NAME"]){
                        //zapobiega wracaniu selecta do defaultowego ustawienia gdzie zaznaczony jest wybor z tabelką pracownicy
                    echo '<option '.' value="'.$row["TABLE_NAME"].'"'." selected".'>'.$row["TABLE_NAME"]."</option>";
                    }else{
                        echo '<option '.' value="'.$row["TABLE_NAME"].'">'.$row["TABLE_NAME"]."</option>";
                    }
                }
            }
            sqlsrv_free_stmt( $stmt);
            echo "</select>";
            echo "<br>";
            


            
            // pobranie z bazy danych nazw kolumnych z wybranej tabeli
            if(isset($_POST["tabela"]) and !empty($_POST["tabela"])){
                echo '<label style="margin: 0 auto;display:block">Wybierz kolumny</label>';
                echo '<div class="checkboxy">';
                $sql2 = 'select column_name from information_schema.columns where table_name = '."'".$_POST["tabela"]."'";
                
                $stmt2 = sqlsrv_query( $conn, $sql2);
                if( $stmt2 === false ) {
                    die( print_r( sqlsrv_errors(), true));
                }
                $a=0;
                while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                    echo "<span>";
                    echo '<label for="'.$row2["column_name"].'">'.$row2["column_name"]."</label>";
                    //wyłaczenie opcji odznaczenia pierwszego checkboxa (jest potrzebny do sortowania i liczenia)
                    if($a==0){
                    echo '<input name="kolumny[]" type="checkbox" value="'.$row2["column_name"].'" id="'.$row2["column_name"].'" checked onclick="return false;" onkeydown="return false;">';
                    }else{
                        echo '<input name="kolumny[]" type="checkbox" value="'.$row2["column_name"].'" id="'.$row2["column_name"].'">';
                    }
                    $a++;
                    echo "</span>";
                }
                sqlsrv_free_stmt( $stmt2);
                $nazwa_tabeli = $_POST["tabela"];
            }
            echo "</div>";
        ?>



    <!-- spisanie wiersza z nagłówkami tabeli -->
    <?php
    if(isset($_POST["tabela"]) and !empty($_POST["tabela"])){
        echo '<label >Wybierz rekordy </label>';
        echo '<br>';
        echo '<span>';
        echo '<label for="poczatek">OD: </label>';
        echo '<input type="number" name="poczatek" id="poczatek">';
        echo '<label for="koniec">DO: </label>';
        echo '<input type="number" name="koniec" id="poczatek">';
        echo '</span>';
        echo '<input type="submit" value="Stwórz Raport" >';
    }
    
    //w wypadku nie wpisania zakresu jest ustalany automatycznie
    if(isset($_POST["poczatek"]) and isset($_POST["koniec"]) and !empty($_POST["poczatek"]) and !empty($_POST["koniec"])){
        $poczatek = $_POST['poczatek'];
        $koniec = $_POST['koniec'];
        }else{
            $poczatek = 1;
            $koniec = 10;
        }



        echo "<table>";
        if(isset($_POST["kolumny"])){
            $kolumny = $_POST["kolumny"]; //wartości checkboxów są zapisywane w tablicy
            $argumenty_zapytania = "";
            $i=0;

        //pętla spisująca nazwy kolumn z zapisanych checkboxów
        echo "<tr>";
        $k = 0;
        foreach($kolumny as $nazwa_kolumny){
            //sprawdza pozycje tabeli z datą
            if (strpos($nazwa_kolumny, 'data') === 0 or strpos($nazwa_kolumny, 'faktyczna_data') === 0){
                $pozycja_daty = $k;
                $k++;
                // $nazwa_kolumny_z_data = $nazwa_kolumny;
            }else{
                $k++;
            }
            //łączy argumenty jeden napis, póżniej wklejany do zapytania
            if($i==0){
            echo "<td>".$nazwa_kolumny."</td>";
            $argumenty_zapytania = $argumenty_zapytania." ".$nazwa_kolumny." ";
            $kolumna_id = $nazwa_kolumny;
            }else{
                $argumenty_zapytania = $argumenty_zapytania." , ".$nazwa_kolumny." ";
                echo "<td>".$nazwa_kolumny."</td>";
            }
            $i++;}
        echo "</tr>";



        //generowanie raportu
            $sql = "SELECT".$argumenty_zapytania."FROM "." $_POST[tabela] "." where ".$kolumna_id." between ".$poczatek." and ".$koniec." ORDER BY ".$kolumna_id." ASC ;";
            // echo $sql;
            $stmt = sqlsrv_query( $conn, $sql);
            // if( $stmt === false ) {
            //     die( print_r( sqlsrv_errors(), true));
            // }
            if( !empty($stmt)){
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                echo "<tr>";
                $y=0;
                foreach($row as $wiersz){
                    if( !empty($pozycja_daty)){
                        if($y==$pozycja_daty and !empty($wiersz)){
                            $data = $wiersz->format('Y-m-d');
                            echo "<td>".$data."</td>";
                        }else{
                            echo "<td>".$wiersz."</td>";
                        }
                        if($y!=$k){
                            $y++;
                        }else{
                            $y=0;
                        }
                    }else{
                        echo "<td>".$wiersz."</td>";
                    }
                }
                echo "</tr>";
            }
            sqlsrv_free_stmt( $stmt);
            echo "</table>";
        }
    // Zamknięcie połączenie
    sqlsrv_close( $conn );
}
    ?>


</form>
</body>
</html>