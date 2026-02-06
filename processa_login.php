<?php
session_start();

// Ligação à base de dados
include 'basedados.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de login
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    try {
        // Consulta para verificar as credenciais do usuário
        $sql = "SELECT user_id, password FROM utilizadores WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_name]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id']; // Defina a variável de sessão após a autenticação bem-sucedida

            header("Location: perfil_utilizador.php"); // Redireciona para a página de perfil do usuário
            exit();
        } else {
            echo "<p>" . htmlspecialchars("Nome de usuário ou senha incorretos.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro no sistema. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro de login: " . $e->getMessage());
    }
}
?>