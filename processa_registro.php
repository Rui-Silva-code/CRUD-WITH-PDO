<?php
// Ligação à base de dados
include 'basedados.php';

// Obter dados do formulário
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$raw_password = $_POST['password']; // Password before hashing

// Hashing the password
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// Consulta para inserir um novo registro na tabela utilizadores (PDO)
$sql = "INSERT INTO utilizadores (nome, apelido, user_name, email, password, user_type) VALUES (:nome, :apelido, :user_name, :email, :password, 'utilizador')";

try {
    $stmt = $conn->prepare($sql);
    
    // PDO: bind com nomes
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':apelido', $apelido);
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    
    $stmt->execute();
    
    // Redireciona para a página de login após o registro bem-sucedido
    header("Location: login.php");
    exit();
    
} catch(PDOException $e) {
    // Erro de email duplicado
    if ($e->getCode() == 23000) {
        echo "Erro: O endereço de e-mail já está em uso. Por favor, escolha outro.";
    } else {
        echo "Erro ao registar: " . $e->getMessage();
    }
}
?>