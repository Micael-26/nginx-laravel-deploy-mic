<?php

// Détermine si on exécute depuis /public ou depuis la racine
$currentDir = __DIR__;
$isInPublic = basename($currentDir) === 'public';

// Préfixe à appliquer selon le répertoire
$prefix = $isInPublic ? '../' : '';

// Fonction pour vérifier un fichier existant via motif (glob)
function checkPatternFile(string $pathPattern): bool {
    return count(glob($pathPattern)) > 0;
}

// Liste des fichiers à vérifier
$checks = [
    $prefix . 'public/build/manifest.json'         => file_exists($currentDir . '/' . $prefix . 'public/build/manifest.json'),
    $prefix . 'public/build/assets/app-*.css'      => checkPatternFile($currentDir . '/' . $prefix . 'public/build/assets/app-*.css'),
    $prefix . 'public/build/assets/app-*.js'       => checkPatternFile($currentDir . '/' . $prefix . 'public/build/assets/app-*.js'),
    $prefix . 'resources/css/app.css'              => file_exists($currentDir . '/' . $prefix . 'resources/css/app.css'),
    $prefix . 'resources/js/app.js'                => file_exists($currentDir . '/' . $prefix . 'resources/js/app.js'),
    $prefix . 'vendor/autoload.php'                => file_exists($currentDir . '/' . $prefix . 'vendor/autoload.php'),
];

// Affichage HTML
echo "<!DOCTYPE html><html lang='fr'><head><meta charset='UTF-8'><title>Vérification Déploiement</title></head><body style='font-family: monospace; background: #f9f9f9; padding: 20px;'>";
echo "<h2>🛠️ Vérification des fichiers essentiels après déploiement</h2>";
echo "<p><strong>Répertoire courant :</strong> $currentDir</p>";
echo "<ul style='line-height: 1.8;'>";

foreach ($checks as $file => $exists) {
    $color = $exists ? 'green' : 'red';
    $icon = $exists ? '✅' : '❌';
    echo "<li style='color: $color;'>$icon $file " . ($exists ? 'trouvé' : 'manquant') . "</li>";
}

echo "</ul></body></html>";
