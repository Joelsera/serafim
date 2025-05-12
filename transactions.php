<?php
include_once 'db.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM transactions ORDER BY data DESC";
    $result = $conn->query($sql);
    $data = [];
    if ($result) {
      while ($row = $result->fetch_assoc()){
        $data[] = $row;
      }
    }
    echo json_encode($data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataTransacao = $_POST['data'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    $stmt = $conn->prepare("INSERT INTO transactions (data, descricao, valor) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $dataTransacao, $descricao, $valor);
    if ($stmt->execute()){
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