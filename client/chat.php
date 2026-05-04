<?php
require_once __DIR__ . '/../includes/auth.php';
require_login('client');
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'new') {
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $supportType = trim($_POST['support_type'] ?? 'General Enquiry');

        if ($subject !== '' && $message !== '') {
            $stmt = db()->prepare(
                'INSERT INTO support_requests (full_name, email, support_type, subject, message, status)
                 VALUES (:full_name, :email, :support_type, :subject, :message, "open")'
            );
            $stmt->execute([
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'support_type' => $supportType,
                'subject' => $subject,
                'message' => $message,
            ]);
            $requestId = (int) db()->lastInsertId();

            $stmt = db()->prepare(
                'INSERT INTO support_messages (support_request_id, sender_role, sender_name, message)
                 VALUES (:support_request_id, "client", :sender_name, :message)'
            );
            $stmt->execute([
                'support_request_id' => $requestId,
                'sender_name' => $user['full_name'],
                'message' => $message,
            ]);

            flash('success', 'Support chat started.');
            redirect('chat.php?request_id=' . $requestId);
        }
    }

    if ($action === 'reply') {
        $requestId = (int) ($_POST['request_id'] ?? 0);
        $message = trim($_POST['message'] ?? '');

        $stmt = db()->prepare('SELECT id FROM support_requests WHERE id = :id AND email = :email');
        $stmt->execute(['id' => $requestId, 'email' => $user['email']]);
        $request = $stmt->fetch();

        if ($request && $message !== '') {
            db()->prepare('UPDATE support_requests SET status = "in_progress" WHERE id = :id')->execute(['id' => $requestId]);
            $stmt = db()->prepare(
                'INSERT INTO support_messages (support_request_id, sender_role, sender_name, message)
                 VALUES (:support_request_id, "client", :sender_name, :message)'
            );
            $stmt->execute([
                'support_request_id' => $requestId,
                'sender_name' => $user['full_name'],
                'message' => $message,
            ]);
            flash('success', 'Message sent to support.');
            redirect('chat.php?request_id=' . $requestId);
        }
    }
}

$stmt = db()->prepare('SELECT * FROM support_requests WHERE email = :email ORDER BY created_at DESC');
$stmt->execute(['email' => $user['email']]);
$requests = $stmt->fetchAll();

$selectedRequestId = (int) ($_GET['request_id'] ?? ($requests[0]['id'] ?? 0));
$selectedRequest = null;
$messages = [];

if ($selectedRequestId > 0) {
    $stmt = db()->prepare('SELECT * FROM support_requests WHERE id = :id AND email = :email');
    $stmt->execute(['id' => $selectedRequestId, 'email' => $user['email']]);
    $selectedRequest = $stmt->fetch() ?: null;

    if ($selectedRequest) {
        $stmt = db()->prepare('SELECT * FROM support_messages WHERE support_request_id = :id ORDER BY created_at ASC');
        $stmt->execute(['id' => $selectedRequestId]);
        $messages = $stmt->fetchAll();
    }
}

$pageTitle = 'Support Chat - EventHub UK';
$basePath = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
    <h1>Support Chat</h1>
    <p>Start a support request and continue the conversation with the EventHub team.</p>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<main class="page-shell">
    <div class="chat-layout">
        <aside class="details-panel">
            <h2>My Requests</h2>
            <div class="request-list">
                <?php foreach ($requests as $request): ?>
                    <a class="request-link <?= (int) $request['id'] === $selectedRequestId ? 'active' : '' ?>" href="chat.php?request_id=<?= (int) $request['id'] ?>">
                        <strong><?= e($request['subject']) ?></strong>
                        <span><?= e(str_replace('_', ' ', $request['status'])) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <h2 style="margin-top: 2rem;">New Chat</h2>
            <form method="post">
                <input type="hidden" name="action" value="new">
                <div class="form-group">
                    <label for="support_type">Topic</label>
                    <select id="support_type" name="support_type">
                        <option>Booking Support</option>
                        <option>Accessibility Request</option>
                        <option>Payment Question</option>
                        <option>General Enquiry</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="new_message">Message</label>
                    <textarea id="new_message" name="message" rows="4" required></textarea>
                </div>
                <button class="cta-button" type="submit">Start Chat</button>
            </form>
        </aside>

        <section class="form-panel">
            <?php if ($selectedRequest): ?>
                <h2><?= e($selectedRequest['subject']) ?></h2>
                <p><span class="status-pill"><?= e(str_replace('_', ' ', $selectedRequest['status'])) ?></span></p>
                <div class="chat-thread">
                    <?php foreach ($messages as $chatMessage): ?>
                        <div class="chat-message <?= e($chatMessage['sender_role']) ?>">
                            <strong><?= e($chatMessage['sender_name']) ?></strong>
                            <small><?= e(date('d M Y H:i', strtotime($chatMessage['created_at']))) ?></small>
                            <p><?= e($chatMessage['message']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form method="post">
                    <input type="hidden" name="action" value="reply">
                    <input type="hidden" name="request_id" value="<?= (int) $selectedRequest['id'] ?>">
                    <div class="form-group">
                        <label for="reply_message">Reply</label>
                        <textarea id="reply_message" name="message" rows="4" required></textarea>
                    </div>
                    <button class="cta-button" type="submit">Send Message</button>
                </form>
            <?php else: ?>
                <h2>No Support Chat Selected</h2>
                <p>Start a new chat to contact support about bookings, accessibility, payments, or event information.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

