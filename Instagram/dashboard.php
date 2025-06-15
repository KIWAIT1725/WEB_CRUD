<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Debes iniciar sesion.'); window.location.href='index.html';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                        'gradient': 'gradient 3s ease infinite',
                        'heart': 'heart 0.3s ease-in-out',
                        'story-ring': 'storyRing 2s linear infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        bounceIn: {
                            '0%': { opacity: '0', transform: 'scale(0.3)' },
                            '50%': { opacity: '1', transform: 'scale(1.05)' },
                            '70%': { transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        heart: {
                            '0%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.3)' },
                            '100%': { transform: 'scale(1)' }
                        },
                        storyRing: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        }
                    },
                    backgroundImage: {
                        'instagram-gradient': 'linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d)',
                        'story-gradient': 'linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)',
                    }
                }
            },
            darkMode: 'class',
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 dark:bg-black transition-colors duration-300">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-900 border-b border-gray-300 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2 animate-bounce-in">
                    <i class="fab fa-instagram text-3xl bg-instagram-gradient bg-clip-text text-transparent"></i>
                    <span class="text-2xl font-bold bg-instagram-gradient bg-clip-text text-transparent font-serif">Instagram</span>
                </div>
                
                <!-- Search Bar -->
                <div class="hidden md:block flex-1 max-w-xs mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Buscar" 
                               class="w-full px-4 py-2 pl-10 bg-gray-100 dark:bg-gray-800 border-0 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Navigation Icons -->
                <div class="flex items-center space-x-6">
                    <button class="hover:scale-110 transition-transform duration-200">
                        <i class="far fa-heart text-2xl text-gray-700 dark:text-gray-300 hover:text-red-500 transition-colors duration-300"></i>
                    </button>
                    <button class="hover:scale-110 transition-transform duration-200">
                        <i class="far fa-paper-plane text-2xl text-gray-700 dark:text-gray-300 hover:text-blue-500 transition-colors duration-300"></i>
                    </button>
                    <button class="hover:scale-110 transition-transform duration-200">
                        <i class="far fa-plus-square text-2xl text-gray-700 dark:text-gray-300 hover:text-green-500 transition-colors duration-300"></i>
                    </button>
                    <button class="hover:scale-110 transition-transform duration-200">
                        <i class="far fa-compass text-2xl text-gray-700 dark:text-gray-300 hover:text-purple-500 transition-colors duration-300"></i>
                    </button>
                    <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 transform hover:scale-110">
                        <i class="fas fa-moon dark:hidden text-gray-700 text-xl"></i>
                        <i class="fas fa-sun hidden dark:block text-yellow-400 text-xl"></i>
                    </button>
                    <div class="relative">
                        <button class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 p-0.5 hover:scale-110 transition-transform duration-200">
                            <div class="w-full h-full rounded-full bg-white dark:bg-gray-900 flex items-center justify-center">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                    <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                                </span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex gap-8">
            <!-- Feed Section -->
            <div class="flex-1 max-w-2xl">
                <!-- Welcome Message -->
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-6 mb-8 text-white animate-fade-in">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center animate-bounce-in">
                            <i class="fas fa-user text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold animate-slide-up">¡Hola, <?php echo $_SESSION['nombre']; ?>! 👋</h2>
                            <p class="text-purple-100 animate-slide-up" style="animation-delay: 0.2s;">Bienvenido de vuelta a Instagram</p>
                        </div>
                    </div>
                </div>

                <!-- Stories -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700 p-4 mb-6 animate-fade-in">
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        <!-- Your Story -->
                        <div class="flex flex-col items-center space-y-2 min-w-0 animate-slide-up">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-yellow-400 to-pink-500 p-0.5 animate-story-ring">
                                    <div class="w-full h-full rounded-full bg-white dark:bg-gray-900 flex items-center justify-center">
                                        <span class="text-lg font-bold text-gray-700 dark:text-gray-300">
                                            <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="absolute bottom-0 right-0 w-5 h-5 bg-blue-500 rounded-full border-2 border-white dark:border-gray-900 flex items-center justify-center">
                                    <i class="fas fa-plus text-white text-xs"></i>
                                </div>
                            </div>
                            <span class="text-xs text-gray-700 dark:text-gray-300 truncate w-16 text-center">Tu historia</span>
                        </div>
                        
                        <!-- Sample Stories -->
                        <?php 
                        $stories = array(
                            array('name' => 'Lionel Messi', 'color' => 'from-purple-400 to-pink-400', 'image' => 'story1.jpg'),
                            array('name' => 'Cristiano Ronaldo', 'color' => 'from-blue-400 to-purple-400', 'image' => 'story2.jpg'),
                            array('name' => 'Neymar JR', 'color' => 'from-green-400 to-blue-400', 'image' => 'story3.jpg'),
                            array('name' => 'Son Heun Min', 'color' => 'from-yellow-400 to-red-400', 'image' => 'story4.jpg'),
                            array('name' => 'Good Kid Band', 'color' => 'from-pink-400 to-purple-400', 'image' => 'story5.jpg'),
                        );

                        foreach($stories as $index => $story): ?>
                        <div class="flex flex-col items-center space-y-2 min-w-0 animate-slide-up" style="animation-delay: <?php echo ($index + 1) * 0.1; ?>s;">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-tr <?php echo $story['color']; ?> p-0.5 hover:scale-110 transition-transform duration-200 cursor-pointer">
                                <img src="images/stories/<?php echo $story['image']; ?>" 
                                     alt="<?php echo $story['name']; ?>" 
                                     class="w-full h-full rounded-full object-cover">
                            </div>
                            <span class="text-xs text-gray-700 dark:text-gray-300 truncate w-16 text-center"><?php echo $story['name']; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Posts -->
                <?php 
// Datos únicos para cada publicación
$posts = array(
    array(
        'id' => 1,
        'username' => 'leomessi',
        'name' => 'Lionel Messi',
        'time' => '2 horas',
        'image' => 'post1.jpg',
        'profile' => 'profile1.jpg',
        'likes' => rand(50000, 999999),
        'caption' => '¡Entrenando duro para el próximo partido! 💪⚽ #Messi #Training #Football',
        'comments' => rand(1000, 5000),
        'verified' => true
    ),
    array(
        'id' => 2,
        'username' => 'cristiano',
        'name' => 'Cristiano Ronaldo',
        'time' => '4 horas',
        'image' => 'post2.jpg',
        'profile' => 'profile2.jpg',
        'likes' => rand(60000, 999999),
        'caption' => 'Siempre para ser mejor cada día 🔥 #CR7 #NeverGiveUp #SiiiiU',
        'comments' => rand(1200, 6000),
        'verified' => true
    ),
    array(
        'id' => 3,
        'username' => 'neymarjr',
        'name' => 'Neymar Jr',
        'time' => '6 horas',
        'image' => 'post3.jpg',
        'profile' => 'profile3.jpg',
        'likes' => rand(40000, 800000),
        'caption' => 'Disfrutando el momento con la familia 🏖️✨ #NeymarJr #Family #Brazil',
        'comments' => rand(800, 4000),
        'verified' => true
    )
);

foreach($posts as $index => $post): ?>
<div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700 mb-6 animate-fade-in" style="animation-delay: <?php echo ($index + 1) * 0.2; ?>s;">
    <!-- Post Header -->
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-400 to-pink-400 p-0.5">
                <img src="images/profiles/<?php echo $post['profile']; ?>" 
                     alt="<?php echo $post['name']; ?>" 
                     class="w-full h-full rounded-full object-cover">
            </div>
            <div>
                <div class="flex items-center space-x-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white"><?php echo $post['username']; ?></h3>
                    <?php if($post['verified']): ?>
                        <i class="fas fa-check-circle text-blue-500 text-sm"></i>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Hace <?php echo $post['time']; ?></p>
            </div>
        </div>
        <button class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200">
            <i class="fas fa-ellipsis-h"></i>
        </button>
    </div>
    
    <!-- Post Image -->
    <div class="aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden">
        <img src="images/posts/<?php echo $post['image']; ?>" 
             alt="<?php echo $post['name']; ?> - Publicación" 
             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
    </div>
    
    <!-- Post Actions -->
    <div class="p-4">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-4">
                <button class="heart-btn hover:scale-110 transition-transform duration-200" onclick="toggleHeart(this)">
                    <i class="far fa-heart text-2xl text-gray-700 dark:text-gray-300 hover:text-red-500 transition-colors duration-300"></i>
                </button>
                <button class="hover:scale-110 transition-transform duration-200">
                    <i class="far fa-comment text-2xl text-gray-700 dark:text-gray-300 hover:text-blue-500 transition-colors duration-300"></i>
                </button>
                <button class="hover:scale-110 transition-transform duration-200">
                    <i class="far fa-paper-plane text-2xl text-gray-700 dark:text-gray-300 hover:text-green-500 transition-colors duration-300"></i>
                </button>
            </div>
            <button class="hover:scale-110 transition-transform duration-200">
                <i class="far fa-bookmark text-2xl text-gray-700 dark:text-gray-300 hover:text-yellow-500 transition-colors duration-300"></i>
            </button>
        </div>
        
        <p class="font-semibold text-gray-900 dark:text-white mb-2"><?php echo number_format($post['likes']); ?> Me gusta</p>
        <p class="text-gray-900 dark:text-white">
            <span class="font-semibold"><?php echo $post['username']; ?></span>
            <?php echo $post['caption']; ?>
        </p>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Ver los <?php echo number_format($post['comments']); ?> comentarios</p>
        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1 uppercase">Hace <?php echo $post['time']; ?></p>
    </div>
</div>
<?php endforeach; ?>
            </div>

            <!-- Sidebar -->
            <div class="hidden lg:block w-80">
                <!-- User Profile Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700 p-6 mb-6 animate-slide-up">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-purple-400 to-pink-400 p-0.5">
                            <div class="w-full h-full rounded-full bg-white dark:bg-gray-900 flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-700 dark:text-gray-300">
                                    <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white"><?php echo $_SESSION['usuario']; ?></h3>
                            <p class="text-gray-500 dark:text-gray-400"><?php echo $_SESSION['nombre']; ?></p>
                        </div>
                    </div>
                    <div class="flex justify-between text-center">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">10</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Publicaciones</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">2,000,000</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Seguidores</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">7</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Seguidos</p>
                        </div>
                    </div>
                    <button onclick="logout()" class="w-full mt-4 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                    </button>
                </div>

                <!-- Suggestions -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-300 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.3s;">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-500 dark:text-gray-400">Sugerencias para ti</h3>
                        <button class="text-xs font-semibold text-blue-500 hover:text-blue-700 transition-colors duration-200">Ver todo</button>
                    </div>
                    
                    <?php 
$suggestions = array(
    array('name' => 'kylianmbappe', 'display' => 'Kylian Mbappé', 'image' => 'suggestion1.jpg'),
    array('name' => 'erlinghaaland', 'display' => 'Erling Haaland', 'image' => 'suggestion2.jpg'),
    array('name' => 'pedri', 'display' => 'Pedri González', 'image' => 'suggestion3.jpg'),
    array('name' => 'vinijr', 'display' => 'Vinicius Jr.', 'image' => 'suggestion4.jpg'),
    array('name' => 'paulodybala', 'display' => 'Paulo Dybala', 'image' => 'suggestion5.jpg'),
);

foreach($suggestions as $index => $suggestion): ?>
<div class="flex items-center justify-between mb-3 animate-fade-in" style="animation-delay: <?php echo ($index + 3) * 0.1; ?>s;">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-400 to-purple-400 p-0.5">
            <img src="images/suggestions/<?php echo $suggestion['image']; ?>" 
                 alt="<?php echo $suggestion['display']; ?>" 
                 class="w-full h-full rounded-full object-cover">
        </div>
        <div>
            <h4 class="font-semibold text-sm text-gray-900 dark:text-white"><?php echo $suggestion['name']; ?></h4>
            <p class="text-xs text-gray-500 dark:text-gray-400">Sugerido para ti</p>
        </div>
    </div>
    <button class="text-xs font-semibold text-blue-500 hover:text-blue-700 transition-colors duration-200 hover:scale-105 transform">
        Seguir
    </button>
</div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById("themeToggle")
        const html = document.documentElement

        const currentTheme = localStorage.getItem("theme") || "light"
        if (currentTheme === "dark") {
            html.classList.add("dark")
        }

        themeToggle.addEventListener("click", () => {
            html.classList.toggle("dark")
            const newTheme = html.classList.contains("dark") ? "dark" : "light"
            localStorage.setItem("theme", newTheme)
            
            themeToggle.style.transform = "scale(0.8)"
            setTimeout(() => {
                themeToggle.style.transform = "scale(1)"
            }, 150)
        })

        // Heart Animation
        function toggleHeart(button) {
            const icon = button.querySelector('i')
            if (icon.classList.contains('far')) {
                icon.classList.remove('far')
                icon.classList.add('fas', 'text-red-500')
                icon.style.animation = 'heart 0.3s ease-in-out'
            } else {
                icon.classList.remove('fas', 'text-red-500')
                icon.classList.add('far')
                icon.style.animation = ''
            }
        }

        // Logout function
        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = 'logout.php'
            }
        }

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1'
                    entry.target.style.transform = 'translateY(0)'
                }
            })
        }, observerOptions)

        document.querySelectorAll('.animate-fade-in').forEach(el => {
            observer.observe(el)
        })
    </script>
</body>
</html>
