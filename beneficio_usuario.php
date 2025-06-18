<?php
session_start();
// 1) Verificar sesión de cliente
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}
$id_cliente = $_SESSION['user_id'];

// Conexión
$pdo = new PDO(
    "mysql:host=localhost;port=3309;dbname=fidelizacion;charset=utf8mb4",
    "root","", [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
);


// Obtener todos los beneficios activos
$stmt = $pdo->query("SELECT id_beneficio, empresa, imagen FROM beneficios WHERE activo = 1");
$beneficios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Beneficios Disponibles</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-beneficio {
      transition: transform .2s, box-shadow .2s;
      cursor: pointer;
    }
    .card-beneficio:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .card-beneficio img {
      object-fit: cover;
      height: 180px;
    }
  </style>
</head>
<body>
      <div class="header">
    <a href="cliente.php">← Volver</a>
  </div>
  <div class="container py-4">
    <h2 class="mb-4 text-center">Beneficios para Ti</h2>
    <div class="row g-3">
      <?php foreach($beneficios as $b): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card card-beneficio" onclick="location.href='beneficio_usudeta.php?id=<?= $b['id_beneficio'] ?>'">
            <img src="<?= htmlspecialchars($b['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($b['empresa']) ?>">
            <div class="card-body text-center">
              <h5 class="card-title mb-0"><?= htmlspecialchars($b['empresa']) ?></h5>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
