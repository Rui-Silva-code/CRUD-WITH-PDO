<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Ligação à base de dados
include 'basedados.php';

// Verificar se o ID do usuário a ser excluído foi especificado na URL
if (!isset($_GET['user_id'])) {
    die(htmlspecialchars("ID do usuário não especificado.", ENT_QUOTES, 'UTF-8'));
}

// Recuperar o ID do usuário da URL
$user_id = $_GET['user_id'];

try {
    // Verificar se o usuário tem consultas marcadas
    $sql_verificar_consultas = "SELECT * FROM consultas WHERE user_id = ?";
    $stmt = $conn->prepare($sql_verificar_consultas);
    $stmt->execute([$user_id]);
    $result_verificar_consultas = $stmt->fetchAll();

    if (count($result_verificar_consultas) > 0) {
        echo "<p>" . htmlspecialchars("Este usuário não pode ser excluído porque tem consultas marcadas.", ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><a href='perfil_admin.php'>Voltar para a página de administrador</a></p>";
        exit();
    }

    // Consulta para excluir o usuário
    $sql_excluir_usuario = "DELETE FROM utilizadores WHERE user_id = ?";
    $stmt = $conn->prepare($sql_excluir_usuario);
    $stmt->execute([$user_id]);

    echo "<p>" . htmlspecialchars("Usuário excluído com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><a href='perfil_admin.php'>Voltar para a página de administrador</a></p>";
} catch(PDOException $e) {
    echo "<p>" . htmlspecialchars("Erro ao excluir o usuário. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
    error_log("Erro ao excluir usuário: " . $e->getMessage());
}
?>
