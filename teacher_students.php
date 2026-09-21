<?php
require __DIR__.'/auth.php'; require_teacher(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php';
$students=$pdo->query("SELECT id,name,username FROM users WHERE role='student' ORDER BY name")->fetchAll();page_header('Progresso dos alunos','teacher_students.php');
?>
<h1>Progresso dos alunos</h1><div style="overflow:auto"><table><thead><tr><th>Aluno</th><th>Usuário</th><?php for($i=1;$i<=8;$i++)echo '<th>S'.$i.'</th>';?><th>Progresso</th></tr></thead><tbody>
<?php foreach($students as $s):$c=0;echo '<tr><td>'.e($s['name']).'</td><td>'.e($s['username']).'</td>';for($i=1;$i<=8;$i++){ $st=student_week_status($pdo,(int)$s['id'],$i);$ok=(int)$st['completed']===1;$c+=$ok?1:0;echo '<td>'.($ok?'Concluída':'-').'</td>'; } echo '<td>'.(int)round(($c/8)*100).'%</td></tr>';endforeach;?>
</tbody></table></div><?php page_footer(); ?>
