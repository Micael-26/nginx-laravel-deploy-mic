<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | Portfolio Développeur</title>
    <meta name="description" content="Portfolio professionnel de [Votre Nom], développeur full-stack spécialisé en [vos technologies]">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(45deg, #3b82f6, #8b5cf6);
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false, activeSection: 'accueil' }" class="bg-gray-50 font-sans antialiased">
    <!-- Barre de navigation -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#accueil" class="text-xl font-bold gradient-text">Micael DINY</a>
                </div>
                
                <!-- Menu desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a @click="activeSection = 'accueil'" href="#accueil" :class="{'text-indigo-600': activeSection === 'accueil'}" class="hover:text-indigo-500 transition">Accueil</a>
                    <a @click="activeSection = 'projets'" href="#projets" :class="{'text-indigo-600': activeSection === 'projets'}" class="hover:text-indigo-500 transition">Projets</a>
                    <a @click="activeSection = 'competences'" href="#competences" :class="{'text-indigo-600': activeSection === 'competences'}" class="hover:text-indigo-500 transition">Compétences</a>
                    <a @click="activeSection = 'contact'" href="#contact" :class="{'text-indigo-600': activeSection === 'contact'}" class="hover:text-indigo-500 transition">Contact</a>
                </div>
                
                <!-- Bouton mobile -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-indigo-500">
                        <i x-show="!mobileMenuOpen" class="fas fa-bars text-xl"></i>
                        <i x-show="mobileMenuOpen" class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a @click="mobileMenuOpen = false; activeSection = 'accueil'" href="#accueil" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Accueil</a>
                <a @click="mobileMenuOpen = false; activeSection = 'projets'" href="#projets" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Projets</a>
                <a @click="mobileMenuOpen = false; activeSection = 'competences'" href="#competences" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Compétences</a>
                <a @click="mobileMenuOpen = false; activeSection = 'contact'" href="#contact" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Sections du portfolio -->
    <main>
        <!-- Hero Section -->
        <section id="accueil" class="min-h-screen pt-24 pb-16 px-4 sm:px-6 lg:px-8 flex items-center">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Bonjour, je suis <span class="gradient-text">Micael DINY</span>
                    </h1>
                    <h2 class="text-2xl md:text-3xl text-gray-600">
                        <span class="inline-block mr-2"> </span> Développeur Full-Stack
                    </h2>
                    <p class="text-lg text-gray-500">
                        Je crée des applications web modernes et performantes avec Laravel, Vue.js et Tailwind CSS.
                    </p>
                    <div class="flex space-x-4 pt-4">
                        <a href="#contact" class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-lg hover:shadow-xl transition">
                            Me contacter
                        </a>
                        <a href="#projets" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-indigo-500 hover:text-indigo-600 transition">
                            Voir mes projets
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-2xl -rotate-6"></div>
                    <div class="relative bg-white p-2 rounded-2xl shadow-xl rotate-1 hover-scale">
                        <img src="https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Projet exemple" 
                             class="rounded-xl w-full h-auto">
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Projets -->
        <section id="projets" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-100">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mes Projets Récents</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Projet 1 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale transition">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Projet 1" 
                             class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800">Application SaaS</h3>
                            <p class="text-gray-600 mt-2">Plateforme de gestion complète avec Laravel et Vue.js</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">Laravel</span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">Vue.js</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Tailwind</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Projet 2 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale transition">
                        <img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" 
                             alt="Projet 2" 
                             class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800">Site E-commerce</h3>
                            <p class="text-gray-600 mt-2">Boutique en ligne avec paiements sécurisés</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">WordPress</span>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">WooCommerce</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Projet 3 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale transition">
                        <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1528&q=80" 
                             alt="Projet 3" 
                             class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800">Application Mobile</h3>
                            <p class="text-gray-600 mt-2">Application de suivi de fitness multiplateforme</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">React Native</span>
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Firebase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Compétences -->
        <section id="competences" class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mes Compétences</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Compétence 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-md text-center hover-scale transition">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-laravel text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Laravel</h3>
                        <p class="text-gray-600">Framework PHP backend</p>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Compétence 2 -->
                    <div class="bg-white p-6 rounded-xl shadow-md text-center hover-scale transition">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-vuejs text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Vue.js</h3>
                        <p class="text-gray-600">Framework JavaScript frontend</p>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Compétence 3 -->
                    <div class="bg-white p-6 rounded-xl shadow-md text-center hover-scale transition">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-html5 text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">HTML/CSS</h3>
                        <p class="text-gray-600">Développement frontend</p>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-600 h-2.5 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Compétence 4 -->
                    <div class="bg-white p-6 rounded-xl shadow-md text-center hover-scale transition">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-database text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Bases de données</h3>
                        <p class="text-gray-600">MySQL, PostgreSQL, MongoDB</p>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Contact -->
        <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-100">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Contactez-moi</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations de contact</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i class="fas fa-envelope text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                    <p class="text-base text-gray-900">dinymicael998@gmail.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i class="fas fa-phone-alt text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-500">Téléphone</h4>
                                    <p class="text-base text-gray-900">+33 6 12 34 56 78</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                    <i class="fas fa-map-marker-alt text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-500">Localisation</h4>
                                    <p class="text-base text-gray-900">Paris, France</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Réseaux sociaux</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-indigo-100 transition">
                                    <i class="fab fa-linkedin-in text-gray-700"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-indigo-100 transition">
                                    <i class="fab fa-github text-gray-700"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-indigo-100 transition">
                                    <i class="fab fa-twitter text-gray-700"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-indigo-100 transition">
                                    <i class="fab fa-instagram text-gray-700"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <form class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                                <input type="text" id="subject" name="subject" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea id="message" name="message" rows="4" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition">
                                    Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Micael DINY</h3>
                    <p class="text-gray-400">Développeur Full-Stack passionné par la création d'applications web modernes et performantes.</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#accueil" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                        <li><a href="#projets" class="text-gray-400 hover:text-white transition">Projets</a></li>
                        <li><a href="#competences" class="text-gray-400 hover:text-white transition">Compétences</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">Abonnez-vous pour recevoir mes dernières actualités.</p>
                    <form class="flex">
                        <input type="email" placeholder="Votre email" class="px-4 py-2 w-full rounded-l-lg focus:outline-none text-gray-900">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-r-lg transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Micael DINY. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Suivi de la section active pour le menu
        document.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            let currentSection = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 300)) {
                    currentSection = section.getAttribute('id');
                }
            });
            
            Alpine.store('activeSection', currentSection);
        });
    </script>
</body>
</html>
