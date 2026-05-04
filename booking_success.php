<?php
require_once __DIR__ . '/includes/data.php';

$reference = $_GET['ref'] ?? '';
$stmt = db()->prepare(
    'SELECT b.*, e.title, e.slug, e.event_date, e.venue, e.city, t.ticket_type
     FROM bookings b
     JOIN events e ON e.id = b.event_id
     JOIN tickets t ON t.id = b.ticket_id
     WHERE b.booking_reference = :reference'
);
$stmt->execute(['reference' => $reference]);
$booking = $stmt->fetch();

$pageTitle = 'Booking Confirmation - EventHub UK';
require __DIR__ . '/includes/header.php';
?>

<main class="page-shell" style="padding-top: 7rem;">
    <?php if ($booking): ?>
        <section class="details-panel">
            <span class="status-pill">Confirmed</span>
            <h1>Booking Confirmed</h1>
            <p>Your booking is confirmed and your ticket confirmation has been prepared for email delivery.</p>
            <div class="meta-list">
                <div><strong>Reference</strong><span><?= e($booking['booking_reference']) ?></span></div>
                <div><strong>Event</strong><span><?= e($booking['title']) ?></span></div>
                <div><strong>Ticket</strong><span><?= e($booking['ticket_type']) ?> x <?= (int) $booking['quantity'] ?></span></div>
                <div><strong>Total</strong><span><?= money($booking['total_amount']) ?></span></div>
                <div><strong>Payment</strong><span><?= e(str_replace('_', ' ', $booking['payment_method'])) ?> - <?= e(str_replace('_', ' ', $booking['payment_status'])) ?></span></div>
                <div><strong>Date</strong><span><?= e(date('d M Y', strtotime($booking['event_date']))) ?></span></div>
                <div><strong>Venue</strong><span><?= e($booking['venue']) ?>, <?= e($booking['city']) ?></span></div>
            </div>
            <div class="admin-link-row">
                <a class="cta-button" href="events.php">Browse More Events</a>
                <a class="cta-button" href="admin/bookings.php">View Admin Bookings</a>
            </div>
        </section>
    <?php else: ?>
        <div class="error-box">Booking reference not found.</div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
