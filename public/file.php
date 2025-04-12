<?php

// Fonction utilitaire pour détecter un fichier avec un motif (ex: app-*.css)
function checkFilePattern(string $pattern): bool {
    return count(glob(__DIR__ . '/' . $pattern)) > 0;
}

$checks = [
    'public/build/manifest.json'         => file_exists(__DIR__ . '/public/build/manifest.json'),
    'public/build/assets/app-*.css'      => checkFilePattern('public/build/assets/app-*.css'),
    'public/build/assets/app-*.js'       => checkFilePattern('public/build/assets/app-*.js'),
    'resources/css/app.css'              => file_exists(__DIR__ . '/resources/css/app.css'),
    'resources/js/app.js'                => file_exists(__DIR__ . '/resources/js/app.js'),
    'vendor/autoload.php'                => file_exists(__DIR__ . '/vendor/autoload.php'),
];

echo "<h2>🛠️ Vérification des fichiers essentiels après déploiement</h2>";
echo "<ul style='font-family: monospace; line-height: 1.6;'>";

foreach ($checks as $file => $exists) {
    $color = $exists ? 'green' : 'red';
    $icon = $exists ? '✅' : '❌';
    echo "<li style='color: $color;'>$icon $file " . ($exists ? 'trouvé' : 'manquant') . "</li>";
}

echo "</ul>";
