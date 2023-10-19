<?php
//funkcja łączenia z bazą danych przyjmująca jako argumenty login i hasło dla użytkownika bazy danych
function laczenie($login, $haslo){
    $serverName = "GREGORYWITA"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"biblioteka", "UID"=>"$login", "PWD"=>"$haslo");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    return $conn; //zwraca połączenie
}

?>