<?php
require_once __DIR__ . '/includes/data.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if ($subject === '' || $message === '') {
        $errors[] = 'Subject and message are required.';
    }

    if (!$errors) {
        $stmt = db()->prepare(
            'INSERT INTO contact_messages (full_name, email, phone, subject, message)
             VALUES (:full_name, :email, :phone, :subject, :message)'
        );
        $stmt->execute([
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone ?: null,
            'subject' => $subject,
            'message' => $message,
        ]);
        flash('success', 'Your message has been saved. The team can review it in the admin dashboard.');
        redirect('contact.php');
    }
}

$pageTitle = 'Contact EventHub UK';
$active = 'contact';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <h1>Contact EventHub</h1>
    <p>Send a message to the team. Submissions are stored in the database for review.</p>
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
                    <input id="email" type="email" name="email" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject" required>
                </div>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="7" required></textarea>
            </div>
            <button class="cta-button" type="submit">Send Message</button>
        </form>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

