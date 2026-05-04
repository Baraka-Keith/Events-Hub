# Events-Hub-UK

An event booking website that promotes professional events across the UK.

## Sprint 2 Full-Stack Version

This Sprint 2 version develops the earlier prototype into a XAMPP/PHP/MySQL working prototype. It also cleans up the earlier mixed HTML/PHP structure so the project runs as a more consistent PHP-based system for testing, demonstration, and further development.

## Key Features

- Database-backed event listings and event details
- Booking form that stores records in MySQL
- Contact and support forms that store requests in MySQL
- Role-based login for admin and client users
- Admin dashboard for bookings, support, users, and events
- Client dashboard for bookings and support chat
- Shared PHP structure for a more consistent site flow

## Main Pages

- `index.php` - database-backed homepage
- `events.php` - searchable event listing
- `event.php` - event detail page
- `booking.php` - booking form that saves to MySQL
- `contact.php` - contact form that saves to MySQL
- `support.php` - support form that saves to MySQL
- `faq.php` - frequently asked questions
- `how_it_works.php` - user journey and platform explanation
- `pricing.php` - ticket pricing and package information
- `terms.php` - terms and conditions
- `blog.php` - blog/news style content page

## Admin Pages

- `admin/dashboard.php` - admin dashboard
- `admin/bookings.php` - booking records and status updates
- `admin/support.php` - support request queue
- `admin/events.php` - event records and add-event form
- `admin/users.php` - admin/client user list and account creation
- `admin/emails.php` - login-code and ticket email outbox
- `admin/support_chat.php` - admin replies to client support chats

## Client Pages

- `client/dashboard.php` - client booking dashboard
- `client/chat.php` - database-backed client/support chat

## Authentication

- `login.php` - role-based login
- `logout.php` - logout handler

### Demo Accounts

- Admin: `admin@eventhub.test` / `admin123`
- Client: `client@eventhub.test` / `client123`

The login flow includes a demo verification code step. In a production deployment this would be sent through an email provider, but in the local XAMPP prototype the code is shown on screen for demonstration and marking purposes.

## Email Handling

- Login codes and booking tickets are generated as email records in `email_outbox`
- Real sending is disabled by default through `APP_SEND_REAL_EMAIL = false` in `config/database.php`
- This keeps the coursework demo safe while still showing that the email workflow exists

## How to Run the Project

1. Clone or download the repository
2. Copy the project folder into XAMPP `htdocs` as `Events-Hub`
3. Start Apache and MySQL in XAMPP
4. Open phpMyAdmin at `http://localhost/phpmyadmin`
5. Import `database/eventhub_uk.sql`
6. Check `config/database.php` and confirm the database connection matches your XAMPP setup
7. Visit `http://localhost/Events-Hub/index.php`
8. Use the demo accounts above to test admin and client flows

## Database

- Import `database/eventhub_uk.sql` into phpMyAdmin
- Default XAMPP connection is configured in `config/database.php` as `root` with an empty password
- Update the MySQL port in `config/database.php` if your local XAMPP setup is not using the default port

## Notes

- This version cleans up the earlier mixed HTML/PHP structure and aligns the main site flow to PHP pages
- This makes the project easier to run, test, and demonstrate as one consistent system
- Some features remain prototype-oriented, but the core user, admin, and client flows are now more coherent

## Submission Materials

- See `project-submission/MMP Sprint 2/` for setup notes, video plan, risk register, and report draft