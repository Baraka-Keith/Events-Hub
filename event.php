<?php
require_once __DIR__ . '/includes/data.php';

$slug = $_GET['slug'] ?? '';
$event = event_by_slug($slug);

if (!$event) {
    http_response_code(404);
    $pageTitle = 'Event Not Found - EventHub UK';
    require __DIR__ . '/includes/header.php';
    echo '<main class="page-shell"><div class="error-box">Event not found.</div><a class="cta-button" href="events.php">Back to Events</a></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$tickets = event_tickets((int) $event['id']);
$pageTitle = $event['title'] . ' - EventHub UK';
$active = 'events';
require __DIR__ . '/includes/header.php';
?>

<main class="page-shell" style="padding-top: 7rem;">
    <div class="detail-grid">
        <section>
            <img class="detail-image" src="<?= e($event['image_path']) ?>" alt="<?= e($event['title']) ?>">
        </section>

        <section class="details-panel">
            <span class="status-pill"><?= e($event['category']) ?></span>
            <h1><?= e($event['title']) ?></h1>
            <p><?= e($event['description']) ?></p>
            <div class="meta-list">
                <div><strong>Date</strong><span><?= e(date('d M Y', strtotime($event['event_date']))) ?></span></div>
                <div><strong>Time</strong><span><?= e(substr($event['start_time'], 0, 5)) ?> - <?= e(substr($event['end_time'], 0, 5)) ?></span></div>
                <div><strong>Venue</strong><span><?= e($event['venue']) ?>, <?= e($event['city']) ?></span></div>
                <div><strong>Capacity</strong><span><?= e((string) $event['capacity']) ?> attendees</span></div>
            </div>
            <h2>Business Need</h2>
            <p><?= e($event['business_need']) ?></p>
            <a class="cta-button" href="booking.php?event_id=<?= (int) $event['id'] ?>">Book Your Ticket</a>
        </section>
    </div>

    <section class="details-panel" style="margin-top: 2rem;">
        <h2>Ticket Options</h2>
        <?php foreach ($tickets as $ticket): ?>
            <div class="ticket-option">
                <div>
                    <strong><?= e($ticket['ticket_type']) ?></strong>
                    <p><?= e($ticket['access_description']) ?></p>
                </div>
                <strong><?= money($ticket['price']) ?></strong>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

