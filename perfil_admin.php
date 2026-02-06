<?php
session_start();
// Ligação à base de dados
include 'basedados.php';
// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Processar inserção de novo projeto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    // Obter dados do formulário
    $user_id = $_POST['user_id'];
    $data_criacao = $_POST['data_criacao'];
    $tecnologia_associada = $_POST['tecnologia_associada'];
    $status = $_POST['status'];

    // Processar a imagem
    $image_name = $_FILES['user_image']['name'];
    $image_tmp = $_FILES['user_image']['tmp_name'];
    $image_path = "imagens/" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    try {
        // Consulta para inserir um novo projeto na tabela projetos
        $sql_insert_projeto = "INSERT INTO projetos (user_id, data_criacao, tecnologia_associada, status, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_projeto);
        $stmt->execute([$user_id, $data_criacao, $tecnologia_associada, $status, $image_path]);

        echo "<p>" . htmlspecialchars("Projeto registrado com sucesso.", ENT_QUOTES, 'UTF-8') . "</p>";
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao registrar projeto. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao registrar projeto: " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Página do Administrador</title>

    <style>
    
    body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 

}


.cabecalho{
    text-align: center;
}


.primeira{
   width:45%;
   height: 400px;
    float: left;
 
}

.segunda{
    margin-top: 600px;
    width:100%;
    height: 400px;
    text-align: center;
    border-top: 2px solid black;
    
 }

 .terceira{
    width:55%;
    height: 400px;
  float: right;

 }

 #registo{  
    
    float:right;
    text-decoration: none;
    color: blue;
    font-size: 15px;
   
 }

 form{
    text-align: left;
    margin-left: 500px;
    margin-top: 50px;
 }

 #botaoprojeto{

    height: 30px;
    width:130px;
 }

 h1{
    margin-left: 100px;
}
    </style>
</head>

<body >
    <p id="conta"><a id="registo" href="logout.php">Terminar Sessão</a></p>

<div class="cabecalho">
    <h1 >Perfil do Administrador</h1>
    

    <p ><img src="imagens/admin1.jpg"  width="20%" height="auto" style="border-radius:50%;"></p>

    
</div>
    <div class="primeira" >



    <?php
    try {
        // Consulta para recuperar informações de todos os usuários
        $sql_users = "SELECT * FROM utilizadores";
        $stmt_users = $conn->prepare($sql_users);
        $stmt_users->execute();
        $result_users = $stmt_users->fetchAll();

        if (count($result_users) > 0) {
            echo "<h3>Informações de Todos os Utilizadores:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nome</th><th>Apelido</th><th>Nome de Utilizador</th><th>E-mail</th><th>Ações</th></tr>";

            foreach ($result_users as $row) {
                $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8');
                $nome = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');
                $apelido = htmlspecialchars($row['apelido'], ENT_QUOTES, 'UTF-8');
                $user_name = htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');

                echo "<tr><td>$user_id</td><td>$nome</td><td>$apelido</td><td>$user_name</td><td>$email</td>";
                echo "<td><a href='editar_perfil_admin.php?user_id=$user_id'>Editar</a> | <a href='excluir_utilizador_admin.php?user_id=$user_id'>Excluir</a></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>" . htmlspecialchars("Nenhum usuário encontrado.", ENT_QUOTES, 'UTF-8') . "</p>";
        }

        // Consulta para listar todas as consultas marcadas
        $sql_consultas = "SELECT * FROM consultas";
        $stmt_consultas = $conn->prepare($sql_consultas);
        $stmt_consultas->execute();
        $result_consultas = $stmt_consultas->fetchAll();

        if (count($result_consultas) > 0) {
            echo "<h3>Consultas Marcadas:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>ID do Utilizador</th><th>Data</th><th>Horário</th><th>Ações</th></tr>";

            foreach ($result_consultas as $row) {
                $consulta_id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
                $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8');
                $data = htmlspecialchars($row['data'], ENT_QUOTES, 'UTF-8');
                $horario = htmlspecialchars($row['horario'], ENT_QUOTES, 'UTF-8');

                echo "<tr><td>$consulta_id</td><td>$user_id</td><td>$data</td><td>$horario</td>";
                echo "<td><a href='editar_consulta_admin.php?consulta_id=$consulta_id'>Editar</a> | <a href='excluir_consulta_admin.php?consulta_id=$consulta_id'>Excluir</a></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>" . htmlspecialchars("Nenhuma consulta encontrada.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar dados. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar dados admin: " . $e->getMessage());
    }
    ?>


</div>


    <div class="terceira" >
    <?php
    try {
        // Consulta para listar todos os projetos
        $sql_projetos = "SELECT * FROM projetos";
        $stmt_projetos = $conn->prepare($sql_projetos);
        $stmt_projetos->execute();
        $result_projetos = $stmt_projetos->fetchAll();

        if (count($result_projetos) > 0) {
            echo "<h3>Projetos Registados: </h3>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>ID do Utilizador</th><th>Data</th><th>Tecnologia Associada</th><th>Imagem</th><th>Status</th><th>Ações</th></tr>";

            foreach ($result_projetos as $row) {
                $id_projeto = htmlspecialchars($row['id_projeto'], ENT_QUOTES, 'UTF-8');
                $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8');
                $data_criacao = htmlspecialchars($row['data_criacao'], ENT_QUOTES, 'UTF-8');
                $tecnologia_associada = htmlspecialchars($row['tecnologia_associada'], ENT_QUOTES, 'UTF-8');
                $imagem = htmlspecialchars($row['imagem'], ENT_QUOTES, 'UTF-8');
                $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');

                echo "<tr><td>$id_projeto</td><td>$user_id</td><td>$data_criacao</td><td>$tecnologia_associada</td><td>$imagem</td><td>$status</td>";
                echo "<td><a href='editar_projetos_admin.php?consulta_id=$id_projeto'>Editar</a> | <a href='excluir_projetos_admin.php?consulta_id=$id_projeto'>Excluir</a></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>" . htmlspecialchars("Nenhum projeto encontrado.", ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } catch(PDOException $e) {
        echo "<p>" . htmlspecialchars("Erro ao carregar projetos. Por favor, tente novamente.", ENT_QUOTES, 'UTF-8') . "</p>";
        error_log("Erro ao carregar projetos: " . $e->getMessage());
    }
    ?>


</div>


<div class="segunda">
    <!-- Seção para registrar um novo projeto -->
    <h3>Registrar Novo Projeto:</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <!-- Certifique-se de incluir um campo oculto para armazenar o ID do usuário -->
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <label for="data_criacao">Data de Criação:</label>
    <input type="date" id="data_criacao" name="data_criacao" required><br><br>

    <label for="tecnologia_associada">Tecnologia Associada:</label>
    <input type="text" id="tecnologia_associada" name="tecnologia_associada" required><br><br>

    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="marcado">Marcado</option>
        <option value="em_progresso">Em Progresso</option>
        <option value="terminado">Terminado</option>
    </select><br><br>

    <label for="user_image">Imagem do Projeto:</label>
    <input type="file" id="user_image" name="user_image" accept="image/*" required><br><br>

    <!-- Adicione campos adicionais conforme necessário -->

    <input id="botaoprojeto" type="submit" value="Registrar Projeto">
</form>

    <!-- Fim da seção de registro de projeto -->

    <!-- Seção para exibir projetos -->
</div>




</body>
</html>
