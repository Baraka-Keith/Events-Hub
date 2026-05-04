<?php
require_once __DIR__ . '/includes/data.php';

$events = array_slice(all_events(), 0, 3);
$pageTitle = 'EventHub UK - Professional Event Booking';
$active = 'home';
require __DIR__ . '/includes/header.php';
?>

<?php if ($message = flash('success')): ?>
    <div class="notice"><?= e($message) ?></div>
<?php endif; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Discover Professional Events Across the UK</h1>
        <p>Search, compare, and book conferences, workshops, and networking events through a database-backed booking platform.</p>
        <a href="events.php" class="cta-button">Explore Events</a>
    </div>
</section>

<section class="featured-events">
    <div class="section-title">
        <h2>Featured Events</h2>
        <p>Live event records loaded from the EventHub MySQL database.</p>
    </div>

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
                        <span class="event-price">Database Event</span>
                        <a href="event.php?slug=<?= e($event['slug']) ?>" class="event-button">Learn More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="about-section" id="about-us">
    <div class="about-container">
        <div class="about-image floating">
            <img src="img/main.jpg" alt="Professional event attendees">
        </div>
        <div class="about-content">
            <h2>Plan, Book, and Manage Events With Confidence</h2>
            <p>EventHub connects attendees with curated UK events through searchable listings, clear ticket options, secure account access, booking records, support conversations, and responsive event management tools.</p>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?= count(all_events()) ?></div>
                    <div class="stat-label">Live Events</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Booking Access</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">Live</div>
                    <div class="stat-label">Support Chat</div>
                </div>
            </div>
            <a href="events.php" class="cta-button">Find an Event</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
