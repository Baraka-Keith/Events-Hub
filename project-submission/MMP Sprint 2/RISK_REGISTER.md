# MMP Sprint 2 Risk Register

| ID | Risk | Type | Likelihood | Impact | Status | Mitigation |
| --- | --- | --- | --- | --- | --- | --- |
| R1 | MVP pages were mostly static and could fail to demonstrate real system behaviour. | Technical | High | High | Mitigated | Added PHP/MySQL pages for event browsing, booking, contact, support, and admin records. |
| R2 | Admin pages used hard-coded sample data, weakening alignment between demo and repository. | Technical | High | Medium | Mitigated | Added database-backed admin dashboard, bookings table, support queue, and event management page. |
| R3 | Database setup may fail on another machine if XAMPP/MySQL is not running. | Technical | Medium | High | Open | Added `database/eventhub_uk.sql` and setup guide with phpMyAdmin import steps. |
| R4 | Team members may describe features that are not actually present in the repository. | Team/Process | Medium | High | Mitigated | Created video plan that matches the implemented pages and database tables. |
| R5 | Time pressure before the MMP deadline may reduce testing quality. | Schedule | Medium | High | Open | Prioritised core user journey first: browse event, book ticket, review admin record, submit support request. |
| R6 | Lack of secure admin authentication could be identified as a prototype limitation. | Security | Medium | Medium | Accepted for prototype | Documented as future work and kept the admin panel local to the XAMPP prototype. |
| R7 | Booking data could be incomplete or invalid. | Data Quality | Medium | Medium | Mitigated | Added server-side validation for required names, emails, ticket selection, and support/contact forms. |
| R8 | Future event edits could break links if event titles change. | Technical | Medium | Medium | Mitigated | Added stable `slug` values for public event detail URLs. |

