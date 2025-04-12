<?php

$checks = [
    'build/manifest.json',
    'build/assets/app.css',
    'build/assets/app.js',
    '../resources/css/app.css',
    '../resources/js/app.js',
    '../vendor/autoload.php',
];

echo "<h2>🛠️ Vérification des fichiers essentiels après déploiement</h2>";
echo "<ul style='font-family: monospace;'>";

foreach ($checks as $file) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        echo "<li style='color: green;'>✅ $file trouvé</li>";
    } else {
        echo "<li style='color: red;'>❌ $file manquant</li>";
    }
}

echo "</ul>";
