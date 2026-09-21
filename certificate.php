<?php
require __DIR__.'/auth.php'; require_student(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$uid=(int)$_SESSION['user']['id'];$count=completed_count($pdo,$uid);page_header('Certificado','certificate.php');
if($count<8){echo '<div class="notice warn"><h2>Certificado ainda bloqueado</h2><p>Conclua as 8 semanas para liberar o certificado. Progresso atual: '.$count.'/8.</p></div>';page_footer();exit;}
$code='FSTACK-'.date('Y').'-'.str_pad((string)$uid,5,'0',STR_PAD_LEFT);
?>
<div class="certificate card"><h1>Certificado de Conclusão</h1><p>Certificamos que</p><h2><?=e($_SESSION['user']['name'])?></h2><p>concluiu o curso</p><h2>Desenvolvimento Web Full Stack</h2><p>na modalidade EaD assíncrona, com carga horária total de <strong>40 horas</strong>.</p><p>Data de emissão: <?=date('d/m/Y')?></p><p class="muted">Código: <?=e($code)?></p></div><p class="no-print"><button onclick="window.print()">Imprimir / Salvar em PDF</button></p>
<?php page_footer(); ?>
