# 🚀 Proyectos Web - KIWAIT

Colección de aplicaciones web completas desarrolladas con tecnologías modernas, enfocadas en funcionalidad, diseño y experiencia de usuario.

## 📋 Proyectos Incluidos

### 🏪 Sistema CRUD - Tienda de Artículos
Sistema completo de gestión de inventario para tiendas con operaciones CRUD intuitivas.

**Características:**
- ✅ **CRUD Completo**: Crear, leer, actualizar y eliminar artículos
- 🔍 **Búsqueda en tiempo real** por código o descripción
- 🧮 **Cálculo automático** del total (cantidad × precio)
- 📱 **Diseño responsive** adaptable a todos los dispositivos
- ⚡ **Validaciones** en frontend y backend
- 🎨 **Interfaz moderna** con animaciones y efectos

**Tecnologías:**
- Frontend: HTML5, CSS3, JavaScript ES6, Font Awesome
- Backend: PHP, MySQL, MySQLi
- Base de datos: Tabla `articulos` con campos calculados

### 📸 Instagram Clone
Clon completo de Instagram con autenticación, panel de administración y modo oscuro.

**Características:**
- 🔐 **Sistema de autenticación** completo con sesiones seguras
- 👥 **Feed personalizado** con publicaciones interactivas
- 📱 **Stories animadas** con efectos visuales
- 🌙 **Modo oscuro/claro** con persistencia
- ⚙️ **Panel de administración** para gestión de usuarios
- 💖 **Sistema de likes** con animaciones
- 👤 **Perfiles de usuario** integrados

**Tecnologías:**
- Frontend: HTML5, Tailwind CSS, JavaScript ES6, Font Awesome
- Backend: PHP 7.4+, MySQL
- Base de datos: Tabla `usuarios` con autenticación

## 🛠️ Tecnologías Utilizadas

### Frontend
- **HTML5**: Estructura semántica y accesible
- **CSS3/Tailwind**: Estilos modernos y responsive
- **JavaScript ES6**: Interactividad y validaciones
- **Font Awesome**: Iconografía profesional

### Backend
- **PHP**: Lógica del servidor y APIs
- **MySQL**: Base de datos relacional
- **MySQLi**: Conexión segura a base de datos

## 🚀 Instalación Rápida

### Prerrequisitos
- XAMPP/WAMP (Apache + MySQL + PHP)
- Navegador web moderno
- Editor de código

### Pasos Generales
1. **Configurar servidor local**
   ```bash
   # Iniciar XAMPP/WAMP
   # Colocar proyectos en htdocs/www
   ```

2. **Configurar base de datos**
   ```php
   // db.php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "nombre_bd";
   ```

3. **Ejecutar scripts SQL**
   - Crear bases de datos correspondientes
   - Importar estructuras de tablas

4. **Acceder a aplicaciones**
   ```
   http://localhost/tienda-articulos
   http://localhost/instagram-clone
   ```

## 📁 Estructura de Proyectos

### Tienda de Artículos
```
tienda-articulos/
├── index.html              # Interfaz principal
├── styles.css              # Estilos CSS
├── script.js               # Lógica JavaScript
├── db.php                  # Configuración BD
├── obtener_articulos.php   # API obtener
├── agregar_articulo.php    # API crear
├── editar_articulo.php     # API actualizar
├── eliminar_articulo.php   # API eliminar
└── ver_articulo.php        # API ver detalle
```

### Instagram Clone
```
instagram-clone/
├── index.html              # Login/Registro
├── dashboard.php           # Feed principal
├── admin_panel.php         # Panel administración
├── db.php                  # Configuración BD
├── styles.css              # Estilos principales
├── script.js               # JavaScript principal
├── database.sql            # Script BD
└── images/                 # Recursos multimedia
```

## 🎯 Funcionalidades Destacadas

### Sistema CRUD
- **Gestión completa** de inventario
- **Búsqueda inteligente** con filtros
- **Validación robusta** de datos
- **Interfaz intuitiva** con modales
- **Cálculos automáticos** de totales

### Instagram Clone
- **Autenticación segura** con sesiones
- **Feed interactivo** con likes animados
- **Stories dinámicas** con efectos
- **Panel administrativo** completo
- **Modo oscuro** persistente

## 🎨 Personalización

### Colores y Temas
```css
:root {
  --primary-color: #667eea;
  --secondary-color: #764ba2;
  --success-color: #28a745;
  --danger-color: #dc3545;
}
```

### Configuración de Base de Datos
```php
// Ajustar credenciales en db.php
$servername = "tu_servidor";
$username = "tu_usuario";
$password = "tu_contraseña";
```

## 🔧 Solución de Problemas

### Errores Comunes
- **Conexión BD**: Verificar credenciales y servicios MySQL
- **Archivos no cargan**: Revisar rutas y permisos
- **JavaScript no funciona**: Verificar consola del navegador
- **Sesiones fallan**: Confirmar configuración PHP

## 👨‍💻 Autor

# **KIWAIT ❤️**
