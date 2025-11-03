<?php
require_once __DIR__ . '/../../modelo/UsuarioModelo.php';
session_start();
$id_usuario = $_SESSION['id_usuario'] ?? 0;

$usuarioModelo = new UsuarioModelo();
$usuarios = $usuarioModelo->obtenerUsuariosExcepto($id_usuario);

header('Content-Type: application/json');
echo json_encode($usuarios);
