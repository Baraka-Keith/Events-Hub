<?php
$adminTitle = 'Support Chat - EventHub UK';
$adminActive = 'support';
require __DIR__ . '/_admin_header.php';

$requestId = (int) ($_GET['request_id'] ?? $_POST['request_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    if ($requestId > 0 && $message !== '') {
        $stmt = db()->prepare(
            'INSERT INTO support_messages (support_request_id, sender_role, sender_name, message)
             VALUES (:support_request_id, "admin", :sender_name, :message)'
        );
        $stmt->execute([
            'support_request_id' => $requestId,
            'sender_name' => current_user()['full_name'],
            'message' => $message,
        ]);
        db()->prepare('UPDATE support_requests SET status = "in_progress" WHERE id = :id')->execute(['id' => $requestId]);
        flash('success', 'Reply sent to client chat.');
        redirect('support_chat.php?request_id=' . $requestId);
    }
}

$stmt = db()->prepare('SELECT * FROM support_requests WHERE id = :id');
$stmt->execute(['id' => $requestId]);
$request = $stmt->fetch();

if (!$request) {
    echo '<div class="error-box">Support request not found.</div>';
    require __DIR__ . '/_admin_footer.php';
    exit;
}

$stmt = db()->prepare('SELECT * FROM support_messages WHERE support_request_id = :id ORDER BY created_at ASC');
$stmt->execute(['id' => $requestId]);
$messages = $stmt->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>Support Chat</h1>
        <p>Reply directly to the client support conversation.</p>
    </div>
    <a class="button secondary" href="support.php">Back to Support</a>
</div>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="panel">
    <h2><?= e($request['subject']) ?></h2>
    <p><?= e($request['full_name']) ?> &lt;<?= e($request['email']) ?>&gt;</p>
    <p><span class="status <?= e($request['status']) ?>"><?= e(str_replace('_', ' ', $request['status'])) ?></span></p>
    <div class="chat-thread admin-thread">
        <?php foreach ($messages as $chatMessage): ?>
            <div class="chat-message <?= e($chatMessage['sender_role']) ?>">
                <strong><?= e($chatMessage['sender_name']) ?></strong>
                <small><?= e(date('d M Y H:i', strtotime($chatMessage['created_at']))) ?></small>
                <p><?= e($chatMessage['message']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <form method="post">
        <input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>">
        <div class="form-group">
            <label for="message">Admin Reply</label>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit">Send Reply</button>
    </form>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>

