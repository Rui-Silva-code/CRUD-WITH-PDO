<?php
session_start();
// Database connection
include 'basedados.php';

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the login page if not authenticated
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['user_id'];

try {
    // Primeira query - buscar dados do utilizador (PDO)
    $sql = "SELECT nome, apelido, user_name, email FROM utilizadores WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $row = $stmt->fetch();
    
    if ($row) {
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $user_name = $row['user_name'];
        $email = $row['email'];
    } else {
        echo "Perfil de usuário não encontrado.";
        exit();
    }
    
} catch(PDOException $e) {
    die("Erro na consulta SQL: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Perfil do Utilizador</title>
    <style>
    
    body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
text-align: center;
}

#imagem1{
    height: 200px;
    border-radius: 50%;
}

.primeira{
    width: 39%;
    float: right;
    border-left: 2px solid grey;
    text-align: center;
}
.segunda{
    width: 100%;
    height: 200px;
    text-align: center;

    
}

.terceira{
    
    float: left;
    width: 60%;
}

#user-table1{
    margin-left: 100px;
}
.user-table{
    margin-left: 500px;
    border-collapse: collapse;
    font-size: 1em;
    min-width: 400px;

}

.user-table thead tr{
    text-align: left;
}

.user-table th, .user-table td{
    padding: 10px 10px;
    text-align: center;
}

.user-table  th,td{
    border: 1px solid black;
    
}

form{
    text-align: left;
    margin-left: 250px;
}

#registo{
    font-size: 15px;
    text-decoration: none;
    color: black;
    
}

#registo:hover{
    color: blue;
}

#botaoSair{
    float:right;
    text-decoration: none;
    color: blue;
    font-size: 15px;
}

h1{
    margin-left: 100px;
}
    </style>
</head>
<body>
<a href="logout.php" id="botaoSair">Terminar Sessão</a>
    <h1>Perfil do Utilizador</h1>
    <h3>Olá <?php echo htmlspecialchars($nome); ?>! </h3>

<div>
    <img src="imagens/utilizador.jpg" id="imagem1" alt="Foto de perfil">
</div>

<div class="segunda">
    <h3>Os teus dados:</h3>
    <table class="user-table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Apelido</th>
            <th>Nome de Utilizador</th>
            <th>Email</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($nome); ?></td>
            <td><?php echo htmlspecialchars($apelido); ?></td>
            <td><?php echo htmlspecialchars($user_name); ?></td>
            <td><?php echo htmlspecialchars($email); ?></td>
        </tr>
        </thead>
    </table>

    <p id="conta"><a id="registo" href="editar_perfil.php">Editar dados do utilizador</a></p>
</div>
<hr>

<div class="terceira">
    <h3>Marcar Consulta:</h3>
    <form method="POST" action="marcar_consulta.php">
        <label for="data">Data da Consulta:</label>
        <input type="date" id="data" name="data" required><br><br>

        <label for="horario">Hora da Consulta:</label>
        <input type="time" id="horario" name="horario" required><br><br>

        <input type="submit" value="Marcar Consulta" class="meu-botao-submit"> 
    </form>
</div>

<div class="primeira">
    <h3>Consultas Agendadas</h3>
    <table class="user-table" id="user-table1">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                // Recupera as consultas agendadas do usuário (PDO com prepared statement)
                $sql = "SELECT id, data, horario FROM consultas WHERE user_id = :user_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                
                $consultas = $stmt->fetchAll();
                
                if (count($consultas) > 0) {
                    foreach ($consultas as $row) {
                        $consulta_id = $row['id'];
                        $data = htmlspecialchars($row['data']);
                        $horario = htmlspecialchars($row['horario']);

                        // Exibe cada consulta agendada em uma linha da tabela
                        echo "<tr>";
                        echo "<td>$data</td>";
                        echo "<td>$horario</td>";
                        echo "<td>";
                        echo "<a href='editar_consulta.php?id=$consulta_id'>Editar</a> | ";
                        echo "<a href='excluir_consulta.php?id=$consulta_id'>Excluir</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma consulta agendada.</td></tr>";
                }
                
            } catch(PDOException $e) {
                echo "<tr><td colspan='3'>Erro ao carregar consultas: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>