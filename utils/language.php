<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentScript = dirname($_SERVER['PHP_SELF']);
if (str_contains($currentScript, 'views')) {
    require_once "../enums/Language.php";
} else {
    require_once "./enums/Language.php";
}

$language = $_SESSION['language'] ?? Language::English->value;

$languageFile = "./i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
} else {
    require_once "../i18n/en-US.php";
}

$fontFamily = ($language === Language::Khmer->value) ? "'Kantumruy Pro', sans-serif" : "'Inter', sans-serif";
