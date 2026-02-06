<?php
session_start();

// Ligação à base de dados
include 'basedados.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['apelido'];
    $user_id = $_SESSION['user_id'];

    try {
        // Atualizar os dados na tabela utilizadores
        $sql = "UPDATE utilizadores SET nome = ?, sobrenome = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $sobrenome, $user_id]);

        echo "<p>" . htmlspecialchars("Perfil atualizado com sucesso!", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao atualizar o perfil. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar perfil: " . $e->getMessage());
    }
}
?>
