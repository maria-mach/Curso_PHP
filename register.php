<?php
session_start();
require __DIR__.'/db.php';
require __DIR__.'/helpers.php';
$msg='';$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');$username=normalize_username($_POST['username']??'');$password=$_POST['password']??'';
    if($name===''||!valid_username($username)||strlen($password)<6){$err='Preencha nome completo, usuário com 3 a 30 caracteres e senha com pelo menos 6 caracteres.';}
    else{
        try{
            $stmt=$pdo->prepare('INSERT INTO users(name,username,password_hash,role) VALUES(?,?,?,\'student\')');
            $stmt->execute([$name,$username,password_hash($password,PASSWORD_DEFAULT)]);
            $msg='Cadastro realizado. Agora você já pode entrar.';
        }catch(PDOException $e){$err='Este usuário já está cadastrado.';}
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Cadastro</title><link rel="stylesheet" href="assets/style.css"></head><body><div class="login-wrap"><div class="card login-card"><h1>Cadastro do aluno</h1><?php if($msg):?><div class="notice ok"><?=e($msg)?></div><?php endif;?><?php if($err):?><div class="notice warn"><?=e($err)?></div><?php endif;?>
<form method="post"><div class="field"><label>Nome completo</label><input name="name" autocomplete="name" required></div><div class="field"><label>Usuário</label><input name="username" autocomplete="username" minlength="3" maxlength="30" pattern="[a-z0-9._-]{3,30}" required><small class="muted">Use letras minúsculas, números, ponto, hífen ou underline.</small></div><div class="field"><label>Senha</label><input type="password" name="password" autocomplete="new-password" minlength="6" required></div><button>Cadastrar</button> <a class="button secondary" href="login.php">Voltar</a></form></div></div></body></html>
