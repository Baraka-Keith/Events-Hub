# Events-Hub-UK

An event booking website that promotes professional events across the UK.

## Sprint 2 Project Update

This branch upgrades Theo's updated front-end work into a XAMPP/PHP/MySQL working version with database-backed event, booking, support, and admin features.

Main pages:

- `index.php` - database-backed homepage
- `events.php` - searchable event listing
- `event.php` - event detail page
- `booking.php` - booking form that saves to MySQL
- `contact.php` - contact form that saves to MySQL
- `support.php` - support form that saves to MySQL
- `admin/dashboard.php` - live admin dashboard
- `admin/bookings.php` - booking records and status updates
- `admin/support.php` - support request queue
- `admin/events.php` - event records and add-event form
- `admin/users.php` - admin/client user list and account creation
- `admin/emails.php` - login-code and ticket email outbox
- `login.php` - role-based login
- `client/dashboard.php` - client booking dashboard
- `client/chat.php` - database-backed client/support chat
- `admin/support_chat.php` - admin replies to client support chats

Demo logins:

- Admin: `admin@eventhub.test` / `admin123`
- Client: `client@eventhub.test` / `client123`

The login flow includes a demo verification code step. In a production deployment this would be emailed through a mail provider; in the local XAMPP prototype the generated code is shown on screen for marking/demo purposes.

Email handling:

- Login codes and booking tickets are generated as email records in `email_outbox`.
- Real sending is disabled by default through `APP_SEND_REAL_EMAIL = false` in `config/database.php`.
- This keeps the local demo safe while still proving the email workflow exists.

## How the Marker Can Access the Project

1. Clone or download the repository.
2. Copy the project folder into XAMPP `htdocs` as `Events-Hub`.
3. Start Apache and MySQL in XAMPP.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Import `database/eventhub_uk.sql`.
6. Visit `http://localhost/Events-Hub/index.php`.
7. Use the demo accounts above to test admin and client flows.

The submitted repository should include this README, the SQL file, and the MMP Sprint 2 setup notes.

Database:

- Import `database/eventhub_uk.sql` into phpMyAdmin.
- Default XAMPP connection is configured in `config/database.php` as `root` with an empty password.

Submission materials:

- See `project-submission/MMP Sprint 2/` for setup notes, video plan, risk register, and report draft.
