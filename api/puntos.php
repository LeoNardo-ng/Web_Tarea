<?php
require_once '../conexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT * FROM puntos WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conn->query("SELECT * FROM puntos");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO puntos (cliente_id, cantidad, fecha) VALUES (?, ?, ?)");
        $stmt->execute([$data['cliente_id'], $data['cantidad'], $data['fecha']]);
        echo json_encode(['status' => 'Puntos creados']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE puntos SET cliente_id = ?, cantidad = ?, fecha = ? WHERE id = ?");
        $stmt->execute([$data['cliente_id'], $data['cantidad'], $data['fecha'], $data['id']]);
        echo json_encode(['status' => 'Puntos actualizados']);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("DELETE FROM puntos WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(['status' => 'Puntos eliminados']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
