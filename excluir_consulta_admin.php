<?php
session_start();

// Verifique se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Ligação à base de dados
include 'basedados.php';

// Verifique se o ID da consulta foi especificado na URL
if (!isset($_GET['consulta_id'])) {
    die(htmlspecialchars("ID da consulta não especificado.", ENT_QUOTES, 'UTF-8'));
}

// Recupere o ID da consulta da URL
$consulta_id = $_GET['consulta_id'];

try {
    // Exclua a consulta do banco de dados
    $sql = "DELETE FROM consultas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$consulta_id]);

    echo "<p>" . htmlspecialchars("Consulta excluída com sucesso.", ENT_QUOTES, 'UTF-8') . " <a href='perfil_admin.php'>Voltar à página do administrador</a></p>";
} catch(PDOException $e) {
    echo "<p>" . htmlspecialchars("Erro ao excluir a consulta. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
    error_log("Erro ao excluir consulta admin: " . $e->getMessage());
}
?>
