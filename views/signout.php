<?php
session_start();
$language = $_SESSION['language'] ?? null;

session_unset();
session_destroy();

session_start();
$_SESSION['language'] = $language;


header("Location: ./signin.php");
exit();
