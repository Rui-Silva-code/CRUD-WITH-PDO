<?php
session_start();

// Ligação à base de dados
include 'basedados.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de login
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    try {
        // Consulta para verificar as credenciais do usuário (PDO)
        $sql = "SELECT user_id, password, user_type FROM utilizadores WHERE user_name = :user_name";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();
        
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
        die("Erro na consulta SQL: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Página de Login</title>
    <style>
       body{
margin: 0px 250px; 
background: rgb(255,216,130);
background: linear-gradient(90deg, rgba(255,216,130,1) 5%, rgba(171,232,252,1) 28%, rgba(163,255,167,1) 67%, rgba(255,165,165,1) 94%); 
text-align: center;
}
form{
    text-align: left;
    margin-left: 600px;
}
#password{
    width: 240px;
}
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($login_error)) {
        echo '<p class="error-message">' . $login_error . '</p>';
    }
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="user_name">Nome de Utilizador:</label>
        <input type="text" id="user_name" name="user_name" required><br><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Entrar">
    </form>
    <p>Não está registado? <a href="pagina_de_registro.html">Registe-se aqui</a></p>
</body>
</html>