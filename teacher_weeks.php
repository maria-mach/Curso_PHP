<?php
require __DIR__.'/auth.php'; require_teacher(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $week=(int)($_POST['week_no']??0);$url=trim($_POST['video_url']??'');$release=isset($_POST['is_released'])?1:0;
    if($week>=1&&$week<=8){$stmt=$pdo->prepare('UPDATE weeks SET video_url=?, is_released=? WHERE week_no=?');$stmt->execute([$url,$release,$week]);$msg='Semana atualizada.';}
}
$weeks=$pdo->query('SELECT * FROM weeks ORDER BY week_no')->fetchAll();page_header('Gerenciar semanas','teacher_weeks.php');
?>
<h1>Gerenciar semanas</h1><?php if($msg):?><div class="notice ok"><?=e($msg)?></div><?php endif;?>
<div class="grid"><?php foreach($weeks as $w):?><form method="post" class="card"><input type="hidden" name="week_no" value="<?=(int)$w['week_no']?>"><span class="badge">Semana <?=(int)$w['week_no']?></span><h3><?=e($w['title'])?></h3><div class="field"><label>Link do vídeo (YouTube ou MP4)</label><input name="video_url" value="<?=e($w['video_url'])?>" placeholder="https://..."></div><label style="font-weight:400"><input style="width:auto" type="checkbox" name="is_released" <?=(int)$w['is_released']===1?'checked':''?>> Liberar para os alunos</label><br><br><button>Salvar</button></form><?php endforeach;?></div>
<?php page_footer(); ?>
