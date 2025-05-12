<?php
include_once 'db.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM inventory";
    $result = $conn->query($sql);
    $data = [];
    if ($result) {
      while ($row = $result->fetch_assoc()) {
          $data[] = $row;
      }
    }
    echo json_encode($data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza a quantidade de um ingrediente
    $id = $_POST['id'];
    $novaQuantidade = $_POST['quantidade'];
    $stmt = $conn->prepare("UPDATE inventory SET quantidade = ? WHERE id = ?");
    $stmt->bind_param("ii", $novaQuantidade, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
    $stmt->close();
} else {
    http_response_code(405);
}

$conn->close();
?>