<?php
$adminTitle = 'Users - EventHub UK';
$adminActive = 'users';
require __DIR__ . '/_admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'client';

    if ($fullName !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6 && in_array($role, ['admin', 'client'], true)) {
        $stmt = db()->prepare(
            'INSERT INTO users (full_name, email, password_hash, role)
             VALUES (:full_name, :email, :password_hash, :role)'
        );
        $stmt->execute([
            'full_name' => $fullName,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);
        flash('success', 'User account created.');
        redirect('users.php');
    }

    flash('success', 'User was not created. Check all fields and use a unique email.');
    redirect('users.php');
}

$users = db()->query(
    'SELECT u.*,
        (SELECT COUNT(*) FROM bookings b WHERE b.email = u.email) AS booking_count
     FROM users u
     ORDER BY u.role ASC, u.created_at DESC'
)->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>User Management</h1>
        <p>Review admin/client accounts and create demo users for role-based testing.</p>
    </div>
</div>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="form-card" style="margin-bottom: 1.5rem;">
    <h2>Add User</h2>
    <form method="post">
        <div class="form-grid">
            <div class="form-group"><label>Full Name</label><input name="full_name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" minlength="6" required></div>
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="client">client</option>
                    <option value="admin">admin</option>
                </select>
            </div>
        </div>
        <button type="submit">Create User</button>
    </form>
</section>

<section class="table-card">
    <h2>User List</h2>
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Bookings</th><th>Created</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e($user['full_name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td><span class="status"><?= e($user['role']) ?></span></td>
                <td><span class="status <?= e($user['status']) ?>"><?= e($user['status']) ?></span></td>
                <td><?= (int) $user['booking_count'] ?></td>
                <td><?= e(date('d M Y', strtotime($user['created_at']))) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>

