<?php
$adminTitle = 'Manage Events - EventHub UK';
$adminActive = 'events';
require __DIR__ . '/_admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'delete') {
        $eventId = (int) ($_POST['event_id'] ?? 0);
        $stmt = db()->prepare('SELECT COUNT(*) FROM bookings WHERE event_id = :event_id');
        $stmt->execute(['event_id' => $eventId]);
        $bookingCount = (int) $stmt->fetchColumn();

        if ($bookingCount > 0) {
            db()->prepare('UPDATE events SET status = "closed" WHERE id = :id')->execute(['id' => $eventId]);
            flash('success', 'This event has bookings, so it was closed instead of permanently deleted.');
        } else {
            db()->prepare('DELETE FROM events WHERE id = :id')->execute(['id' => $eventId]);
            flash('success', 'Event deleted from the database.');
        }

        redirect('events.php');
    }

    $title = trim($_POST['title'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));

    if ($title !== '') {
        $stmt = db()->prepare(
            'INSERT INTO events (title, slug, category, city, venue, event_date, start_time, end_time, capacity, image_path, summary, description, business_need, status)
             VALUES (:title, :slug, :category, :city, :venue, :event_date, :start_time, :end_time, :capacity, :image_path, :summary, :description, :business_need, :status)'
        );
        $stmt->execute([
            'title' => $title,
            'slug' => $slug . '-' . random_int(10, 99),
            'category' => trim($_POST['category'] ?? 'Business'),
            'city' => trim($_POST['city'] ?? 'London'),
            'venue' => trim($_POST['venue'] ?? 'EventHub Venue'),
            'event_date' => $_POST['event_date'] ?: date('Y-m-d'),
            'start_time' => $_POST['start_time'] ?: '09:00',
            'end_time' => $_POST['end_time'] ?: '17:00',
            'capacity' => (int) ($_POST['capacity'] ?: 100),
            'image_path' => trim($_POST['image_path'] ?? 'img/main.jpg'),
            'summary' => trim($_POST['summary'] ?? 'New EventHub event.'),
            'description' => trim($_POST['description'] ?? 'Detailed event description to be completed.'),
            'business_need' => trim($_POST['business_need'] ?? 'Supports professional networking and skills development.'),
            'status' => $_POST['status'] ?? 'draft',
        ]);
        flash('success', 'Event added to the database.');
        redirect('events.php');
    }
}

$events = db()->query('SELECT * FROM events ORDER BY event_date DESC')->fetchAll();
?>

<div class="topbar">
    <div>
        <h1>Manage Events</h1>
        <p>Add and review database-backed event records used by the public site.</p>
    </div>
</div>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="form-card" style="margin-bottom: 1.5rem;">
    <h2>Add Event</h2>
    <form method="post">
        <div class="form-grid">
            <div class="form-group"><label>Title</label><input name="title" required></div>
            <div class="form-group"><label>Category</label><input name="category" value="Technology"></div>
            <div class="form-group"><label>City</label><input name="city" value="London"></div>
            <div class="form-group"><label>Venue</label><input name="venue" value="EventHub Conference Centre"></div>
            <div class="form-group"><label>Date</label><input type="date" name="event_date" required></div>
            <div class="form-group"><label>Capacity</label><input type="number" name="capacity" value="100"></div>
            <div class="form-group"><label>Start Time</label><input type="time" name="start_time" value="09:00"></div>
            <div class="form-group"><label>End Time</label><input type="time" name="end_time" value="17:00"></div>
        </div>
        <div class="form-group"><label>Image Path</label><input name="image_path" value="img/main.jpg"></div>
        <div class="form-group"><label>Summary</label><input name="summary" required></div>
        <div class="form-group"><label>Description</label><textarea name="description" rows="4" required></textarea></div>
        <div class="form-group"><label>Business Need</label><textarea name="business_need" rows="3" required></textarea></div>
        <div class="form-group">
            <label>Status</label>
            <select name="status"><option value="published">published</option><option value="draft">draft</option><option value="closed">closed</option></select>
        </div>
        <button type="submit">Add Event</button>
    </form>
</section>

<section class="table-card">
    <h2>Event Records</h2>
    <table>
        <thead><tr><th>Title</th><th>Category</th><th>City</th><th>Date</th><th>Capacity</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= e($event['title']) ?></td>
                <td><?= e($event['category']) ?></td>
                <td><?= e($event['city']) ?></td>
                <td><?= e(date('d M Y', strtotime($event['event_date']))) ?></td>
                <td><?= (int) $event['capacity'] ?></td>
                <td><span class="status <?= e($event['status']) ?>"><?= e($event['status']) ?></span></td>
                <td>
                    <div class="actions">
                        <a class="button secondary" href="../event.php?slug=<?= e($event['slug']) ?>">View</a>
                        <form method="post" onsubmit="return confirm('Delete this event? If bookings exist, it will be closed instead.');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="event_id" value="<?= (int) $event['id'] ?>">
                            <button class="danger" type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require __DIR__ . '/_admin_footer.php'; ?>
