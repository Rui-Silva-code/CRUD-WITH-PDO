<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Verifique se o ID da consulta foi especificado na URL
    if (!isset($_GET['id'])) {
        die("ID de consulta não especificado.");
    }
    // Recupere o ID da consulta da URL
    $id_consulta = $_GET['id'];
} else {
    $id_consulta = $_POST['id'];
}

// Ligação à base de dados
include 'basedados.php';

// Recupere os detalhes da consulta com base no ID
$user_id = $_SESSION['user_id'];
$data = '';
$horario = '';

try {
    // Consulta para obter os detalhes da consulta com base no ID da consulta e no ID do usuário
    $sql = "SELECT * FROM consultas WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_consulta, $user_id]);
    $row = $stmt->fetch();

    if ($row) {
        $data = $row['data'];
        $horario = $row['horario'];
    } else {
        echo "<p>" . htmlspecialchars("Consulta não encontrada ou não pertence a este usuário.", ENT_QUOTES, 'UTF-8') . "</p>";
        exit();
    }
} catch(PDOException $e) {
    echo "<p>" . htmlspecialchars("Erro ao obter dados da consulta.", ENT_QUOTES, 'UTF-8') . "</p>";
    error_log("Erro ao obter consulta: " . $e->getMessage());
    exit();
}

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os novos dados da consulta do formulário
    $nova_data = $_POST['data'];
    $novo_horario = $_POST['horario'];

    // Verifique se a nova data é pelo menos 3 dias no futuro
    $hoje = new DateTime();
    $data_nova = new DateTime($nova_data);
    $intervalo = $hoje->diff($data_nova);
    $diferenca_dias = $intervalo->format('%r%a');

    if ($diferenca_dias >= 3) {
        try {
            // Atualize os dados da consulta no banco de dados
            $sql = "UPDATE consultas SET data = ?, horario = ? WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nova_data, $novo_horario, $id_consulta, $user_id]);

            echo "<p>" . htmlspecialchars("Consulta atualizada com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>Data da reserva atualizada para: " . htmlspecialchars($nova_data, ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>Horário da reserva atualizado para: " . htmlspecialchars($novo_horario, ENT_QUOTES, 'UTF-8') . "</p>";
        } catch(PDOException $e) {
            echo "<p>" . htmlspecialchars("Erro ao atualizar a consulta. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
            error_log("Erro ao atualizar consulta: " . $e->getMessage());
        }
    } else {
        // Não permitir edição da data
        echo "<p>" . htmlspecialchars("A nova data deve ser pelo menos 3 dias no futuro.", ENT_QUOTES, 'UTF-8') . "</p>";
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
        <label for="data">Nova Data da Consulta:</label>
        <input type="date" id="data" name="data" value="<?php echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <label for="horario">Novo Horário da Consulta:</label>
        <input type="time" id="horario" name="horario" value="<?php echo htmlspecialchars($horario, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_consulta, ENT_QUOTES, 'UTF-8'); ?>"><br><br>
        <input type="submit" name="s" value="Salvar Alterações" >
    </form>

    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>
