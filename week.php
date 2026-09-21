<?php
require __DIR__.'/auth.php'; require_student(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$uid=(int)$_SESSION['user']['id'];$n=max(1,min(8,(int)($_GET['n']??1)));
$stmt=$pdo->prepare('SELECT * FROM weeks WHERE week_no=?');$stmt->execute([$n]);$week=$stmt->fetch();
if(!$week){http_response_code(404);exit('Semana não encontrada.');}
$status=student_week_status($pdo,$uid,$n);$can=can_access_week($pdo,$uid,$week);
if(!$can && !(int)$status['completed']){page_header('Semana bloqueada');echo '<div class="notice warn"><h2>Semana bloqueada</h2><p>Esta semana ainda não pode ser concluída. Aguarde o professor publicar/liberar a videoaula e conclua a semana anterior.</p></div>';page_footer();exit;}
$quiz=$pdo->prepare('SELECT * FROM quiz_questions WHERE week_no=? ORDER BY id');$quiz->execute([$n]);$questions=$quiz->fetchAll();
$msg='';$err='';
if($_SERVER['REQUEST_METHOD']==='POST' && !(int)$status['completed']){
    $confirmed=isset($_POST['watched']) ? 1 : 0;
    if(!$confirmed){$err='Marque a confirmação de que assistiu à videoaula.';}
    elseif(count($questions)>0){
        $score=0;$answered=0;
        foreach($questions as $q){$key='q'.$q['id']; if(isset($_POST[$key])){$answered++; if($_POST[$key]===$q['correct_option'])$score++;}}
        if($answered<count($questions)){$err='Responda todas as perguntas do quiz.';}
        else{
            $percent=(int)round(($score/count($questions))*100);
            $ins=$pdo->prepare('INSERT INTO progress(user_id,week_no,video_confirmed,quiz_score,completed,completed_at) VALUES(?,?,?,?,1,NOW()) ON DUPLICATE KEY UPDATE video_confirmed=VALUES(video_confirmed),quiz_score=VALUES(quiz_score),completed=1,completed_at=NOW()');
            $ins->execute([$uid,$n,1,$percent]);$msg="Semana concluída. Resultado do quiz: {$percent}%";$status=student_week_status($pdo,$uid,$n);
        }
    }
}
page_header('Semana '.$n);
?>
<h1>Semana <?=$n?> · <?=e($week['title'])?></h1><p class="muted"><?=e($week['summary'])?></p>
<?php if($msg):?><div class="notice ok"><?=e($msg)?></div><?php endif;?><?php if($err):?><div class="notice warn"><?=e($err)?></div><?php endif;?>
<div class="card"><h2>🎥 Videoaula</h2><?=video_embed_html($week['video_url'])?></div>
<div class="card content-card" style="margin-top:16px"><h2>Material de estudo</h2><?=$week['content_html']?></div>
<?php if(!(int)$status['completed']): ?>
<form method="post" class="card" style="margin-top:16px"><h2>Quiz</h2>
<?php foreach($questions as $i=>$q):?><div class="quiz-q"><strong><?=($i+1)?>. <?=e($q['question'])?></strong><?php foreach(['A','B','C','D'] as $opt): $col='option_'.strtolower($opt);?><label style="display:block;margin-top:8px;font-weight:400"><input style="width:auto" type="radio" name="q<?=$q['id']?>" value="<?=$opt?>" required> <?=e($q[$col])?></label><?php endforeach;?></div><?php endforeach;?>
<div class="field" style="margin-top:16px"><label style="font-weight:400"><input style="width:auto" type="checkbox" name="watched" required> Confirmo que assisti à videoaula desta semana.</label></div>
<button>Concluir semana</button></form>
<?php else:?><div class="notice ok" style="margin-top:16px">✅ Semana concluída. Nota do quiz: <?=e((string)$status['quiz_score'])?>%</div><?php endif;?>
<?php page_footer(); ?>
