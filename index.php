<?php
session_start();
if (!empty($_SESSION['user'])) {
    header('Location: ' . ($_SESSION['user']['role'] === 'teacher' ? 'teacher.php' : 'student.php'));
} else {
    header('Location: login.php');
}
exit;
