<?php

echo "<h1>Debug Laravel Docker</h1>";

// Vérifier le chemin courant
echo "<p><strong>Chemin actuel :</strong> " . getcwd() . "</p>";

// Vérifier les fichiers dans public/
echo "<h2>Fichiers dans public/ :</h2>";
$files = scandir(__DIR__);
echo "<ul>";
foreach ($files as $file) {
    echo "<li>$file</li>";
}
echo "</ul>";

// Vérifier si vite assets sont présents
echo "<h2>Vérification de quelques fichiers frontend :</h2>";
$expected = [
    'build/manifest.json',
    'build/assets/app.css',
    'build/assets/app.js',
    'css/app.css',
    'js/app.js',
];
foreach ($expected as $file) {
    echo "<p>" . $file . ': ' . (file_exists(__DIR__ . '/' . $file) ? '✅ Présent' : '❌ Manquant') . "</p>";
}

// Vérifier les permissions sur storage
$storagePath = __DIR__ . '/../storage';
echo "<h2>Permissions storage/ :</h2>";
echo "<p>" . $storagePath . ": " . (is_writable($storagePath) ? '✅ Writable' : '❌ Non-writable') . "</p>";

// Vérifier version PHP
echo "<h2>Version PHP :</h2>";
echo "<p>" . phpversion() . "</p>";

// Vérifier les extensions PHP
echo "<h2>Extensions PHP chargées :</h2>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>";
