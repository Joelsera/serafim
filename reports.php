<?php
include_once 'db.php';
header("Content-Type: application/json");

$reports = [];

// Total de pedidos
$sqlOrders = "SELECT COUNT(*) as totalOrders FROM orders";
$result = $conn->query($sqlOrders);
if ($result){
  $data = $result->fetch_assoc();
  $reports['totalOrders'] = $data['totalOrders'];
} else {
  $reports['totalOrders'] = 0;
}

// Receita total (transações positivas)
$sqlRevenue = "SELECT SUM(valor) as totalRevenue FROM transactions WHERE valor > 0";
$result = $conn->query($sqlRevenue);
if ($result){
  $data = $result->fetch_assoc();
  $reports['totalRevenue'] = $data['totalRevenue'] ? $data['totalRevenue'] : 0;
} else {
  $reports['totalRevenue'] = 0;
}

// Despesas totais (transações negativas)
$sqlExpenses = "SELECT SUM(valor) as totalExpenses FROM transactions WHERE valor < 0";
$result = $conn->query($sqlExpenses);
if($result){
  $data = $result->fetch_assoc();
  $reports['totalExpenses'] = $data['totalExpenses'] ? $data['totalExpenses'] : 0;
} else {
  $reports['totalExpenses'] = 0;
}

echo json_encode($reports);
$conn->close();
?>