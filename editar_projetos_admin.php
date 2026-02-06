<?php
session_start();
// Ligação à base de dados
include 'basedados.php';

$user_id = '';
$data_criacao = '';
$tecnologia_associada = '';
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $user_id = $_POST['user_id'];
    $data_criacao = $_POST['data_criacao'];
    $tecnologia_associada = $_POST['tecnologia_associada'];
    $status = $_POST['status'];

    try {
        // Atualizar os dados do projeto na base de dados
        $sql_update = "UPDATE projetos SET tecnologia_associada = ?, data_criacao = ?, status = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->execute([$tecnologia_associada, $data_criacao, $status, $user_id]);

        echo "<p>" . htmlspecialchars("Dados do projeto atualizados com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro na atualização. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar projeto: " . $e->getMessage());
    }
}

// Recupere as informações do projeto com base no ID do usuário
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $sql = "SELECT * FROM projetos WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();

        if ($row) {
            $user_id = $row['user_id'];
            $data_criacao = $row['data_criacao'];
            $tecnologia_associada = $row['tecnologia_associada'];
            $status = $row['status'];
        } else {
            echo "<p>" . htmlspecialchars("Projeto não encontrado.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar projeto.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar projeto: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Projetos</title>
    <style>
        body {
            margin: 0px 250px;
            background: rgb(255,216,130);
            background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%);
        }
    </style>
</head>
<body>
    <h2>Editar Projetos</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>">
        <label for="data_criacao">Data de Criação:</label>
        <input type="date" id="data_criacao" name="data_criacao" value="<?php echo htmlspecialchars($data_criacao, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="tecnologia_associada">Tecnologia Associada:</label>
        <input type="text" id="tecnologia_associada" name="tecnologia_associada" value="<?php echo htmlspecialchars($tecnologia_associada, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="marcado" <?php if ($status == "marcado") echo "selected"; ?>>Marcado</option>
            <option value="em_progresso" <?php if ($status == "em_progresso") echo "selected"; ?>>Em Progresso</option>
            <option value="terminado" <?php if ($status == "terminado") echo "selected"; ?>>Terminado</option>
        </select><br><br>
        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_admin.php">Voltar para a Página do Administrador</a></p>
</body>
</html>
