<?php
declare(strict_types=1);

require_once __DIR__ . '/data.php';

function queue_email(string $toEmail, string $toName, string $subject, string $body, string $type, ?int $relatedBookingId = null, ?int $relatedUserId = null): void
{
    $status = 'queued';
    $sentAt = null;
    $error = null;

    if (APP_SEND_REAL_EMAIL) {
        $headers = [
            'From: ' . APP_FROM_NAME . ' <' . APP_FROM_EMAIL . '>',
            'Reply-To: ' . APP_FROM_EMAIL,
            'Content-Type: text/plain; charset=UTF-8',
        ];

        $sent = @mail($toEmail, $subject, $body, implode("\r\n", $headers));
        $status = $sent ? 'sent' : 'failed';
        $sentAt = $sent ? date('Y-m-d H:i:s') : null;
        $error = $sent ? null : 'PHP mail() returned false. Check local mail server configuration.';
    }

    $stmt = db()->prepare(
        'INSERT INTO email_outbox
            (recipient_email, recipient_name, subject, body, email_type, status, related_booking_id, related_user_id, sent_at, error_message)
         VALUES
            (:recipient_email, :recipient_name, :subject, :body, :email_type, :status, :related_booking_id, :related_user_id, :sent_at, :error_message)'
    );
    $stmt->execute([
        'recipient_email' => $toEmail,
        'recipient_name' => $toName,
        'subject' => $subject,
        'body' => $body,
        'email_type' => $type,
        'status' => $status,
        'related_booking_id' => $relatedBookingId,
        'related_user_id' => $relatedUserId,
        'sent_at' => $sentAt,
        'error_message' => $error,
    ]);
}

function ticket_email_body(array $booking, array $event, array $ticket): string
{
    $paymentMethod = ucwords(str_replace('_', ' ', (string) $booking['payment_method']));
    $paymentStatus = ucwords(str_replace('_', ' ', (string) $booking['payment_status']));

    return "Hello {$booking['full_name']},\n\n"
        . "Thank you for booking with EventHub UK. Your ticket has been confirmed.\n\n"
        . "Ticket Reference: {$booking['booking_reference']}\n"
        . "Event: {$event['title']}\n"
        . "Date: " . date('d M Y', strtotime($event['event_date'])) . "\n"
        . "Time: " . substr((string) $event['start_time'], 0, 5) . " - " . substr((string) $event['end_time'], 0, 5) . "\n"
        . "Venue: {$event['venue']}, {$event['city']}\n"
        . "Ticket Type: {$ticket['ticket_type']}\n"
        . "Quantity: {$booking['quantity']}\n"
        . "Total: GBP " . number_format((float) $booking['total_amount'], 2) . "\n"
        . "Payment: {$paymentMethod} ({$paymentStatus})\n\n"
        . "Please bring this reference with you when attending the event.\n\n"
        . "EventHub UK";
}

