<?php
require __DIR__.'/auth.php'; require_student(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$uid=(int)$_SESSION['user']['id'];
$weeks=$pdo->query('SELECT * FROM weeks ORDER BY week_no')->fetchAll();
$count=completed_count($pdo,$uid);$pct=(int)round(($count/8)*100);
page_header('Meu curso','student.php');
?>
<h1>Meu curso</h1><p class="muted">8 semanas · 40 horas · 1 videoaula por semana</p>
<div class="card"><h3>Seu progresso</h3><div class="progress"><span style="width:<?=$pct?>%"></span></div><p><strong><?=$pct?>%</strong> · <?=$count?> de 8 semanas concluídas</p></div>
<div class="grid" style="margin-top:16px">
<?php foreach($weeks as $w): $st=student_week_status($pdo,$uid,(int)$w['week_no']); $can=can_access_week($pdo,$uid,$w); ?>
<div class="card"><span class="badge <?=((int)$st['completed']===1?'ok':($can?'':'lock'))?>">Semana <?= (int)$w['week_no'] ?></span><h3><?=e($w['title'])?></h3><p class="muted"><?=e($w['summary'])?></p>
<?php if((int)$st['completed']===1): ?><p><span class="badge ok">Concluída</span></p><a class="button secondary" href="week.php?n=<?=(int)$w['week_no']?>">Revisar</a>
<?php elseif($can): ?><a class="button" href="week.php?n=<?=(int)$w['week_no']?>">Acessar semana</a>
<?php else: ?><p><span class="badge lock">Bloqueada</span></p><small class="muted">Libera quando o professor publicar o vídeo e, a partir da semana 2, quando a anterior estiver concluída.</small>
<?php endif; ?></div><?php endforeach; ?>
</div>
<?php page_footer(); ?>
