<?php
require_once __DIR__ . '/includes/data.php';

$events = all_events();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $supportType = trim($_POST['support_type'] ?? '');
    $relatedEventId = $_POST['related_event_id'] !== '' ? (int) $_POST['related_event_id'] : null;
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($fullName === '' || $supportType === '' || $subject === '' || $message === '') {
        $errors[] = 'Please complete all required support fields.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (!$errors) {
        $stmt = db()->prepare(
            'INSERT INTO support_requests (full_name, email, support_type, related_event_id, subject, message)
             VALUES (:full_name, :email, :support_type, :related_event_id, :subject, :message)'
        );
        $stmt->execute([
            'full_name' => $fullName,
            'email' => $email,
            'support_type' => $supportType,
            'related_event_id' => $relatedEventId,
            'subject' => $subject,
            'message' => $message,
        ]);
        flash('success', 'Support request submitted and stored in the admin support queue.');
        redirect('support.php');
    }
}

$pageTitle = 'Support - EventHub UK';
$active = 'support';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <h1>Support Centre</h1>
    <p>Submit booking, accessibility, event, or general support requests directly into the database.</p>
</section>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<main class="page-shell">
    <?php foreach ($errors as $error): ?>
        <div class="error-box"><?= e($error) ?></div>
    <?php endforeach; ?>

    <section class="form-panel">
        <form method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="support_type">Support Topic</label>
                    <select id="support_type" name="support_type" required>
                        <option value="Booking Support">Booking Support</option>
                        <option value="Accessibility Request">Accessibility Request</option>
                        <option value="Event Information">Event Information</option>
                        <option value="General Enquiry">General Enquiry</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="related_event_id">Related Event</label>
                    <select id="related_event_id" name="related_event_id">
                        <option value="">Not Event Specific</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= (int) $event['id'] ?>"><?= e($event['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="7" required></textarea>
            </div>
            <button class="cta-button" type="submit">Submit Request</button>
        </form>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

