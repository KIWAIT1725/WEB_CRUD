// Variables globales
let currentArticleId = null;

// Inicializar la aplicación
document.addEventListener('DOMContentLoaded', function() {
    loadArticles();
    setupEventListeners();
});

// Configurar event listeners
function setupEventListeners() {
    // Formulario de agregar
    document.getElementById('addForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addArticle();
    });

    // Formulario de editar
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateArticle();
    });

    // Cerrar modales al hacer clic fuera
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            closeModal(e.target.id);
        }
    });

    // Cerrar modales con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal[style*="block"]');
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });
}

// Cargar artículos desde la base de datos
function loadArticles() {
    showLoading();
    
    fetch('obtener_articulos.php')
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.error) {
                showAlert('Error al cargar los artículos: ' + data.error, 'error');
                renderEmptyTable();
            } else {
                renderArticles(data);
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Error de conexión al cargar los artículos', 'error');
            renderEmptyTable();
        });
}

// Renderizar artículos en la tabla
function renderArticles(articles) {
    const tbody = document.getElementById('articlesTableBody');
    tbody.innerHTML = '';

    if (!articles || articles.length === 0) {
        renderEmptyTable();
        return;
    }

    articles.forEach(article => {
        const total = (article.cantidad * article.precio).toFixed(2);
        const row = document.createElement('tr');
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        
        row.innerHTML = `
            <td>${article.id}</td>
            <td><strong>${article.codigo}</strong></td>
            <td>${article.descripcion}</td>
            <td>${article.cantidad}</td>
            <td>C$ ${parseFloat(article.precio).toFixed(2)}</td>
            <td><strong>C$ ${total}</strong></td>
            <td>${formatDate(article.fecha_compra)}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-info btn-sm" onclick="viewArticle(${article.id})" title="Ver detalles">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-warning btn-sm" onclick="editArticle(${article.id})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteArticle(${article.id})" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        tbody.appendChild(row);
        
        // Animación de entrada
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 50);
    });
}

// Renderizar tabla vacía
function renderEmptyTable() {
    const tbody = document.getElementById('articlesTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 18px; margin: 0;">No se encontraron artículos</p>
                <p style="font-size: 14px; margin: 5px 0 0 0; opacity: 0.7;">Agrega tu primer artículo usando el botón "Agregar Artículo"</p>
            </td>
        </tr>
    `;
}

// Buscar artículos
function searchArticles() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    
    if (searchTerm === '') {
        loadArticles();
        return;
    }

    showLoading();
    
    fetch(`obtener_articulos.php?search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.error) {
                showAlert('Error en la búsqueda: ' + data.error, 'error');
            } else {
                renderArticles(data);
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Error de conexión en la búsqueda', 'error');
        });
}

// Abrir modal con animación
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = modal.querySelector('.modal-content');
    
    modal.style.display = 'block';
    modalContent.style.transform = 'scale(0.7) translateY(-50px)';
    modalContent.style.opacity = '0';
    
    // Animación de entrada
    setTimeout(() => {
        modalContent.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
        modalContent.style.transform = 'scale(1) translateY(0)';
        modalContent.style.opacity = '1';
    }, 10);
    
    // Si es el modal de agregar, establecer fecha actual por defecto
    if (modalId === 'addModal') {
        document.getElementById('addFechaCompra').value = new Date().toISOString().split('T')[0];
    }
    
    // Enfocar el primer input
    setTimeout(() => {
        const firstInput = modal.querySelector('input:not([type="hidden"])');
        if (firstInput) {
            firstInput.focus();
        }
    }, 300);
}

// Cerrar modal con animación
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const modalContent = modal.querySelector('.modal-content');
    
    modalContent.style.transition = 'all 0.2s ease';
    modalContent.style.transform = 'scale(0.7) translateY(-50px)';
    modalContent.style.opacity = '0';
    
    setTimeout(() => {
        modal.style.display = 'none';
        modalContent.style.transform = '';
        modalContent.style.opacity = '';
        modalContent.style.transition = '';
    }, 200);
    
    // Limpiar formularios
    if (modalId === 'addModal') {
        document.getElementById('addForm').reset();
    } else if (modalId === 'editModal') {
        document.getElementById('editForm').reset();
    }
}

// Agregar artículo
function addArticle() {
    const form = document.getElementById('addForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Deshabilitar botón y mostrar loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading"></span> Guardando...';
    
    fetch('agregar_articulo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Guardar';
        
        if (data.success) {
            closeModal('addModal');
            showAlert('Artículo agregado exitosamente', 'success');
            loadArticles(); // Recargar la tabla
        } else {
            showAlert('Error al agregar el artículo: ' + (data.error || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Guardar';
        console.error('Error:', error);
        showAlert('Error de conexión al agregar el artículo', 'error');
    });
}

// Ver artículo
function viewArticle(id) {
    showLoading();
    
    fetch(`ver_articulo.php?id=${id}`)
        .then(response => response.json())
        .then(article => {
            hideLoading();
            
            if (article.error) {
                showAlert('Error al cargar el artículo: ' + article.error, 'error');
                return;
            }
            
            if (!article) {
                showAlert('Artículo no encontrado', 'error');
                return;
            }

            const total = (article.cantidad * article.precio).toFixed(2);
            
            document.getElementById('viewId').textContent = article.id;
            document.getElementById('viewCodigo').textContent = article.codigo;
            document.getElementById('viewDescripcion').textContent = article.descripcion || 'Sin descripción';
            document.getElementById('viewCantidad').textContent = article.cantidad;
            document.getElementById('viewPrecio').textContent = parseFloat(article.precio).toFixed(2);
            document.getElementById('viewTotal').textContent = total;
            document.getElementById('viewFechaCompra').textContent = formatDate(article.fecha_compra);
            
            openModal('viewModal');
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Error de conexión al cargar el artículo', 'error');
        });
}

// Editar artículo
function editArticle(id) {
    showLoading();
    
    fetch(`ver_articulo.php?id=${id}`)
        .then(response => response.json())
        .then(article => {
            hideLoading();
            
            if (article.error) {
                showAlert('Error al cargar el artículo: ' + article.error, 'error');
                return;
            }
            
            if (!article) {
                showAlert('Artículo no encontrado', 'error');
                return;
            }

            document.getElementById('editId').value = article.id;
            document.getElementById('editCodigo').value = article.codigo;
            document.getElementById('editDescripcion').value = article.descripcion || '';
            document.getElementById('editCantidad').value = article.cantidad;
            document.getElementById('editPrecio').value = article.precio;
            document.getElementById('editFechaCompra').value = article.fecha_compra;
            
            openModal('editModal');
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Error de conexión al cargar el artículo', 'error');
        });
}

// Actualizar artículo
function updateArticle() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Deshabilitar botón y mostrar loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading"></span> Actualizando...';
    
    fetch('editar_articulo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Actualizar';
        
        if (data.success) {
            closeModal('editModal');
            showAlert('Artículo actualizado exitosamente', 'success');
            loadArticles(); // Recargar la tabla
        } else {
            showAlert('Error al actualizar el artículo: ' + (data.error || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Actualizar';
        console.error('Error:', error);
        showAlert('Error de conexión al actualizar el artículo', 'error');
    });
}

// Eliminar artículo
function deleteArticle(id) {
    showLoading();
    
    fetch(`ver_articulo.php?id=${id}`)
        .then(response => response.json())
        .then(article => {
            hideLoading();
            
            if (article.error) {
                showAlert('Error al cargar el artículo: ' + article.error, 'error');
                return;
            }
            
            if (!article) {
                showAlert('Artículo no encontrado', 'error');
                return;
            }

            currentArticleId = id;
            document.getElementById('deleteArticleName').textContent = `${article.codigo} - ${article.descripcion}`;
            openModal('deleteModal');
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Error de conexión al cargar el artículo', 'error');
        });
}

// Confirmar eliminación
function confirmDelete() {
    if (!currentArticleId) return;

    const deleteBtn = document.querySelector('#deleteModal .btn-danger');
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<span class="loading"></span> Eliminando...';
    
    fetch('eliminar_articulo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id: currentArticleId})
    })
    .then(response => response.json())
    .then(data => {
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = 'Eliminar';
        
        if (data.success) {
            closeModal('deleteModal');
            showAlert('Artículo eliminado exitosamente', 'success');
            loadArticles(); // Recargar la tabla
        } else {
            showAlert('Error al eliminar el artículo: ' + (data.error || 'Error desconocido'), 'error');
        }
        
        currentArticleId = null;
    })
    .catch(error => {
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = 'Eliminar';
        console.error('Error:', error);
        showAlert('Error de conexión al eliminar el artículo', 'error');
        currentArticleId = null;
    });
}

// Formatear fecha
function formatDate(dateString) {
    if (!dateString) return 'Sin fecha';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}

// Mostrar alertas con animación
function showAlert(message, type) {
    // Remover alertas existentes
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        ${message}
    `;
    
    // Estilos iniciales para animación
    alertDiv.style.opacity = '0';
    alertDiv.style.transform = 'translateY(-20px)';
    alertDiv.style.transition = 'all 0.3s ease';
    
    document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.search-section'));
    
    // Animación de entrada
    setTimeout(() => {
        alertDiv.style.opacity = '1';
        alertDiv.style.transform = 'translateY(0)';
    }, 10);
    
    // Remover después de 4 segundos con animación
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        alertDiv.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 300);
    }, 4000);
}

// Mostrar indicador de carga
function showLoading() {
    let loadingDiv = document.getElementById('loadingIndicator');
    
    if (!loadingDiv) {
        loadingDiv = document.createElement('div');
        loadingDiv.id = 'loadingIndicator';
        loadingDiv.innerHTML = `
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                backdrop-filter: blur(2px);
            ">
                <div style="
                    background: white;
                    padding: 20px 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    gap: 15px;
                ">
                    <div class="loading"></div>
                    <span style="font-weight: 500; color: #333;">Cargando...</span>
                </div>
            </div>
        `;
        document.body.appendChild(loadingDiv);
    }
    
    loadingDiv.style.display = 'block';
}

// Ocultar indicador de carga
function hideLoading() {
    const loadingDiv = document.getElementById('loadingIndicator');
    if (loadingDiv) {
        loadingDiv.style.display = 'none';
    }
}

// Validación de formularios
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            input.style.borderColor = '#e1e5e9';
        }
    });
    
    return isValid;
}

// Limpiar validación al escribir
document.addEventListener('input', function(e) {
    if (e.target.tagName === 'INPUT') {
        e.target.style.borderColor = '#e1e5e9';
    }
});

// Función para refrescar la tabla
function refreshTable() {
    showAlert('Actualizando lista de artículos...', 'info');
    loadArticles();
}

// Agregar botón de refrescar (opcional)
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    const refreshBtn = document.createElement('button');
    refreshBtn.className = 'btn btn-secondary';
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Actualizar';
    refreshBtn.onclick = refreshTable;
    refreshBtn.style.marginLeft = '10px';
    
    header.appendChild(refreshBtn);
});