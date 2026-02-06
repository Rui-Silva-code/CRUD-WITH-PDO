<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

// Ligação à base de dados
include 'basedados.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Recupere o ID da consulta da URL
    $consulta_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Verifique se a consulta pertence a este usuário antes de excluí-la
        $sql = "DELETE FROM consultas WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$consulta_id, $user_id]);

        echo "<p>" . htmlspecialchars("Consulta excluída com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao excluir a consulta. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao excluir consulta: " . $e->getMessage());
    }
} else {
    echo "<p>" . htmlspecialchars("ID de consulta não especificado.", ENT_QUOTES, 'UTF-8') . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Excluir Consulta</title>
    <style>

body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
}
    </style>
</head>
<body>
    <h2>Excluir Consulta</h2>

    <p>Esta consulta foi excluída.</p>

    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>
