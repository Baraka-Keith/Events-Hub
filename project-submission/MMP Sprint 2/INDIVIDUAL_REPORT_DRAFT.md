# MMP Individual Contribution Report Draft

Role focus: Software Developer / Database Implementation

During Sprint 2, my main contribution was improving EventHub UK from a mostly static prototype into a more complete working system. The MVP stage showed the concept of an events platform, but several parts of the user journey were still limited because the pages relied on hard-coded content and form submissions did not persist anywhere. I focused on making the MMP version more realistic, demonstrable, and aligned with the final portfolio requirements.

One of the key improvements was building a PHP and MySQL layer suitable for XAMPP and phpMyAdmin. I created a database structure for events, tickets, bookings, contact messages, support requests, and newsletter subscribers. This gave the website a clearer technical foundation because the event listings, event details, booking records, and admin pages can now use stored data instead of static examples. This was important because the MMP demonstration needs to show a working prototype, not just page designs.

I also improved the booking journey. Users can browse events, open event details, select a ticket, submit their details, and receive a booking reference. The booking is then saved in the database and appears in the admin booking management page. This creates stronger alignment between the public user experience and the admin side of the system. It also provides useful evidence for the demonstration video because the group can show a booking being created and then immediately show the record in the database/admin dashboard.

On the admin side, I replaced the prototype-only idea with database-backed pages. The dashboard now displays live counts for total events, bookings, revenue, and open support requests. The booking page lists real bookings and allows their status to be updated. The support page lists support requests submitted by users and allows status tracking. The events page shows event records and includes a basic add-event form. These changes make the system more credible as a business prototype because staff can monitor activity and manage user requests.

This work responds to Sprint 1 feedback by showing clearer technical growth and a stronger connection between repository evidence and demonstrated features. The final system still has limitations, including the need for secure admin authentication, payment processing, and email confirmations in a production version. However, for the Sprint 2 MMP scope, the project now demonstrates a meaningful full-stack event booking workflow with a suitable database and admin management features.

Evidence to include:

1. Screenshot of the `codex/mmp-sprint2-fullstack` branch in GitHub or VS Code source control.
2. Screenshot of `database/eventhub_uk.sql` or phpMyAdmin tables.
3. Screenshot of a public booking confirmation page.
4. Screenshot of the same booking in `admin/bookings.php`.
5. Screenshot of the support form and `admin/support.php` support queue.

