<?php
require_once __DIR__ . '/../includes/auth.php';
require_login('client');
$user = current_user();

$stmt = db()->prepare(
    'SELECT b.*, e.title, e.slug, e.event_date, e.venue, e.city, t.ticket_type
     FROM bookings b
     JOIN events e ON e.id = b.event_id
     JOIN tickets t ON t.id = b.ticket_id
     WHERE b.email = :email
     ORDER BY b.created_at DESC'
);
$stmt->execute(['email' => $user['email']]);
$bookings = $stmt->fetchAll();

$pageTitle = 'Client Dashboard - EventHub UK';
$basePath = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
    <h1>Client Dashboard</h1>
    <p>Welcome back, <?= e($user['full_name']) ?>. View your booking history and continue using EventHub.</p>
</section>

<main class="page-shell">
    <div class="admin-link-row" style="margin-bottom: 1.5rem;">
        <a class="cta-button" href="../events.php">Browse Events</a>
        <a class="cta-button" href="chat.php">Support Chat</a>
        <a class="cta-button" href="../support.php">Support Form</a>
        <a class="cta-button" href="../logout.php">Logout</a>
    </div>

    <section class="table-panel">
        <h2>My Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Ticket</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= e($booking['booking_reference']) ?></td>
                    <td><a href="../event.php?slug=<?= e($booking['slug']) ?>"><?= e($booking['title']) ?></a></td>
                    <td><?= e(date('d M Y', strtotime($booking['event_date']))) ?></td>
                    <td><?= e($booking['ticket_type']) ?> x <?= (int) $booking['quantity'] ?></td>
                    <td><?= money($booking['total_amount']) ?></td>
                    <td><?= e(str_replace('_', ' ', $booking['payment_method'])) ?></td>
                    <td><span class="status-pill"><?= e($booking['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (!$bookings): ?>
            <p>No bookings found for this account yet. Make a booking using the same email address to see it here.</p>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
