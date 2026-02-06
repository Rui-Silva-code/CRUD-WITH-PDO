<?php
session_start();

// Ligação à base de dados
include 'basedados.php';

$consulta_id = '';
$data = '';
$horario = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $consulta_id = $_POST['consulta_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    try {
        // Atualize os dados da consulta na base de dados
        $sql_update = "UPDATE consultas SET data = ?, horario = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->execute([$data, $horario, $consulta_id]);

        echo "<p>" . htmlspecialchars("Consulta atualizada com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro na atualização. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar consulta admin: " . $e->getMessage());
    }
}

// Recupere as informações da consulta com base no ID
if (isset($_GET['consulta_id'])) {
    $consulta_id = $_GET['consulta_id'];

    try {
        $sql = "SELECT * FROM consultas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$consulta_id]);
        $row = $stmt->fetch();

        if ($row) {
            $data = $row['data'];
            $horario = $row['horario'];
        } else {
            echo "<p>" . htmlspecialchars("Consulta não encontrada.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar dados da consulta.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar consulta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Consulta</title>

    <style>

body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
}


    </style>
</head>
<body>
    <h2>Editar Consulta</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="consulta_id" value="<?php echo htmlspecialchars($consulta_id, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" value="<?php echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="horario">Horário:</label>
        <input type="time" id="horario" name="horario" value="<?php echo htmlspecialchars($horario, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_admin.php">Voltar para a Página do Administrador</a></p>
</body>
</html>
