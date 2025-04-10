<?php
header('Content-Type: text/plain');
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "=== DEBUG LARAVEL ===\n\n";

// 1. Vérifie la version PHP
echo "PHP Version: " . phpversion() . "\n\n";

// 2. Vérifie les extensions PHP requises
$requiredExt = ['pdo_mysql', 'mbstring', 'openssl', 'gd', 'zip'];
echo "Extensions PHP chargées:\n";
foreach (get_loaded_extensions() as $ext) {
    echo "- $ext\n";
}
echo "\nExtensions manquantes:\n";
foreach ($requiredExt as $ext) {
    if (!extension_loaded($ext)) {
        echo "- $ext (MANQUANT)\n";
    }
}
echo "\n";

// 3. Vérifie les permissions des dossiers
$dirsToCheck = [
    '/var/www/storage' => 'Laravel Storage',
    '/var/www/bootstrap/cache' => 'Bootstrap Cache',
    '/var/www/public' => 'Public Folder'
];
foreach ($dirsToCheck as $dir => $label) {
    $writable = is_writable($dir);
    $perms = substr(sprintf('%o', fileperms($dir)), -4);
    echo "$label:\n";
    echo "- Chemin: $dir\n";
    echo "- Permissions: $perms\n";
    echo "- Writable: " . ($writable ? 'OUI' : 'NON') . "\n\n";
}

// 4. Teste la connexion à la base de données (si .env existe)
if (file_exists('/var/www/.env')) {
    echo "=== TEST DATABASE ===\n";
    try {
        $db = new PDO(
            'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
            env('DB_USERNAME'),
            env('DB_PASSWORD')
        );
        echo "Connexion DB: SUCCÈS\n";
    } catch (PDOException $e) {
        echo "Erreur DB: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 5. Teste l'exécution de Laravel
echo "=== TEST LARAVEL ===\n";
try {
    require '/var/www/vendor/autoload.php';
    $app = require_once '/var/www/bootstrap/app.php';
    echo "Laravel Bootstrap: SUCCÈS\n";
} catch (Throwable $e) {
    echo "Erreur Laravel: " . $e->getMessage() . "\n";
}

// 6. Affiche les dernières erreurs de Laravel
$logPath = '/var/www/storage/logs/laravel.log';
if (file_exists($logPath)) {
    echo "\n=== DERNIÈRES ERREURS (laravel.log) ===\n";
    echo file_get_contents($logPath);
}
