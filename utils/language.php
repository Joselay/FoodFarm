<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the current script is 'profile.php'
$currentScript = dirname($_SERVER['PHP_SELF']);
if (str_contains($currentScript, 'views')) {
    require_once "../enums/Language.php"; // Use this path if in the profile
} else {
    require_once "./enums/Language.php"; // Default path for other scripts
}

// Get the current language from the session or default to English
$language = $_SESSION['language'] ?? Language::English->value;

// Load the corresponding language file
$languageFile = "./i18n/{$language}.php";
if (file_exists($languageFile)) {
    require_once $languageFile;
} else {
    require_once "../i18n/en-US.php"; // Fallback to English if file doesn't exist
}

$fontFamily = ($language === Language::Khmer->value) ? "'Kantumruy Pro', sans-serif" : "'Inter', sans-serif";
