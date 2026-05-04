<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? 'EventHub UK';
$active = $active ?? '';
$user = current_user();
$basePath = $basePath ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EventHub UK - discover and book professional events across the UK">
    <title><?= e($pageTitle) ?></title>
    <link rel="shortcut icon" href="<?= e($basePath) ?>img/logo.png" type="image/x-icon">
    <link rel="icon" href="<?= e($basePath) ?>img/logo.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($basePath) ?>static/css/home.css">
    <link rel="stylesheet" href="<?= e($basePath) ?>static/css/app.css">
    <?= $pageStyles ?? '' ?>
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <a href="<?= e($basePath) ?>index.php" class="logo">
                <img src="<?= e($basePath) ?>img/logo.png" alt="EventHub Logo">
                <span>EventHub</span>
            </a>
            <ul class="nav-menu">
                <li><a class="<?= $active === 'home' ? 'active' : '' ?>" href="<?= e($basePath) ?>index.php">Home</a></li>
                <li><a class="<?= $active === 'events' ? 'active' : '' ?>" href="<?= e($basePath) ?>events.php">Events</a></li>
                <li><a class="<?= $active === 'support' ? 'active' : '' ?>" href="<?= e($basePath) ?>support.php">Support</a></li>
                <li><a class="<?= $active === 'contact' ? 'active' : '' ?>" href="<?= e($basePath) ?>contact.php">Contact</a></li>
                <?php if ($user): ?>
                    <li><a href="<?= e($basePath) ?><?= $user['role'] === 'admin' ? 'admin/dashboard.php' : 'client/dashboard.php' ?>"><?= e($user['full_name']) ?></a></li>
                    <li><a href="<?= e($basePath) ?>logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= e($basePath) ?>login.php">Login</a></li>
                <?php endif; ?>
                <li><a href="<?= e($basePath) ?>events.php" class="cta-button">Book Now</a></li>
            </ul>
        </nav>
    </header>
