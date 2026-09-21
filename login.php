<?php
session_start();
require __DIR__.'/db.php';
require __DIR__.'/helpers.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = normalize_username($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id,name,username,password_hash,role FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id'=>(int)$user['id'],'name'=>$user['name'],'username'=>$user['username'],'role'=>$user['role']];
        header('Location: '.($user['role']==='teacher'?'teacher.php':'student.php'));
        exit;
    }
    $error = 'Usuário ou senha inválidos.';
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Entrar</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="login-wrap"><div class="card login-card"><h1>Curso Full Stack</h1><p class="muted">Entre para acessar as aulas.</p>
<?php if($error): ?><div class="notice warn"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="field"><label>Usuário</label><input name="username" autocomplete="username" required></div><div class="field"><label>Senha</label><input type="password" name="password" autocomplete="current-password" required></div><button>Entrar</button></form>
<p class="muted" style="margin-top:16px">Ainda não tem acesso? <a href="register.php">Cadastre-se como aluno</a>.</p></div></div></body></html>
