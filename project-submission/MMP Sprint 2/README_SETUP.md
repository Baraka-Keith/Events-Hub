# EventHub UK - MMP Sprint 2 Full-Stack Setup

This folder is for Portfolio 2 / MMP Sprint 2. It is separate from MVP Sprint 1 evidence.

## Which Branch Is Which

- `main`: original MVP-style project from the first repository commit.
- `theo-site-updates`: Theo's updated front-end branch with improved navigation, booking flow pages, new public pages, and prototype admin pages.
- `codex/mmp-sprint2-fullstack`: Sprint 2 working branch built on Theo's updates. This adds PHP, MySQL, real form submissions, booking records, support records, and database-backed admin pages.

## XAMPP/phpMyAdmin Setup

1. Open XAMPP Manager.
2. Start `Apache`.
3. Start `MySQL`.
4. Open phpMyAdmin: `http://localhost/phpmyadmin`.
5. Import this file:

   `database/eventhub_uk.sql`

6. Put or copy this project folder into:

   `/Applications/XAMPP/xamppfiles/htdocs/Events-Hub`

7. Open the working site:

   `http://localhost/Events-Hub/index.php`

## Main Working Pages

- Login page: `login.php`
- Admin account: `admin@eventhub.test` / `admin123`
- Client account: `client@eventhub.test` / `client123`
- Public homepage: `index.php`
- Search/filter events: `events.php`
- Event details: `event.php?slug=techconnect-2026`
- Booking flow: `booking.php?event_id=1`
- Contact form: `contact.php`
- Support form: `support.php`
- Admin dashboard: `admin/dashboard.php`
- Admin events: `admin/events.php`
- Admin bookings: `admin/bookings.php`
- Admin support queue: `admin/support.php`
- Admin user list: `admin/users.php`
- Admin email outbox: `admin/emails.php`
- Client dashboard: `client/dashboard.php`
- Client/support chat: `client/chat.php`
- Admin support chat reply: `admin/support_chat.php`

## Sprint 2 Improvements To Mention

- Converted the prototype into a database-backed PHP/MySQL application for XAMPP.
- Added a normalized MySQL schema with events, tickets, bookings, contact messages, support requests, and newsletter subscribers.
- Replaced hard-coded event listings with database queries.
- Added real booking creation and booking confirmation references.
- Added admin pages that read real bookings and support requests from the database.
- Added status updates for bookings and support tickets.
- Added event creation from the admin panel.
- Added role-based login with separate admin and client dashboards.
- Added demo login verification code step, user-management page, event delete/close controls, and payment-method selection.
- Added prototype-safe email workflow for login codes and ticket confirmations through an admin email outbox.
- Added database-backed client/support chat as a scoped enhancement to the support workflow.
- Preserved Theo's public page improvements while adding full-stack functionality.

## Known Scope Boundary

This is a strong working prototype for MMP Sprint 2. A production version would still need a real email provider, secure payment gateway/merchant setup for Apple Pay, live chat notifications/WebSockets, and more detailed access control.
