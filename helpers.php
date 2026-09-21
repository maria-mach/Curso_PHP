<?php
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function normalize_username(string $username): string {
    return strtolower(trim($username));
}

function valid_username(string $username): bool {
    return (bool)preg_match('/^[a-z0-9._-]{3,30}$/', $username);
}

function video_embed_html(string $url): string {
    $url = trim($url);
    if ($url === '') return '';

    if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
        $id = $m[1];
        return '<div class="video-wrap"><iframe src="https://www.youtube.com/embed/' . e($id) . '" title="Videoaula" allowfullscreen></iframe></div>';
    }

    if (preg_match('~\.mp4(?:\?.*)?$~i', $url)) {
        return '<video class="video-player" controls src="' . e($url) . '"></video>';
    }

    return '<p><a class="button" href="' . e($url) . '" target="_blank" rel="noopener">Abrir videoaula</a></p>';
}

function student_week_status(PDO $pdo, int $userId, int $weekNo): array {
    $stmt = $pdo->prepare('SELECT completed, quiz_score, completed_at FROM progress WHERE user_id = ? AND week_no = ?');
    $stmt->execute([$userId, $weekNo]);
    $row = $stmt->fetch();
    return $row ?: ['completed' => 0, 'quiz_score' => null, 'completed_at' => null];
}

function can_access_week(PDO $pdo, int $userId, array $week): bool {
    if ((int)$week['is_released'] !== 1 || trim((string)$week['video_url']) === '') return false;
    $n = (int)$week['week_no'];
    if ($n === 1) return true;
    $prev = student_week_status($pdo, $userId, $n - 1);
    return (int)$prev['completed'] === 1;
}

function completed_count(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM progress WHERE user_id = ? AND completed = 1');
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}
