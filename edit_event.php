<?php
session_start();
include 'basedados.php';

$nome_evento = '';
$descricao_evento = '';
$data_evento = '';
$event_id = '';

// Verificar se o ID do evento foi fornecido
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    try {
        // Consultar o evento pelo ID
        $sql = "SELECT * FROM eventos WHERE id_eventos = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$event_id]);
        $row = $stmt->fetch();

        if ($row) {
            $nome_evento = $row['nome_evento'];
            $descricao_evento = $row['descricao_evento'];
            $data_evento = $row['data_hora_evento'];
        } else {
            echo "<p>" . htmlspecialchars("Evento não encontrado.", ENT_QUOTES, 'UTF-8') . "</p>";
            exit;
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar evento.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar evento: " . $e->getMessage());
        exit;
    }
}

// Definir a data limite
$data_limite = strtotime($data_evento);
$agora = time();
$prazo_edicao = $agora + 259200; // 72 horas em segundos

// Verificar se a data do evento já passou ou se faltam menos de 48 horas
if ($data_limite < $agora) {
    die(htmlspecialchars("Você não pode editar este evento porque a data limite já passou.", ENT_QUOTES, 'UTF-8'));
}

if ($data_limite < $prazo_edicao) {
    die(htmlspecialchars("Você não pode editar a data do evento porque faltam menos de 48 horas.", ENT_QUOTES, 'UTF-8'));
}

// Se a data limite ainda não passou e faltam mais de 48 horas, permita que o administrador edite o evento...

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_evento = $_POST['nome_evento'];
    $descricao_evento = $_POST['descricao_evento'];
    $data_evento = $_POST['data_hora_evento'];
    $event_id = $_GET['id'] ?? $_POST['event_id'];

    try {
        // Atualizar o evento na base de dados
        $sql = "UPDATE eventos SET nome_evento = ?, descricao_evento = ?, data_hora_evento = ? WHERE id_eventos = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome_evento, $descricao_evento, $data_evento, $event_id]);

        echo "<p>" . htmlspecialchars("Evento atualizado com sucesso", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao atualizar o evento. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao atualizar evento: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Evento</h1>
    <form action="" method="post">
        <label for="nome_evento">Nome do Evento:</label>
        <input type="text" id="nome_evento" name="nome_evento" value="<?php echo htmlspecialchars($nome_evento); ?>" required><br>
        
        <label for="descricao_evento">Descrição:</label>
        <textarea id="descricao_evento" name="descricao_evento" required><?php echo htmlspecialchars($descricao_evento); ?></textarea><br>
        
        <label for="data_hora_evento">Data e Hora:</label>
        <input type="datetime-local" id="data_hora_evento" name="data_hora_evento" value="<?php echo date('Y-m-d\TH:i', strtotime($data_evento)); ?>" required><br>
        
        <!-- Adicione os campos restantes conforme necessário -->
        
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>