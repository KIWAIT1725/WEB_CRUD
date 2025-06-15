<?php
// Configurar zona horaria para evitar errores de Strict Standards
date_default_timezone_set('America/Mexico_City');

session_start();
require 'db.php';

// Verificar si es administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.html';</script>";
    exit();
}

// Obtener todos los usuarios con verificación de campos
$result = $conn->query("SELECT id, nombre, usuario, email, contraseña, fecha_registro FROM usuarios ORDER BY id DESC");

// Verificar si la consulta fue exitosa
if (!$result) {
    echo "Error en la consulta: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Instagram Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'gradient': 'gradient 3s ease infinite',
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
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' }
                        }
                    },
                    backgroundImage: {
                        'instagram-gradient': 'linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d)',
                        'gradient-animated': 'linear-gradient(-45deg, #405de6, #5851db, #833ab4, #c13584)',
                    },
                    backgroundSize: {
                        '400%': '400% 400%',
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
    <header class="bg-gradient-animated bg-400% animate-gradient text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3 animate-bounce-in">
                    <i class="fas fa-user-shield text-3xl"></i>
                    <h1 class="text-2xl font-bold">Panel de Administración</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-lg">Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
                    <a href="logout.php" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 animate-fade-in transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <i class="fas fa-users text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $result->num_rows; ?></h3>
                        <p class="text-gray-600 dark:text-gray-400">Usuarios Registrados</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 animate-fade-in transform hover:scale-105 transition-all duration-300" style="animation-delay: 0.1s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <i class="fas fa-chart-line text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">100%</h3>
                        <p class="text-gray-600 dark:text-gray-400">Sistema Activo</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 animate-fade-in transform hover:scale-105 transition-all duration-300" style="animation-delay: 0.2s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                        <i class="fas fa-database text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">NET</h3>
                        <p class="text-gray-600 dark:text-gray-400">Base de Datos</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 animate-fade-in transform hover:scale-105 transition-all duration-300" style="animation-delay: 0.3s;">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                        <i class="fas fa-shield-alt text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">ADMIN</h3>
                        <p class="text-gray-600 dark:text-gray-400">Nivel de Acceso</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Management -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 animate-slide-up">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-users mr-3 text-blue-600"></i>
                        Gestión de Usuarios
                    </h2>
                    <button onclick="showAddUserForm()" 
                            class="bg-gradient-animated bg-400% animate-gradient text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Agregar Usuario
                    </button>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha Registro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 animate-fade-in">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <?php echo $row['id']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center mr-3">
                                        <span class="text-white text-xs font-bold">
                                            <?php echo strtoupper(substr($row['nombre'], 0, 1)); ?>
                                        </span>
                                    </div>
                                    <?php echo htmlspecialchars($row['nombre']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($row['usuario']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($row['email']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <?php 
                                if (isset($row['fecha_registro']) && $row['fecha_registro']) {
                                    echo date('d/m/Y H:i', strtotime($row['fecha_registro'])); 
                                } else {
                                    echo 'No disponible';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="editUser(<?php echo $row['id']; ?>)" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteUser(<?php echo $row['id']; ?>)" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900 dark:text-white">Agregar Usuario</h3>
            </div>
            
            <form id="userForm" action="procesar_admin.php" method="POST" class="p-6">
                <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="action" name="action" value="add">
                
                <div class="space-y-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    </div>
                    
                    <div>
                        <label for="usuario" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email:</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    </div>
                    
                    <div>
                        <label for="contraseña" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña:</label>
                        <input type="password" id="contraseña" name="contraseña" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-gradient-animated bg-400% animate-gradient text-white rounded-lg font-semibold hover:opacity-90 transform hover:scale-105 transition-all duration-300">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Theme Toggle
        const html = document.documentElement
        const currentTheme = localStorage.getItem("theme") || "light"
        if (currentTheme === "dark") {
            html.classList.add("dark")
        }

        // Modal Functions
        function showAddUserForm() {
            document.getElementById("modalTitle").textContent = "Agregar Usuario"
            document.getElementById("action").value = "add"
            document.getElementById("userForm").reset()
            document.getElementById("userId").value = ""
            showModal()
        }

        function editUser(id) {
            document.getElementById("modalTitle").textContent = "Editar Usuario"
            document.getElementById("action").value = "edit"
            document.getElementById("userId").value = id
            showModal()
        }

        function deleteUser(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                window.location.href = `procesar_admin.php?action=delete&id=${id}`
            }
        }

        function showModal() {
            const modal = document.getElementById("userModal")
            const modalContent = document.getElementById("modalContent")
            
            modal.classList.remove("hidden")
            modal.classList.add("flex")
            
            setTimeout(() => {
                modal.style.opacity = "1"
                modalContent.style.transform = "scale(1)"
                modalContent.style.opacity = "1"
            }, 10)
        }

        function closeModal() {
            const modal = document.getElementById("userModal")
            const modalContent = document.getElementById("modalContent")
            
            modal.style.opacity = "0"
            modalContent.style.transform = "scale(0.95)"
            modalContent.style.opacity = "0"
            
            setTimeout(() => {
                modal.classList.add("hidden")
                modal.classList.remove("flex")
            }, 300)
        }

        // Close modal when clicking outside
        document.getElementById("userModal").addEventListener("click", (e) => {
            if (e.target.id === "userModal") {
                closeModal()
            }
        })

        // Add entrance animations to table rows
        const tableRows = document.querySelectorAll("tbody tr")
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.1}s`
        })
    </script>
</body>
</html>
