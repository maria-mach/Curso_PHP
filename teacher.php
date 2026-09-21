<?php
require __DIR__.'/auth.php'; require_teacher(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$students=(int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='student'")->fetchColumn();$released=(int)$pdo->query("SELECT COUNT(*) FROM weeks WHERE is_released=1 AND video_url<>''")->fetchColumn();
page_header('Painel do professor','teacher.php');
?>
<h1>Painel do professor</h1><div class="grid"><div class="card"><h3>Alunos</h3><p style="font-size:32px;margin:8px 0"><?=$students?></p></div><div class="card"><h3>Semanas publicadas</h3><p style="font-size:32px;margin:8px 0"><?=$released?>/8</p></div></div>
<div class="card" style="margin-top:16px"><h2>Como funciona</h2><p>1. Cadastre o link da videoaula da semana.</p><p>2. Marque a semana como <strong>liberada</strong>.</p><p>3. O aluno só consegue concluir se a semana estiver liberada, houver vídeo publicado, ele responder todo o quiz e confirmar que assistiu.</p><p>4. Da semana 2 em diante, a anterior também precisa estar concluída.</p></div>
<?php page_footer(); ?>
