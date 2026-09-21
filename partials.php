<?php
function page_header(string $title, string $active = ''): void {
    $user = $_SESSION['user'] ?? null;
    $role = $user['role'] ?? '';
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).'</title><link rel="stylesheet" href="assets/style.css"></head><body>';
    echo '<header class="topbar"><strong>Curso Full Stack · 40h</strong><nav>';
    if ($user) echo '<span>'.e($user['name']).'</span> <a href="logout.php">Sair</a>';
    echo '</nav></header><div class="layout"><aside class="sidebar">';
    if ($role === 'teacher') {
        $links = [['teacher.php','Painel'],['teacher_weeks.php','Semanas'],['teacher_students.php','Progresso'],['change_password.php','Senha']];
    } else {
        $links = [['student.php','Início'],['project.php','Projeto Integrador'],['certificate.php','Certificado'],['change_password.php','Senha']];
    }
    foreach ($links as [$href,$label]) {
        $cls = $active === $href ? 'active' : '';
        echo '<a class="'.$cls.'" href="'.$href.'">'.e($label).'</a>';
    }
    echo '</aside><main class="main">';
}
function page_footer(): void { echo '</main></div></body></html>'; }
