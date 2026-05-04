# MMP Sprint 2 Demonstration Video Plan

Target length: 5-10 minutes.

## 1. Opening Pitch

EventHub UK is a professional event booking platform for discovering and booking conferences, workshops, and networking events across the UK. The business need is to help users find suitable events quickly, understand event details, book tickets, and contact support when they need help.

## 2. Public User Journey

Show:

- `index.php`: database-backed homepage and featured events.
- `events.php`: search and filter by category/location.
- `event.php`: event details, business need, ticket options.
- `booking.php`: booking form linked to a selected event.
- `booking_success.php`: booking reference confirmation.
- `contact.php` and `support.php`: forms stored in the database.

Key point to say:

The Sprint 1/MVP version demonstrated the idea. The Sprint 2/MMP version improves it by connecting the core user journey to a real database.

## 3. Admin/User Management Journey

Show:

- `admin/dashboard.php`: live counts for events, bookings, revenue, and support.
- `admin/bookings.php`: booking records created through the public form.
- `admin/support.php`: support requests submitted by users.
- `admin/events.php`: event records and add-event form.

Key point to say:

Theo's branch had prototype admin pages with hard-coded sample data. The updated Sprint 2 version uses MySQL records, which makes the prototype more realistic and testable.

## 4. Database Evidence

Show phpMyAdmin:

- `events`
- `tickets`
- `bookings`
- `support_requests`
- `contact_messages`
- `newsletter_subscribers`

Key point to say:

The database structure separates event, ticket, booking, support, and contact data, which improves maintainability and supports future backend development.

## 5. Individual Contribution Section

Suggested personal script:

My main Sprint 2 contribution was turning the static/prototype pages into a more complete working system. I added the PHP and MySQL layer, created the database schema, connected event browsing and booking to database records, and updated the admin side so bookings and support requests can be managed from live data. This directly responds to the MVP feedback because the system now has clearer functionality, stronger evidence of technical progress, and a better alignment between what is shown in the video and what exists in the repository.

## 6. Remaining Work

Mention honestly:

- Secure admin login is still future work.
- Online payment integration is future work.
- Email confirmations are future work.
- The current system is a strong local XAMPP prototype for the MMP submission.

