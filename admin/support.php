<?php
$adminTitle = 'Support Requests - EventHub UK';
$adminActive = 'support';
require __DIR__ . '/_admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('UPDATE support_requests SET status = :status WHERE id = :id');
    $stmt->execute([
        'status' => $_POST['status'],
        'id' => (int) $_POST['support_id'],
    ]);
    flash('success', 'Support request updated.');
    redirect('support.php');
}

$requests = db()->query(
    'SELECT s.*, e.title
     FROM support_requests s
     LEFT JOIN events e ON e.id = s.related_event_id
     ORDER BY s.created_at DESC'
)->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>Support Requests</h1>
        <p>Support form submissions are stored here for review and status tracking.</p>
    </div>
</div>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="table-card">
    <table>
        <thead>
            <tr>
                <th>Requester</th>
                <th>Type</th>
                <th>Related Event</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?= e($request['full_name']) ?><br><small><?= e($request['email']) ?></small></td>
                <td><?= e($request['support_type']) ?></td>
                <td><?= e($request['title'] ?? 'General') ?></td>
                <td><?= e($request['subject']) ?></td>
                <td><?= e($request['message']) ?></td>
                <td><span class="status <?= e($request['status']) ?>"><?= e($request['status']) ?></span></td>
                <td>
                    <form method="post" class="actions">
                        <input type="hidden" name="support_id" value="<?= (int) $request['id'] ?>">
                        <select name="status">
                            <?php foreach (['open', 'in_progress', 'resolved'] as $status): ?>
                                <option value="<?= $status ?>" <?= $request['status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Save</button>
                    </form>
                    <div style="margin-top: 0.5rem;">
                        <a class="button secondary" href="support_chat.php?request_id=<?= (int) $request['id'] ?>">Chat</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>
