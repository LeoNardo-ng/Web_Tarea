<?php
// Archivo: includes/conexion.php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'fidelizacion';
$puerto = '3309';

$conn = new mysqli($host, $user, $password, $dbname,$puerto);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>