# Curso Desenvolvimento Web Full Stack — portal simples

Sistema em PHP + MySQL com dois perfis:
- Professor: publica o link do vídeo, libera/bloqueia semanas e acompanha o progresso.
- Aluno: acessa semanas em sequência, assiste ao vídeo, responde quiz e conclui.

## Regras implementadas
1. São 8 semanas.
2. O aluno não consegue concluir uma semana sem vídeo cadastrado.
3. A semana precisa estar liberada pelo professor.
4. Da semana 2 em diante, a semana anterior precisa estar concluída.
5. O aluno precisa responder todo o quiz e marcar que assistiu à videoaula.
6. O certificado de 40h só aparece quando 8/8 semanas estão concluídas.

## Dados coletados
Somente nome completo, usuário, senha protegida por hash, progresso, nota do quiz e data de conclusão.
Não há CPF, RG, endereço, telefone ou data de nascimento.

## Como hospedar em uma hospedagem PHP/MySQL
1. Contrate uma hospedagem que tenha PHP + MySQL e HTTPS/SSL.
2. No painel da hospedagem, crie um banco MySQL e um usuário de banco.
3. Abra o phpMyAdmin e importe `database.sql`.
4. Copie `config.example.php` para `config.php`.
5. Edite `config.php` e informe nome do banco, usuário e senha fornecidos pela hospedagem.
6. Envie todos os arquivos desta pasta para `public_html` (ou a pasta raiz do domínio).
7. Acesse o domínio no navegador.
8. Ative o HTTPS/SSL no painel da hospedagem.

## Login inicial do professor
- Usuário: `professor`
- Senha: `Professor@123`

Troque a senha do professor no banco depois da primeira instalação, ou substitua o hash no SQL antes de importar.

## Atualização de banco antigo
Se você já importou uma versão anterior que usava e-mail no login, execute `migration_email_to_username.sql` uma vez no phpMyAdmin antes de usar a nova tela de login.

## Como publicar uma videoaula
Professor > Semanas > cole um link do YouTube (ou MP4) > marque “Liberar para os alunos” > Salvar.

## Como o progresso funciona
- O professor publica e libera a semana.
- O aluno acessa a semana.
- O aluno assiste ao vídeo, responde o quiz e confirma que assistiu.
- Ao concluir, a próxima semana pode ser liberada (desde que o professor já tenha publicado e liberado o vídeo).

## Segurança básica já incluída
- `password_hash()` / `password_verify()`.
- PDO com consultas preparadas.
- Sessões para controle de login.
- Separação de perfil professor/aluno.
- Escapamento de saídas HTML.

## Recomendações para produção
- Use HTTPS.
- Troque a senha inicial do professor.
- Faça backup periódico do banco.
- Não colete dados pessoais além do necessário.
