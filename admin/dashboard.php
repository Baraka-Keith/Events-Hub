<?php
$adminTitle = 'Admin Dashboard - EventHub UK';
$adminActive = 'dashboard';
require __DIR__ . '/_admin_header.php';

$stats = admin_stats();
$bookings = db()->query(
    'SELECT b.booking_reference, b.full_name, b.status, b.total_amount, e.title
     FROM bookings b JOIN events e ON e.id = b.event_id
     ORDER BY b.created_at DESC LIMIT 5'
)->fetchAll();
$support = db()->query(
    'SELECT s.subject, s.support_type, s.status, s.created_at, e.title
     FROM support_requests s LEFT JOIN events e ON e.id = s.related_event_id
     ORDER BY s.created_at DESC LIMIT 5'
)->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>Dashboard</h1>
        <p>Live overview of EventHub events, bookings, revenue, and support workload.</p>
    </div>
    <a class="button secondary" href="../index.php">View Site</a>
</div>

<section class="stats-grid">
    <div class="stat-card"><h3>Total Events</h3><div class="value"><?= $stats['events'] ?></div></div>
    <div class="stat-card"><h3>Total Bookings</h3><div class="value"><?= $stats['bookings'] ?></div></div>
    <div class="stat-card"><h3>Revenue</h3><div class="value"><?= money($stats['revenue']) ?></div></div>
    <div class="stat-card"><h3>Open Support</h3><div class="value"><?= $stats['support'] ?></div></div>
</section>

<section class="grid-two">
    <div class="table-card">
        <h2>Recent Bookings</h2>
        <table>
            <thead><tr><th>Reference</th><th>Attendee</th><th>Event</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= e($booking['booking_reference']) ?></td>
                    <td><?= e($booking['full_name']) ?></td>
                    <td><?= e($booking['title']) ?></td>
                    <td><span class="status <?= e($booking['status']) ?>"><?= e($booking['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-card">
        <h2>Recent Support Requests</h2>
        <table>
            <thead><tr><th>Subject</th><th>Type</th><th>Related Event</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($support as $request): ?>
                <tr>
                    <td><?= e($request['subject']) ?></td>
                    <td><?= e($request['support_type']) ?></td>
                    <td><?= e($request['title'] ?? 'General') ?></td>
                    <td><span class="status <?= e($request['status']) ?>"><?= e($request['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>

