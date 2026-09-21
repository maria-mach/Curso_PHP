<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function require_login(): void {
    if (empty($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function require_teacher(): void {
    require_login();
    if (($_SESSION['user']['role'] ?? '') !== 'teacher') {
        http_response_code(403);
        exit('Acesso restrito ao professor.');
    }
}

function require_student(): void {
    require_login();
    if (($_SESSION['user']['role'] ?? '') !== 'student') {
        http_response_code(403);
        exit('Acesso restrito ao aluno.');
    }
}
