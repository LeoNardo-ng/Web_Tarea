<?php
// Archivo: index.php
session_start();
include 'includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE telefono = ?");
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if ($cliente && password_verify($password, $cliente['password'])) {
        $_SESSION['id'] = $cliente['id'];
        $_SESSION['admin'] = ($telefono == 'admin');

        header("Location: " . ($_SESSION['admin'] ? "dashboard_admin.php" : "dashboard_user.php"));
        exit();
    } else {
        $error = "<p class='error'>Credenciales incorrectas.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Programa de Fidelización</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) echo $error; ?>
        <form method="POST">
            <input type="text" name="telefono" placeholder="Teléfono" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
</body>
</html>

