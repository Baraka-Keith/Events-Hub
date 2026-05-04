<?php
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/email.php';

$eventId = (int) ($_GET['event_id'] ?? $_POST['event_id'] ?? 0);
$event = null;

if ($eventId > 0) {
    $stmt = db()->prepare('SELECT * FROM events WHERE id = :id');
    $stmt->execute(['id' => $eventId]);
    $event = $stmt->fetch();
}

if (!$event) {
    redirect('events.php');
}

$tickets = event_tickets((int) $event['id']);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketId = (int) ($_POST['ticket_id'] ?? 0);
    $quantity = max(1, min(10, (int) ($_POST['quantity'] ?? 1)));
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $organisation = trim($_POST['organisation'] ?? '');
    $paymentMethod = $_POST['payment_method'] ?? 'card';
    $notes = trim($_POST['notes'] ?? '');
    $allowedPaymentMethods = ['apple_pay', 'card', 'paypal', 'bank_transfer', 'pay_at_door'];

    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    $ticket = null;
    foreach ($tickets as $item) {
        if ((int) $item['id'] === $ticketId) {
            $ticket = $item;
            break;
        }
    }

    if (!$ticket) {
        $errors[] = 'Please choose a valid ticket type.';
    }
    if (!in_array($paymentMethod, $allowedPaymentMethods, true)) {
        $errors[] = 'Please choose a valid payment method.';
    }

    if (!$errors && $ticket) {
        $reference = 'BK-' . date('ymd') . '-' . random_int(100, 999);
        $total = (float) $ticket['price'] * $quantity;

        $stmt = db()->prepare(
            'INSERT INTO bookings (booking_reference, event_id, ticket_id, full_name, email, phone, organisation, quantity, total_amount, payment_method, payment_status, notes)
             VALUES (:reference, :event_id, :ticket_id, :full_name, :email, :phone, :organisation, :quantity, :total_amount, :payment_method, "demo_authorised", :notes)'
        );
        $stmt->execute([
            'reference' => $reference,
            'event_id' => $event['id'],
            'ticket_id' => $ticketId,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone ?: null,
            'organisation' => $organisation ?: null,
            'quantity' => $quantity,
            'total_amount' => $total,
            'payment_method' => $paymentMethod,
            'notes' => $notes ?: null,
        ]);
        $bookingId = (int) db()->lastInsertId();
        $booking = [
            'booking_reference' => $reference,
            'full_name' => $fullName,
            'quantity' => $quantity,
            'total_amount' => $total,
            'payment_method' => $paymentMethod,
            'payment_status' => 'demo_authorised',
        ];
        queue_email(
            $email,
            $fullName,
            'Your EventHub UK ticket: ' . $event['title'],
            ticket_email_body($booking, $event, $ticket),
            'ticket_confirmation',
            $bookingId,
            null
        );

        flash('success', 'Booking confirmed. Reference: ' . $reference . '. A ticket email has been queued in the admin email outbox.');
        redirect('booking_success.php?ref=' . urlencode($reference));
    }
}

$pageTitle = 'Book ' . $event['title'] . ' - EventHub UK';
$active = 'events';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <h1>Book Your Place</h1>
    <p>Your booking will be stored in the MySQL database and shown in the admin dashboard.</p>
</section>

<main class="page-shell">
    <?php foreach ($errors as $error): ?>
        <div class="error-box"><?= e($error) ?></div>
    <?php endforeach; ?>

    <div class="booking-grid">
        <section class="details-panel">
            <img class="detail-image" src="<?= e($event['image_path']) ?>" alt="<?= e($event['title']) ?>">
            <h2><?= e($event['title']) ?></h2>
            <div class="meta-list">
                <div><strong>Date</strong><span><?= e(date('d M Y', strtotime($event['event_date']))) ?></span></div>
                <div><strong>Venue</strong><span><?= e($event['venue']) ?>, <?= e($event['city']) ?></span></div>
            </div>
            <p><?= e($event['summary']) ?></p>
            <div class="details-panel" style="margin-top: 1rem;">
                <h3>Booking Summary</h3>
                <div class="summary-row"><span>Ticket</span><strong id="summaryTicket">Select a ticket</strong></div>
                <div class="summary-row"><span>Quantity</span><strong id="summaryQuantity">1</strong></div>
                <div class="summary-row"><span>Total</span><strong id="summaryTotal">&pound;0.00</strong></div>
                <p class="payment-note">Your selected payment option will be recorded with the booking confirmation.</p>
            </div>
        </section>

        <section class="form-panel">
            <h2>Booking Form</h2>
            <form method="post">
                <input type="hidden" name="event_id" value="<?= (int) $event['id'] ?>">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="organisation">Organisation</label>
                        <input id="organisation" name="organisation">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="ticket_id">Ticket Type</label>
                        <select id="ticket_id" name="ticket_id" required>
                            <?php foreach ($tickets as $ticket): ?>
                                <option value="<?= (int) $ticket['id'] ?>" data-price="<?= e((string) $ticket['price']) ?>" data-name="<?= e($ticket['ticket_type']) ?>">
                                    <?= e($ticket['ticket_type']) ?> - <?= money($ticket['price']) ?> (<?= (int) $ticket['available_quantity'] ?> available)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <select id="quantity" name="quantity">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="payment-grid">
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="apple_pay" checked>
                            <span><i class="fab fa-apple"></i> Apple Pay</span>
                            <small>Demo authorisation only</small>
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="card">
                            <span><i class="fas fa-credit-card"></i> Card</span>
                            <small>Visa / Mastercard demo</small>
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="paypal">
                            <span><i class="fab fa-paypal"></i> PayPal</span>
                            <small>Prototype checkout</small>
                        </label>
                        <label class="payment-card">
                            <input type="radio" name="payment_method" value="pay_at_door">
                            <span><i class="fas fa-door-open"></i> Pay at Door</span>
                            <small>Reserve ticket now</small>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" rows="5"></textarea>
                </div>
                <button type="submit" class="cta-button">Confirm Booking</button>
            </form>
        </section>
    </div>
</main>

<script>
    const ticketSelect = document.getElementById('ticket_id');
    const quantitySelect = document.getElementById('quantity');
    const summaryTicket = document.getElementById('summaryTicket');
    const summaryQuantity = document.getElementById('summaryQuantity');
    const summaryTotal = document.getElementById('summaryTotal');

    function updateBookingSummary() {
        const selected = ticketSelect.options[ticketSelect.selectedIndex];
        const price = Number(selected.dataset.price || 0);
        const quantity = Number(quantitySelect.value || 1);
        summaryTicket.textContent = selected.dataset.name || 'Selected ticket';
        summaryQuantity.textContent = String(quantity);
        summaryTotal.textContent = new Intl.NumberFormat('en-GB', {
            style: 'currency',
            currency: 'GBP'
        }).format(price * quantity);
    }

    ticketSelect.addEventListener('change', updateBookingSummary);
    quantitySelect.addEventListener('change', updateBookingSummary);
    updateBookingSummary();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
