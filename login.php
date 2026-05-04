<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/email.php';

$errors = [];
$verificationCode = null;
$pendingUser = null;

if (current_user()) {
    redirect_for_role(current_user());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['step'] ?? '') === 'verify') {
        $pendingUserId = (int) ($_SESSION['pending_login_user_id'] ?? 0);
        $code = trim($_POST['code'] ?? '');

        $stmt = db()->prepare(
            'SELECT c.*, u.full_name, u.email, u.role, u.status
             FROM login_verification_codes c
             JOIN users u ON u.id = c.user_id
             WHERE c.user_id = :user_id AND c.used_at IS NULL AND c.expires_at >= NOW()
             ORDER BY c.created_at DESC LIMIT 1'
        );
        $stmt->execute(['user_id' => $pendingUserId]);
        $record = $stmt->fetch();

        if ($record && password_verify($code, $record['code_hash'])) {
            db()->prepare('UPDATE login_verification_codes SET used_at = NOW() WHERE id = :id')->execute(['id' => $record['id']]);
            unset($_SESSION['pending_login_user_id'], $_SESSION['demo_login_code'], $_SESSION['flash']);
            login_user($record);
            redirect_for_role($record);
        }

        $errors[] = 'Verification failed. Please enter the latest login code.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = db()->prepare('SELECT * FROM users WHERE email = :email AND status = "active" LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $verificationCode = (string) random_int(100000, 999999);
            $stmt = db()->prepare(
                'INSERT INTO login_verification_codes (user_id, code_hash, expires_at)
                 VALUES (:user_id, :code_hash, DATE_ADD(NOW(), INTERVAL 10 MINUTE))'
            );
            $stmt->execute([
                'user_id' => $user['id'],
                'code_hash' => password_hash($verificationCode, PASSWORD_DEFAULT),
            ]);
            queue_email(
                $user['email'],
                $user['full_name'],
                'Your EventHub UK login code',
                "Hello {$user['full_name']},\n\nYour EventHub UK login code is {$verificationCode}.\n\nThis code expires in 10 minutes.\n\nEventHub UK",
                'login_code',
                null,
                (int) $user['id']
            );
            $_SESSION['pending_login_user_id'] = (int) $user['id'];
            $_SESSION['demo_login_code'] = $verificationCode;
            $pendingUser = $user;
        } else {
            $errors[] = 'Login failed. Check the email, password, and database import.';
        }
    }
}

if (!$pendingUser && isset($_SESSION['pending_login_user_id'])) {
    $stmt = db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => (int) $_SESSION['pending_login_user_id']]);
    $pendingUser = $stmt->fetch() ?: null;
    $verificationCode = $_SESSION['demo_login_code'] ?? null;
}

$pageTitle = 'Login - EventHub UK';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <h1>Login</h1>
    <p>Use the demo admin or client account to access role-based pages.</p>
</section>

<main class="page-shell">
    <?php foreach ($errors as $error): ?>
        <div class="error-box"><?= e($error) ?></div>
    <?php endforeach; ?>

    <div class="booking-grid">
        <section class="form-panel">
            <?php if ($pendingUser): ?>
                <h2>Enter Login Code</h2>
                <p>A verification code has been generated for <?= e($pendingUser['email']) ?>.</p>
                <div class="notice" style="margin: 1rem 0;">
                    Demo code: <?= e($verificationCode) ?>
                </div>
                <form method="post">
                    <input type="hidden" name="step" value="verify">
                    <div class="form-group">
                        <label for="code">Six Digit Code</label>
                        <input id="code" name="code" inputmode="numeric" maxlength="6" required>
                    </div>
                    <button class="cta-button" type="submit">Verify and Continue</button>
                </form>
            <?php else: ?>
                <h2>Account Login</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <button class="cta-button" type="submit">Login</button>
                </form>
            <?php endif; ?>
        </section>

        <section class="details-panel">
            <h2>Demo Accounts</h2>
            <div class="meta-list">
                <div><strong>Admin</strong><span>admin@eventhub.test</span></div>
                <div><strong>Password</strong><span>admin123</span></div>
                <div><strong>Client</strong><span>client@eventhub.test</span></div>
                <div><strong>Password</strong><span>client123</span></div>
            </div>
            <p>The admin account opens the management dashboard. The client account opens a customer dashboard with booking history and support links.</p>
        </section>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
