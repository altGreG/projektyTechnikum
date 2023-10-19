<?php
//wylogowywanie użytkownika polega na zniszczeniu tokenów z informacją na temat loginu i hasła
session_start();
session_destroy();

header('Location: ./logowanie.php');
?>

