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
        $sql = "SELECT user_id, password, user_type FROM utilizadores WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_name]);
        $row = $stmt->fetch();

        if ($row) {
            // Verificar a senha usando password_verify
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id']; // Defina a variável de sessão após a autenticação bem-sucedida

                if ($row['user_type'] === 'utilizador') {
                    header("Location: perfil_utilizador.php"); // Redireciona para o perfil do utilizador
                } elseif ($row['user_type'] === 'administrador') {
                    header("Location: perfil_admin.php"); // Redireciona para o perfil do administrador
                } else {
                    $login_error = "Papel desconhecido.";
                }

                exit();
            } else {
                $login_error = "Nome de utilizador ou senha incorretos.";
            }
        } else {
            $login_error = "Nome de utilizador ou senha incorretos.";
        }
    } catch(PDOException $e) {
        $login_error = "Erro no sistema. Por favor, tente novamente.";
        error_log("Erro de login: " . $e->getMessage());
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de login e registo de utilizadores</title>
    <style>

body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
}

.primeira{
  width: 100%;
  height: 100px;
  text-align: center;

  
}

.segunda{
  width:49%;
  height: 200px;
  float: left;
}

#imagem1{
  border-radius:50%;
  height: 300px;
}

.terceira{
  width:40%;
  height: 400px;
  float: right;
  

}

#user-name, #password{
  height: 25px;
  width: 200px;
}

#botao{
  width: 70px;
  height: 30px;
}

#conta1{

float: right;
}



    </style>
  </head>
  <body>

  <div class="primeira">

  <h1>BEM-VINDO</h1>

</div>

  <div class="segunda">


  <img src="imagens/entrada.jpg" id="imagem1" alt="" width="100%" height="auto">
</div>

<div class="terceira">


  <h2>Inicie a sessão para continuar:</h2>

      <?php
      if (isset($login_error)) {
          echo '<p class="error-message">' . htmlspecialchars($login_error, ENT_QUOTES, 'UTF-8') . '</p>';
      }
      ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      
      <div>
      Nome de Utilizador:<br>
        <input type="text" class="user-name" id="user-name" name="user_name" required aria-describedby="emailHelp" >
      </div>
      <br>
      <div>
      Palavra-chave:<br>
        <input type="password" class="password" id="password" name="password" required>
      </div>
      <br>

      <button type="submit" id="botao">Entrar</button>

      <p id="conta">Não tem conta? <a id="registo" href="pagina_de_registro.html" style="font-weight:bold">Registar-se</a></p>
<br>
      <p id="conta1"><a id="registo" href="homepage.php">Continuar sem Sessão
      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 256 512">
      <path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/>
      </svg></a></p>


    </form>
    

</div>

  </body>
</html>