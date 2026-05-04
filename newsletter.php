<?php
require_once __DIR__ . '/includes/data.php';

$email = trim($_POST['email'] ?? '');

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = db()->prepare('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (:email)');
    $stmt->execute(['email' => $email]);
    flash('success', 'Newsletter subscription saved.');
}

redirect($_SERVER['HTTP_REFERER'] ?? 'index.php');

