<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

// Ligação à base de dados
include 'basedados.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados da consulta do formulário
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $user_id = $_SESSION['user_id'];

    try {
        // Insira os dados da consulta no banco de dados usando prepared statements
        $sql = "INSERT INTO consultas (user_id, data, horario) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id, $data, $horario]);

        echo "<p>" . htmlspecialchars("Consulta marcada com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao marcar a consulta. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao marcar consulta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Marcar Consulta</title>
    <style>

body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
}
    </style>
</head>
<body>

 
    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>
