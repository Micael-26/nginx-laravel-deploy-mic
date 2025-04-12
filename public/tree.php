<?php
// file: tree.php
$basePath = __DIR__;
$laravelDirs = [
    'app',
    'bootstrap',
    'config',
    'database',
    'public',
    'resources',
    'routes',
    'storage',
    'vendor',
];

function listDirectory(string $path, int $depth = 0) {
    if (!file_exists($path)) {
        return "<div style='color: red'>❌ Dossier introuvable : $path</div>";
    }

    $html = "<div style='margin-left: " . ($depth * 20) . "px'>";
    $items = scandir($path);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $fullPath = $path . '/' . $item;
        $isDir = is_dir($fullPath);
        
        $icon = $isDir ? '📁' : '📄';
        $style = $isDir ? "color: blue; font-weight: bold;" : "";
        
        $html .= "<div style='$style'>$icon $item";
        
        if ($isDir) {
            $html .= listDirectory($fullPath, $depth + 1);
        }
        
        $html .= "</div>";
    }
    
    $html .= "</div>";
    return $html;
}

echo "<!DOCTYPE html>
<html>
<head>
    <title>Arborescence Laravel - Render</title>
    <style>
        body { font-family: 'Courier New', monospace; margin: 20px; }
        h1 { color: #333; }
        .info { background: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>🌳 Arborescence du projet Laravel sur Render</h1>
    
    <div class='info'>
        <strong>Chemin racine :</strong> $basePath<br>
        <strong>PHP Version :</strong> " . phpversion() . "<br>
        <strong>Serveur :</strong> " . $_SERVER['SERVER_SOFTWARE'] . "
    </div>";

echo "<h2>🗂 Structure Laravel essentielle :</h2>";
foreach ($laravelDirs as $dir) {
    $path = $basePath . '/' . $dir;
    if (file_exists($path)) {
        echo "<div style='color: green'>✅ $dir</div>";
        if (in_array($dir, ['storage', 'bootstrap/cache'])) {
            $writable = is_writable($path);
            echo "<div style='margin-left: 20px; color: " . ($writable ? 'green' : 'red') . "'>";
            echo $writable ? "✔ Écriture autorisée" : "❌ Problème de permissions";
            echo "</div>";
        }
    } else {
        echo "<div style='color: red'>❌ $dir (manquant)</div>";
    }
}

echo "<h2>📂 Arborescence complète :</h2>";
echo listDirectory($basePath);

echo "</body></html>";
