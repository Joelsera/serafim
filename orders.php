<?php
include_once 'db.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM orders ORDER BY data DESC";
    $result = $conn->query($sql);
    $data = [];
    if ($result){
      while ($row = $result->fetch_assoc()){
        $data[] = $row;
      }
    }
    echo json_encode($data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $_POST['cliente'];
    $itens = $_POST['itens'];
    $status = $_POST['status'] ?? 'Em Preparo';
    
    $stmt = $conn->prepare("INSERT INTO orders (cliente, itens, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $cliente, $itens, $status);
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