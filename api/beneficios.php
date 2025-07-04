<?php
require_once '../conexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT * FROM beneficios WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conn->query("SELECT * FROM beneficios");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO beneficios (nombre, descripcion) VALUES (?, ?)");
        $stmt->execute([$data['nombre'], $data['descripcion']]);
        echo json_encode(['status' => 'Beneficio creado']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE beneficios SET nombre = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$data['nombre'], $data['descripcion'], $data['id']]);
        echo json_encode(['status' => 'Beneficio actualizado']);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("DELETE FROM beneficios WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(['status' => 'Beneficio eliminado']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
