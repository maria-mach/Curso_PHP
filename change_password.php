<?php
require __DIR__.'/auth.php'; require_login(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';

$msg='';$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $current=$_POST['current_password']??'';
    $new=$_POST['new_password']??'';
    $confirm=$_POST['confirm_password']??'';

    $stmt=$pdo->prepare('SELECT password_hash FROM users WHERE id=? LIMIT 1');
    $stmt->execute([(int)$_SESSION['user']['id']]);
    $user=$stmt->fetch();

    if(!$user||!password_verify($current,$user['password_hash'])){
        $err='Senha atual incorreta.';
    }elseif(strlen($new)<6){
        $err='A nova senha precisa ter pelo menos 6 caracteres.';
    }elseif($new!==$confirm){
        $err='A confirmação da senha não confere.';
    }else{
        $update=$pdo->prepare('UPDATE users SET password_hash=? WHERE id=?');
        $update->execute([password_hash($new,PASSWORD_DEFAULT),(int)$_SESSION['user']['id']]);
        $msg='Senha alterada com sucesso.';
    }
}

page_header('Alterar senha','change_password.php');
?>
<h1>Alterar senha</h1>
<p class="muted">Use esta tela para manter seu acesso seguro sem informar dados pessoais.</p>
<?php if($msg):?><div class="notice ok"><?=e($msg)?></div><?php endif;?>
<?php if($err):?><div class="notice warn"><?=e($err)?></div><?php endif;?>
<form method="post" class="card" style="max-width:520px">
    <div class="field"><label>Senha atual</label><input type="password" name="current_password" autocomplete="current-password" required></div>
    <div class="field"><label>Nova senha</label><input type="password" name="new_password" autocomplete="new-password" minlength="6" required></div>
    <div class="field"><label>Confirmar nova senha</label><input type="password" name="confirm_password" autocomplete="new-password" minlength="6" required></div>
    <button>Salvar nova senha</button>
</form>
<?php page_footer(); ?>
