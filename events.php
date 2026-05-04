<?php
require_once __DIR__ . '/includes/data.php';

$category = $_GET['category'] ?? '';
$location = $_GET['location'] ?? '';
$search = trim($_GET['search'] ?? '');
$events = all_events($category ?: null, $location ?: null, $search ?: null);
$pageTitle = 'Browse Events - EventHub UK';
$active = 'events';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <h1>Browse Events</h1>
    <p>Filter real event records by category, city, or keyword and continue into the booking journey.</p>
</section>

<main class="page-shell">
    <form class="filters-panel" method="get">
        <input type="search" name="search" value="<?= e($search) ?>" placeholder="Search events">
        <select name="category">
            <option value="">All Categories</option>
            <?php foreach (categories() as $item): ?>
                <option value="<?= e($item) ?>" <?= $category === $item ? 'selected' : '' ?>><?= e($item) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="location">
            <option value="">All Locations</option>
            <?php foreach (locations() as $item): ?>
                <option value="<?= e($item) ?>" <?= $location === $item ? 'selected' : '' ?>><?= e($item) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="cta-button" type="submit">Apply Filters</button>
    </form>

    <div class="events-grid">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <div class="event-image">
                    <span class="event-category"><?= e($event['category']) ?></span>
                    <img src="<?= e($event['image_path']) ?>" alt="<?= e($event['title']) ?>">
                </div>
                <div class="event-details">
                    <h3><?= e($event['title']) ?></h3>
                    <div class="event-meta">
                        <span><i class="fas fa-calendar"></i> <?= e(date('d M Y', strtotime($event['event_date']))) ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= e($event['city']) ?></span>
                    </div>
                    <p class="event-description"><?= e($event['summary']) ?></p>
                    <div class="event-footer">
                        <span class="event-price"><?= e($event['venue']) ?></span>
                        <a href="event.php?slug=<?= e($event['slug']) ?>" class="event-button">Learn More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!$events): ?>
        <div class="error-box">No events matched your filters. Try a wider search.</div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

