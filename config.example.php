<?php
/**
 * Ficheiro de Configuração da Base de Dados - EXEMPLO
 *
 * INSTRUÇÕES:
 * 1. Copie este ficheiro para "config.php"
 * 2. Preencha com as suas credenciais reais
 * 3. NUNCA faça commit do ficheiro config.php para o Git
 */

// Configurações da Base de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_auth');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configurações da Aplicação
define('APP_ENV', 'development'); // 'development' ou 'production'
define('APP_DEBUG', true);

// Configurações de Sessão
define('SESSION_LIFETIME', 3600); // 1 hora em segundos
?>
