<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Moderne avec Tailwind CSS et Alpine.js</title>

    <!-- CDN pour Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- CDN pour Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Section principale -->
    <div class="min-h-screen flex justify-center items-center p-4">
        <div class="max-w-sm w-full bg-white rounded-lg shadow-lg overflow-hidden">
            
            <!-- Image du profil -->
            <div class="relative">
                <img class="w-full h-56 object-cover" src="https://via.placeholder.com/400x400" alt="Profil">
                <div class="absolute inset-0 bg-black opacity-50 flex justify-center items-center">
                    <button 
                        x-data="{ open: false }"
                        x-on:click="open = !open"
                        x-bind:class="{ 'bg-green-500': open, 'bg-blue-500': !open }"
                        class="px-4 py-2 text-white rounded-full transition-colors duration-300"
                    >
                        <span x-show="!open">Suivre</span>
                        <span x-show="open">Abonné</span>
                    </button>
                </div>
            </div>

            <!-- Informations du profil -->
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Jean Dupont</h2>
                <p class="text-gray-600 mt-2">Développeur Full Stack | Passionné par les technologies modernes et l'open-source.</p>

                <!-- Compte social -->
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="#" class="text-blue-600 hover:text-blue-800">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-6">
                    <button class="w-full bg-gray-800 text-white py-2 rounded-md hover:bg-gray-700 transition-colors">
                        Contacter
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- CDN FontAwesome pour les icônes sociales -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
