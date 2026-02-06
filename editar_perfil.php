<?php
session_start();

// Verificar a autenticação do usuário
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver autenticado
    exit();
}

// Ligação à base de dados
include 'basedados.php';

// Supondo que você tenha uma maneira de identificar o usuário logado (por exemplo, usando uma sessão)
$user_id = $_SESSION['user_id']; // Certifique-se de configurar a sessão corretamente

$row = null;

try {
    // Consulta para obter os dados atuais do usuário
    $sql = "SELECT * FROM utilizadores WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();

    if (!$row) {
        $row = null;
    }
} catch(PDOException $e) {
    error_log("Erro ao obter dados do usuário: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de edição
    $novo_nome = $_POST['novo_nome'];
    $novo_password = $_POST['novo_password'];

    try {
        // Consulta para atualizar os dados do usuário
        $sql_update = "UPDATE utilizadores SET nome = ?, apelido = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->execute([$novo_nome, $novo_password, $user_id]);

        echo "<p>" . htmlspecialchars("Dados atualizados com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
        echo '<p><a href="perfil_utilizador.php">Voltar ao Perfil</a></p>';
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao atualizar os dados. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar perfil: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
</head>
<body>
    <h2>Editar Perfil</h2>
    
    <?php
    // Exibir o formulário de edição aqui
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="novo_nome">Novo Nome:</label>
        <input type="text" id="novo_nome" name="novo_nome" value="<?php echo htmlspecialchars($row['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="novo_password">Novo apelido:</label>
        <input type="password" id="novo_password" name="novo_password" value="<?php echo htmlspecialchars($row['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

       
        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
