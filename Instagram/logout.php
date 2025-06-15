<?php
session_start();
session_destroy();
echo "<script>alert('Sesion cerrada exitosamente.'); window.location.href='index.html';</script>";
?>
