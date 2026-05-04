<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'FAQs - EventHub UK';
$active = '';
$basePath = '';
$pageStyles = <<<'STYLE'
<style>
        .page-banner {
            margin-top: 77px;
            padding: 5rem 1rem 4rem;
            background: linear-gradient(rgba(26, 35, 126, 0.82), rgba(13, 71, 161, 0.82));
            text-align: center;
            color: white;
        }

        .page-banner h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .page-banner p {
            max-width: 780px;
            margin: 0 auto;
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .faq-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 1rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
            align-items: start;
        }

        .faq-sidebar {
            position: sticky;
            top: 110px;
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.08);
            max-height: 75vh;
            overflow-y: auto;
        }

        .faq-sidebar h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #1a237e;
            font-size: 1.2rem;
        }

        .faq-sidebar a {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 0.8rem 0.9rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.25s ease;
            font-size: 0.96rem;
            line-height: 1.4;
        }

        .faq-sidebar a:hover {
            background: #eef4ff;
            color: #1a237e;
        }

        .faq-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .faq-card {
            background: white;
            border-radius: 14px;
            padding: 2rem;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.08);
            scroll-margin-top: 110px;
        }

        .faq-card h2 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #1a237e;
            font-size: 1.4rem;
        }

        .faq-card p {
            margin: 0;
            color: #444;
            line-height: 1.75;
        }

        .faq-note {
            background: linear-gradient(135deg, #f3f7ff, #eef4ff);
            border-left: 4px solid #1e88e5;
        }

        .faq-note h2 {
            color: #0d47a1;
        }

        @media (max-width: 900px) {
            .faq-layout {
                grid-template-columns: 1fr;
            }

            .faq-sidebar {
                position: static;
                max-height: none;
            }

            .page-banner h1 {
                font-size: 2rem;
            }
        }
    </style>
STYLE;
require __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <h1>Frequently Asked Questions</h1>
        <p>
            Find clear answers to common questions about booking, attending events,
            managing tickets, and getting support through EventHub UK.
        </p>
    </section>

    <main class="faq-layout">
        <aside class="faq-sidebar">
            <h3>Browse Questions</h3>
            <a href="#booking">How do I book an event?</a>
            <a href="#confirmation">Will I receive confirmation after booking?</a>
            <a href="#changes">Can I change or cancel my booking?</a>
            <a href="#tickets">Can I book more than one ticket?</a>
            <a href="#payments">Are all events paid?</a>
            <a href="#attendance">What should I bring to the event?</a>
            <a href="#updates">What happens if event details change?</a>
            <a href="#support">How do I get help if I need support?</a>
            <a href="#entry">What happens on the day of the event?</a>
        </aside>

        <section class="faq-content">
            <div class="faq-card" id="booking">
                <h2>How do I book an event?</h2>
                <p>
                    Users can browse the available events, open an event details page, and then continue
                    to the booking page by selecting the Book Now or Book Your Ticket option. From there,
                    they can choose a ticket type, enter their details, and complete the booking process.
                </p>
            </div>

            <div class="faq-card" id="confirmation">
                <h2>Will I receive confirmation after booking?</h2>
                <p>
                    In a full version of the platform, users would receive a confirmation email containing
                    the booking summary, event information, and any important attendance instructions. This
                    helps users keep a clear record of their booking and prepares them for the event.
                </p>
            </div>

            <div class="faq-card" id="changes">
                <h2>Can I change or cancel my booking?</h2>
                <p>
                    Cancellation and amendment options can vary depending on the organiser and the event type.
                    Some bookings may allow changes before the event date, while others may have fixed conditions.
                    Users should review the event terms carefully before confirming their purchase.
                </p>
            </div>

            <div class="faq-card" id="tickets">
                <h2>Can I book more than one ticket?</h2>
                <p>
                    Yes. Where available, users can select multiple tickets during the booking process. This is
                    useful for colleagues, teams, or group attendance at conferences, workshops, and networking events.
                </p>
            </div>

            <div class="faq-card" id="payments">
                <h2>Are all events paid?</h2>
                <p>
                    Not all events are paid. Some may be free to attend, while others may include standard,
                    premium, or specialist ticket options depending on the event format, venue, and organiser.
                    Pricing information should always be shown clearly before booking.
                </p>
            </div>

            <div class="faq-card" id="attendance">
                <h2>What should I bring to the event?</h2>
                <p>
                    Attendees should usually bring their booking confirmation and, where required, a valid form
                    of identification. Some events may also recommend bringing notebooks, devices, or printed materials
                    depending on the type of session being hosted.
                </p>
            </div>

            <div class="faq-card" id="updates">
                <h2>What happens if event details change?</h2>
                <p>
                    If there are updates to the venue, date, timing, or programme, attendees would normally be informed
                    using the contact details provided during booking. Clear communication is important so that users can
                    plan ahead and stay informed about any important changes.
                </p>
            </div>

            <div class="faq-card" id="support">
                <h2>How do I get help if I need support?</h2>
                <p>
                    If support is needed, users can use the contact page to send an enquiry. This may include questions
                    about booking, event access, timings, ticket types, or general platform support. A clear support route
                    helps improve trust and makes the site feel more complete.
                </p>
            </div>

            <div class="faq-card" id="entry">
                <h2>What happens on the day of the event?</h2>
                <p>
                    On the day of the event, attendees would normally arrive at the venue, check in, and follow any guidance
                    provided by the organiser. Depending on the event, this may include registration, networking sessions,
                    keynote talks, workshops, or other scheduled activities.
                </p>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php';
