<?php

function findAsset($pattern) {
    $files = glob(__DIR__ . '/' . $pattern);
    return !empty($files);
}

$checks = [
    'public/build/manifest.json' => file_exists(__DIR__ . '/public/build/manifest.json'),
    'public/build/assets/app-*.css' => findAsset('public/build/assets/app-*.css'),
    'public/build/assets/app-*.js' => findAsset('public/build/assets/app-*.js'),
    'resources/css/app.css' => file_exists(__DIR__ . '/resources/css/app.css'),
    'resources/js/app.js' => file_exists(__DIR__ . '/resources/js/app.js'),
    'vendor/autoload.php' => file_exists(__DIR__ . '/vendor/autoload.php'),
];

echo "<h2>🛠️ Vérification des fichiers essentiels après déploiement</h2>";
echo "<ul style='font-family: monospace;'>";

foreach ($checks as $file => $exists) {
    if ($exists) {
        echo "<li style='color: green;'>✅ $file trouvé</li>";
    } else {
        echo "<li style='color: red;'>❌ $file manquant</li>";
    }
}

echo "</ul>";
