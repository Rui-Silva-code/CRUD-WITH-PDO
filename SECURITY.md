# 🔒 Guia de Segurança

## Dados Sensíveis Protegidos

Este projeto protege os seguintes dados sensíveis através do `.gitignore`:

### 1. Credenciais da Base de Dados
- ❌ `config.php` - Contém username, password e nome da BD
- ✅ `config.example.php` - Ficheiro de exemplo (SEM credenciais reais)

### 2. Ficheiros SQL
- ❌ `*.sql` - Podem conter dados de utilizadores e estrutura da BD
- ❌ `*.sql.gz` - Backups comprimidos
- ❌ `*.sql.zip` - Backups zipados

### 3. Uploads de Utilizadores
- ❌ `imagens/*` - Fotos de perfil e imagens de projetos
- ❌ `uploads/*` - Outros uploads

### 4. Screenshots
- ❌ `screenshots/*` - Podem conter dados sensíveis visíveis

### 5. Ficheiros de Sistema
- ❌ `.DS_Store` (macOS)
- ❌ `Thumbs.db` (Windows)
- ❌ Ficheiros temporários (*.tmp, *.temp)

### 6. Logs
- ❌ `*.log` - Podem conter informações sensíveis
- ❌ `error_log`
- ❌ `php_errors.log`

## ✅ Como Configurar o Projeto (Desenvolvimento)

### Passo 1: Clonar o Repositório
```bash
git clone <url-do-repositorio>
cd crud-auth
```

### Passo 2: Copiar Ficheiro de Configuração
```bash
cp config.example.php config.php
```

### Passo 3: Editar config.php
Abra `config.php` e configure:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_auth');
define('DB_USER', 'root');      // Seu username
define('DB_PASS', '');          // Sua password
```

### Passo 4: Criar Base de Dados
```sql
CREATE DATABASE crud_auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Passo 5: Criar Pastas Necessárias
```bash
mkdir -p imagens uploads screenshots
chmod 755 imagens uploads screenshots
```

## 🚨 Checklist Antes de Fazer Commit

Antes de fazer `git add` e `git commit`, verifique:

- [ ] Não adicionou `config.php`
- [ ] Não adicionou ficheiros `*.sql`
- [ ] Não adicionou pasta `imagens/` com conteúdo
- [ ] Não adicionou ficheiros `.env`
- [ ] Não adicionou ficheiros de log
- [ ] Verificou se `.gitignore` está correto

### Comando Seguro
```bash
# Ver ficheiros que serão commitados
git status

# Ver se há ficheiros sensíveis
git status | grep -E "(config.php|\.sql|imagens/|\.env|\.log)"

# Se aparecer algo suspeito, NÃO faça commit!
```

## 🔐 Produção

### Mudanças Necessárias para Produção:

1. **config.php**
```php
define('APP_ENV', 'production');
define('APP_DEBUG', false);
```

2. **Permissões de Pastas**
```bash
chmod 750 imagens/
chmod 750 uploads/
chmod 640 config.php
```

3. **PHP Configuration (php.ini)**
```ini
display_errors = Off
log_errors = On
error_log = /path/to/php-errors.log
```

4. **Apache/Nginx**
- Ativar HTTPS (SSL/TLS)
- Configurar headers de segurança
- Desativar listagem de diretórios

5. **Base de Dados**
- Criar utilizador específico (não usar root)
- Dar apenas permissões necessárias
- Usar password forte

## 🛡️ Boas Práticas

### Nunca:
- ❌ Fazer commit de credenciais
- ❌ Fazer commit de ficheiros SQL com dados
- ❌ Fazer commit de uploads de utilizadores
- ❌ Deixar `display_errors = On` em produção
- ❌ Usar `root` em produção

### Sempre:
- ✅ Usar `.gitignore`
- ✅ Usar prepared statements
- ✅ Usar password hashing
- ✅ Validar inputs
- ✅ Escapar outputs
- ✅ Usar HTTPS em produção
- ✅ Fazer backups regulares
- ✅ Manter PHP e MySQL atualizados

## 📝 Rotação de Credenciais

Se acidentalmente fez commit de credenciais:

1. **Remover do histórico do Git:**
```bash
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch config.php" \
  --prune-empty --tag-name-filter cat -- --all
```

2. **Forçar push:**
```bash
git push origin --force --all
```

3. **IMPORTANTE:** Mudar TODAS as passwords!
- Password da BD
- Passwords de utilizadores
- Qualquer outra credencial exposta

## 🆘 Em Caso de Exposição

Se dados sensíveis foram expostos:

1. **Avaliar o Impacto**
   - Que dados foram expostos?
   - Por quanto tempo estiveram expostos?
   - Quem teve acesso?

2. **Ação Imediata**
   - Mudar todas as passwords
   - Revogar tokens/chaves de API
   - Notificar utilizadores afetados (RGPD)

3. **Remedição**
   - Limpar histórico do Git
   - Implementar rotação de credenciais
   - Adicionar monitorização

4. **Prevenção**
   - Revisar `.gitignore`
   - Implementar pre-commit hooks
   - Fazer code review

## 📞 Contacto

Para reportar problemas de segurança: [seu-email@exemplo.com]

---

**Última atualização:** 2026-02-06
