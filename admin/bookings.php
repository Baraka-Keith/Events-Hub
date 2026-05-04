<?php
$adminTitle = 'Bookings - EventHub UK';
$adminActive = 'bookings';
require __DIR__ . '/_admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('UPDATE bookings SET status = :status WHERE id = :id');
    $stmt->execute([
        'status' => $_POST['status'],
        'id' => (int) $_POST['booking_id'],
    ]);
    flash('success', 'Booking status updated.');
    redirect('bookings.php');
}

$bookings = db()->query(
    'SELECT b.*, e.title, t.ticket_type
     FROM bookings b
     JOIN events e ON e.id = b.event_id
     JOIN tickets t ON t.id = b.ticket_id
     ORDER BY b.created_at DESC'
)->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>Booking Management</h1>
        <p>Bookings are now real records created through the public booking form.</p>
    </div>
</div>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="table-card">
    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Attendee</th>
                <th>Event</th>
                <th>Ticket</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= e($booking['booking_reference']) ?></td>
                <td><?= e($booking['full_name']) ?><br><small><?= e($booking['email']) ?></small></td>
                <td><?= e($booking['title']) ?></td>
                <td><?= e($booking['ticket_type']) ?></td>
                <td><?= (int) $booking['quantity'] ?></td>
                <td><?= money($booking['total_amount']) ?></td>
                <td><?= e(str_replace('_', ' ', $booking['payment_method'])) ?><br><small><?= e(str_replace('_', ' ', $booking['payment_status'])) ?></small></td>
                <td><span class="status <?= e($booking['status']) ?>"><?= e($booking['status']) ?></span></td>
                <td>
                    <form method="post" class="actions">
                        <input type="hidden" name="booking_id" value="<?= (int) $booking['id'] ?>">
                        <select name="status">
                            <?php foreach (['pending', 'confirmed', 'needs_review', 'cancelled'] as $status): ?>
                                <option value="<?= $status ?>" <?= $booking['status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>
