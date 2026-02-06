# Sistema CRUD com Autenticação PHP

Sistema de gestão de utilizadores, consultas e projetos com autenticação segura.

## 🔒 Segurança

Este projeto implementa:
- ✅ PDO Prepared Statements (proteção contra SQL Injection)
- ✅ Password Hashing com `password_hash()`
- ✅ Proteção XSS com `htmlspecialchars()`
- ✅ Tratamento de erros com try-catch
- ✅ Encoding UTF-8

## 📋 Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor Apache (XAMPP, WAMP, etc.)

## 🚀 Instalação

### 1. Clonar o Repositório

```bash
git clone <url-do-repositorio>
cd crud-auth
```

### 2. Configurar a Base de Dados

1. Copie o ficheiro de configuração:
```bash
cp config.example.php config.php
```

2. Edite `config.php` com as suas credenciais da base de dados:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_auth');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

3. Importe o schema da base de dados (se disponível):
```bash
mysql -u root -p crud_auth < schema.sql
```

### 3. Configurar Permissões

Certifique-se que as pastas de upload têm permissões de escrita:
```bash
chmod 755 imagens/
```

### 4. Aceder à Aplicação

Abra no navegador: `http://localhost/crud-auth/`

## 📁 Estrutura do Projeto

```
crud-auth/
├── config.php              # Configurações (NÃO commitado)
├── config.example.php      # Exemplo de configurações
├── basedados.php          # Conexão PDO
├── index.php              # Página de login
├── logout.php             # Logout seguro
├── perfil_utilizador.php  # Perfil de utilizador
├── perfil_admin.php       # Perfil de administrador
├── imagens/               # Uploads de imagens (NÃO commitado)
└── .gitignore             # Ficheiros ignorados pelo Git
```

## ⚠️ IMPORTANTE - Dados Sensíveis

**NUNCA faça commit dos seguintes ficheiros:**
- ❌ `config.php` - Contém credenciais
- ❌ `*.sql` - Podem conter dados sensíveis
- ❌ `imagens/` - Uploads de utilizadores
- ❌ `.env` - Variáveis de ambiente

Estes ficheiros estão protegidos pelo `.gitignore`.

## 🔐 Credenciais de Desenvolvimento

Para ambiente de desenvolvimento, use:
- **Username:** (a definir após instalação)
- **Password:** (a definir após instalação)

## 📝 Funcionalidades

### Utilizador Normal
- ✅ Registar conta
- ✅ Login/Logout
- ✅ Ver perfil
- ✅ Editar perfil
- ✅ Marcar consultas
- ✅ Editar consultas (até 3 dias antes)
- ✅ Cancelar consultas

### Administrador
- ✅ Todas as funcionalidades de utilizador
- ✅ Gerir utilizadores
- ✅ Gerir consultas de todos os utilizadores
- ✅ Gerir projetos
- ✅ Ver dashboard

## 🛠️ Tecnologias

- **Backend:** PHP 7.4+
- **Base de Dados:** MySQL com PDO
- **Frontend:** HTML5, CSS3
- **Segurança:** Password Hashing, Prepared Statements, XSS Protection

## 📄 Licença

Este projeto é open source.

## 👥 Contribuir

Contribuições são bem-vindas! Por favor:
1. Faça fork do projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

## 🐛 Reportar Bugs

Encontrou um bug? Por favor abra uma issue no GitHub.

---

**Nota de Segurança:** Este é um projeto educacional. Para uso em produção, considere implementar:
- HTTPS obrigatório
- Rate limiting
- CSRF tokens
- 2FA (autenticação de dois fatores)
- Logs de auditoria
