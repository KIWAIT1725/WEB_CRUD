function showAddUserForm() {
  document.getElementById("modalTitle").textContent = "Agregar Usuario"
  document.getElementById("action").value = "add"
  document.getElementById("userForm").reset()
  document.getElementById("userId").value = ""
  document.getElementById("userModal").style.display = "block"
}

function editUser(id) {
  // Aquí podrías hacer una petición AJAX para obtener los datos del usuario
  document.getElementById("modalTitle").textContent = "Editar Usuario"
  document.getElementById("action").value = "edit"
  document.getElementById("userId").value = id
  document.getElementById("userModal").style.display = "block"
}

function deleteUser(id) {
  if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
    window.location.href = `procesar_admin.php?action=delete&id=${id}`
  }
}

function closeModal() {
  document.getElementById("userModal").style.display = "none"
}

// Cerrar modal al hacer clic fuera de él
window.onclick = (event) => {
  const modal = document.getElementById("userModal")
  if (event.target == modal) {
    modal.style.display = "none"
  }
}
