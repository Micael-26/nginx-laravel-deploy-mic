<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-indigo-600">MonApp</h1>
            <nav class="space-x-4">
                <a href="#" class="text-gray-700 hover:text-indigo-500 transition">Accueil</a>
                <a href="#" class="text-gray-700 hover:text-indigo-500 transition">Services</a>
                <a href="#" class="text-gray-700 hover:text-indigo-500 transition">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-indigo-600 text-white py-20">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-4">Bienvenue sur notre plateforme</h2>
            <p class="text-lg mb-6">Nous offrons des solutions dynamiques et modernes pour vos besoins numériques.</p>
            <a href="#services" class="bg-white text-indigo-600 font-semibold py-2 px-6 rounded-lg hover:bg-gray-100 transition">En savoir plus</a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-3xl font-semibold text-center mb-12">Nos Services</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-bold mb-2 text-indigo-600">Développement Web</h4>
                    <p class="text-gray-600">Sites modernes, performants et responsives.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-bold mb-2 text-indigo-600">Applications Temps Réel</h4>
                    <p class="text-gray-600">Utilisation de WebSockets et de Laravel Echo.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h4 class="text-xl font-bold mb-2 text-indigo-600">SEO & Performance</h4>
                    <p class="text-gray-600">Optimisation pour les moteurs de recherche et les performances.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-6 border-t mt-16">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <p class="text-gray-600">&copy; {{ date('Y') }} MonApp. Tous droits réservés.</p>
            <div class="space-x-4">
                <a href="#" class="text-indigo-500 hover:text-indigo-700 transition">Twitter</a>
                <a href="#" class="text-indigo-500 hover:text-indigo-700 transition">GitHub</a>
            </div>
        </div>
    </footer>

</body>
</html>
