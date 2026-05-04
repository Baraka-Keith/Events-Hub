<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function all_events(?string $category = null, ?string $location = null, ?string $search = null): array
{
    $sql = 'SELECT * FROM events WHERE status = "published"';
    $params = [];

    if ($category) {
        $sql .= ' AND category = :category';
        $params['category'] = $category;
    }

    if ($location) {
        $sql .= ' AND city = :location';
        $params['location'] = $location;
    }

    if ($search) {
        $sql .= ' AND (title LIKE :search OR summary LIKE :search OR description LIKE :search)';
        $params['search'] = '%' . $search . '%';
    }

    $sql .= ' ORDER BY event_date ASC, start_time ASC';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function event_by_slug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM events WHERE slug = :slug LIMIT 1');
    $stmt->execute(['slug' => $slug]);
    $event = $stmt->fetch();

    return $event ?: null;
}

function event_tickets(int $eventId): array
{
    $stmt = db()->prepare('SELECT * FROM tickets WHERE event_id = :event_id ORDER BY price ASC');
    $stmt->execute(['event_id' => $eventId]);

    return $stmt->fetchAll();
}

function categories(): array
{
    return db()->query('SELECT DISTINCT category FROM events WHERE status = "published" ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
}

function locations(): array
{
    return db()->query('SELECT DISTINCT city FROM events WHERE status = "published" ORDER BY city')->fetchAll(PDO::FETCH_COLUMN);
}

function admin_stats(): array
{
    return [
        'events' => (int) db()->query('SELECT COUNT(*) FROM events')->fetchColumn(),
        'bookings' => (int) db()->query('SELECT COUNT(*) FROM bookings')->fetchColumn(),
        'revenue' => (float) db()->query('SELECT COALESCE(SUM(total_amount), 0) FROM bookings WHERE status != "cancelled"')->fetchColumn(),
        'support' => (int) db()->query('SELECT COUNT(*) FROM support_requests WHERE status IN ("open", "in_progress")')->fetchColumn(),
    ];
}

