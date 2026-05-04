<?php
require_once __DIR__ . '/../includes/auth.php';
require_login('admin');
$adminUser = current_user();
$adminTitle = $adminTitle ?? 'EventHub Admin';
$adminActive = $adminActive ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle) ?></title>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/admin.css">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand">
            <img src="../img/logo.png" alt="EventHub Logo">
            <div>
                <h2>EventHub Admin</h2>
                <small><?= e($adminUser['full_name']) ?></small>
            </div>
        </div>
        <nav class="side-nav">
            <a class="<?= $adminActive === 'dashboard' ? 'active' : '' ?>" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a class="<?= $adminActive === 'events' ? 'active' : '' ?>" href="events.php"><i class="fas fa-calendar-alt"></i> Events</a>
            <a class="<?= $adminActive === 'bookings' ? 'active' : '' ?>" href="bookings.php"><i class="fas fa-ticket-alt"></i> Bookings</a>
            <a class="<?= $adminActive === 'support' ? 'active' : '' ?>" href="support.php"><i class="fas fa-headset"></i> Support</a>
            <a class="<?= $adminActive === 'users' ? 'active' : '' ?>" href="users.php"><i class="fas fa-users"></i> Users</a>
            <a class="<?= $adminActive === 'emails' ? 'active' : '' ?>" href="emails.php"><i class="fas fa-envelope"></i> Email Outbox</a>
            <a href="../index.php"><i class="fas fa-globe"></i> Public Site</a>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
        <div class="sidebar-note">Manage events, bookings, support conversations, users, and customer email records from one workspace.</div>
    </aside>
    <main class="main">
