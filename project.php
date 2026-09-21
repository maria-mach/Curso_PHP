<?php
require __DIR__.'/auth.php'; require_student(); require __DIR__.'/db.php'; require __DIR__.'/helpers.php'; require __DIR__.'/partials.php'; page_header('Projeto Integrador','project.php');
?>
<h1>Projeto Final Integrador</h1><div class="card"><p>Ao longo das 8 semanas, você construirá progressivamente uma aplicação web Full Stack envolvendo front-end, PHP, banco de dados MySQL, CRUD, autenticação e integração com API REST.</p><p class="muted">A proposta segue o plano do curso: reaproveitar o mesmo projeto-base, mantendo continuidade entre as semanas.</p></div>
<div class="grid" style="margin-top:16px"><?php
$steps=[
1=>'Criar a estrutura HTML da página, aplicar estilos básicos com CSS e entender o papel do JavaScript.',
2=>'Praticar variáveis, operadores, condicionais, repetições e eventos simples em JavaScript.',
3=>'Versionar o projeto com Git/GitHub e configurar o primeiro código PHP no ambiente local.',
4=>'Aplicar fundamentos PHP: operadores, condicionais, repetição, arrays, funções e formulários.',
5=>'Trabalhar GET/POST, validação, sessões e criar as primeiras tabelas no MySQL.',
6=>'Conectar PHP ao MySQL e construir o CRUD: Create, Read, Update e Delete.',
7=>'Consolidar CRUD e implementar autenticação, login, sessão e controle de acesso.',
8=>'Criar ou consumir API REST, integrar front-end e back-end, revisar a aplicação e finalizar a entrega.'
]; foreach($steps as $n=>$txt){echo '<div class="card"><span class="badge">Semana '.$n.'</span><p>'.e($txt).'</p></div>';} ?>
</div><?php page_footer(); ?>
