<?php
declare(strict_types=1);

require_once __DIR__ . '/data.php';

function current_user(): ?array
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    return $_SESSION['user'] ?? null;
}

function login_user(array $user): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'full_name' => $user['full_name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
}

function logout_user(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION = [];
    session_destroy();
}

function require_login(?string $role = null): void
{
    $user = current_user();

    if (!$user) {
        redirect('../login.php');
    }

    if ($role !== null && $user['role'] !== $role) {
        redirect('../login.php');
    }
}

function redirect_for_role(array $user): never
{
    if ($user['role'] === 'admin') {
        redirect('admin/dashboard.php');
    }

    redirect('client/dashboard.php');
}

