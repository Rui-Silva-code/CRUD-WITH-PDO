<?php
session_start();

// Ligação à base de dados
include 'basedados.php';

$user_id = '';
$nome = '';
$apelido = '';
$user_name = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $user_id = $_POST['user_id'];
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];

    try {
        // Atualize os dados do usuário na base de dados
        $sql_update = "UPDATE utilizadores SET nome = ?, apelido = ?, user_name = ?, email = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->execute([$nome, $apelido, $user_name, $email, $user_id]);

        echo "<p>" . htmlspecialchars("Dados do usuário atualizados com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro na atualização. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar perfil admin: " . $e->getMessage());
    }
}

// Recupere as informações do usuário com base no ID
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $sql = "SELECT * FROM utilizadores WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();

        if ($row) {
            $nome = $row['nome'];
            $apelido = $row['apelido'];
            $user_name = $row['user_name'];
            $email = $row['email'];
        } else {
            echo "<p>" . htmlspecialchars("Usuário não encontrado.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar dados do usuário.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar usuário: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Perfil do Usuário</title>
    <style>

body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
}


    </style>

</head>
<body>
    <h2>Editar Perfil do Usuário</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" value="<?php echo htmlspecialchars($apelido, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="user_name">Nome de Utilizador:</label>
        <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_admin.php">Voltar para a Página do Administrador</a></p>
</body>
</html>
