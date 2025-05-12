<?php
// db.php - configura a conexão com o MySQL
$host = "localhost";
$user = "seu_usuario";    // substitua pelo seu usuário do MySQL
$password = "sua_senha";  // substitua pela sua senha
$database = "erp_gastronomico";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>