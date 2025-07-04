<?php
require_once '../conexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conn->query("SELECT * FROM clientes");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo) VALUES (?, ?)");
        $stmt->execute([$data['nombre'], $data['correo']]);
        echo json_encode(['status' => 'Cliente creado']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE clientes SET nombre = ?, correo = ? WHERE id = ?");
        $stmt->execute([$data['nombre'], $data['correo'], $data['id']]);
        echo json_encode(['status' => 'Cliente actualizado']);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(['status' => 'Cliente eliminado']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
