<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Pricing - EventHub UK';
$active = '';
$basePath = '';
$pageStyles = <<<'STYLE'
<style>
        .page-banner {
            margin-top: 77px;
            padding: 5.5rem 1rem 4.5rem;
            background:
                linear-gradient(rgba(15, 23, 42, 0.72), rgba(30, 64, 175, 0.58)),
                url('img/forum.webp') center/cover no-repeat;
            text-align: center;
            color: white;
        }

        .page-banner h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .page-banner p {
            max-width: 780px;
            margin: 0 auto;
            font-size: 1.08rem;
            line-height: 1.8;
            opacity: 0.96;
        }

        .pricing-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 1rem;
        }

        .intro-card,
        .pricing-card,
        .compare-card,
        .faq-strip,
        .cta-card,
        .note-card {
            background: white;
            border-radius: 18px;
            padding: 1.8rem;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        }

        .intro-card {
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #f8fbff, #eef4ff);
        }

        .intro-card h2,
        .compare-card h2,
        .faq-strip h2,
        .cta-card h2,
        .note-card h2 {
            margin-top: 0;
            color: #1e3a8a;
        }

        .intro-card p,
        .compare-card p,
        .faq-strip p,
        .cta-card p,
        .note-card p {
            color: #475569;
            line-height: 1.8;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .pricing-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .pricing-card.featured {
            border: 2px solid #2563eb;
            transform: translateY(-4px);
        }

        .plan-tag {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .featured .plan-tag {
            background: #2563eb;
            color: white;
        }

        .pricing-card h3 {
            margin: 0 0 0.6rem;
            color: #1f2937;
            font-size: 1.35rem;
        }

        .price {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 0.4rem;
        }

        .price-note {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.2rem;
        }

        .plan-desc {
            color: #475569;
            line-height: 1.75;
            margin-bottom: 1.25rem;
        }

        .feature-list {
            display: grid;
            gap: 0.9rem;
            margin: 0 0 1.5rem;
            padding: 0;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            gap: 0.7rem;
            align-items: flex-start;
            color: #475569;
            line-height: 1.7;
        }

        .feature-list i {
            color: #2563eb;
            margin-top: 0.2rem;
        }

        .compare-card {
            margin-bottom: 2rem;
        }

        .compare-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .compare-table th,
        .compare-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        .compare-table th {
            background: #f8fbff;
            color: #1e3a8a;
        }

        .note-card {
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #eff6ff, #f8fbff);
            border-left: 4px solid #2563eb;
        }

        .faq-strip {
            margin-bottom: 2rem;
        }

        .faq-mini-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .faq-mini {
            background: #f8fbff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1rem;
        }

        .faq-mini h3 {
            margin-top: 0;
            margin-bottom: 0.55rem;
            color: #1f2937;
            font-size: 1rem;
        }

        .faq-mini p {
            margin: 0;
            color: #475569;
            line-height: 1.7;
        }

        .cta-card {
            text-align: center;
            background: linear-gradient(135deg, #f8fbff, #eef4ff);
        }

        .cta-row {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .secondary-btn {
            display: inline-block;
            text-decoration: none;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            background: white;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
        }

        @media (max-width: 950px) {
            .pricing-grid,
            .faq-mini-grid {
                grid-template-columns: 1fr;
            }

            .compare-table {
                display: block;
                overflow-x: auto;
            }

            .page-banner h1 {
                font-size: 2.2rem;
            }
        }
    </style>
STYLE;
require __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <h1>Clear Pricing for Every Type of Attendee</h1>
        <p>
            EventHub UK uses a flexible ticket structure designed to suit different attendee needs.
            Standard tickets offer core event access, premium tickets provide enhanced value, and
            eligible students can receive a reduced rate based on the standard ticket price.
        </p>
    </section>

    <main class="pricing-section">
        <section class="intro-card">
            <h2>Simple Pricing Structure</h2>
            <p>
                Rather than using one fixed price across the whole platform, EventHub UK applies a
                consistent ticket model across different events. This keeps the booking experience easier
                to understand while still allowing each event to reflect its own scale, venue, and access level.
            </p>
        </section>

        <section class="pricing-grid">
            <div class="pricing-card">
                <div class="plan-tag">Core Access</div>
                <h3>Standard</h3>
                <div class="price">Event-Based</div>
                <div class="price-note">Base ticket price set per event</div>
                <p class="plan-desc">
                    Standard tickets are the main reference point for each event and provide access to the
                    essential experience, including core sessions, entry, and general networking opportunities.
                </p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i><span>Main event entry</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Access to keynote sessions</span></li>
                    <li><i class="fas fa-check-circle"></i><span>General networking areas</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Digital event materials</span></li>
                </ul>
                <a href="events.php" class="cta-button">Browse Events</a>
            </div>

            <div class="pricing-card featured">
                <div class="plan-tag">Enhanced Access</div>
                <h3>Premium</h3>
                <div class="price">Higher Than Standard</div>
                <div class="price-note">For added value and upgraded access</div>
                <p class="plan-desc">
                    Premium tickets are designed for attendees who want an elevated event experience,
                    such as priority access, improved seating, or additional sessions where available.
                </p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i><span>Everything in Standard</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Priority seating or entry</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Selected premium sessions</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Enhanced networking access</span></li>
                </ul>
                <a href="events.php" class="cta-button">Compare Events</a>
            </div>

            <div class="pricing-card">
                <div class="plan-tag">Student Access</div>
                <h3>Student</h3>
                <div class="price">25% Off Standard</div>
                <div class="price-note">Available with valid student ID</div>
                <p class="plan-desc">
                    Student tickets provide reduced-cost access for eligible attendees and are based on a
                    percentage discount from the event’s standard price, helping students join professional events more affordably.
                </p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i><span>Discounted entry price</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Based on standard ticket price</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Core event access</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Valid student ID may be required</span></li>
                </ul>
                <a href="faq.php" class="secondary-btn">Student FAQs</a>
            </div>
        </section>

        <section class="compare-card">
            <h2>How Ticket Types Compare</h2>
            <p>
                Exact pricing and inclusions vary by event, but the structure below shows how each ticket
                category is positioned across the platform.
            </p>

            <table class="compare-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Standard</th>
                        <th>Premium</th>
                        <th>Student</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pricing model</td>
                        <td>Base event price</td>
                        <td>Higher than standard</td>
                        <td>25% off standard</td>
                    </tr>
                    <tr>
                        <td>Main event access</td>
                        <td>Included</td>
                        <td>Included</td>
                        <td>Included</td>
                    </tr>
                    <tr>
                        <td>Keynote sessions</td>
                        <td>Included</td>
                        <td>Included</td>
                        <td>Included</td>
                    </tr>
                    <tr>
                        <td>Priority seating / entry</td>
                        <td>Not usually included</td>
                        <td>Included where available</td>
                        <td>Not usually included</td>
                    </tr>
                    <tr>
                        <td>Premium workshops</td>
                        <td>Sometimes limited</td>
                        <td>More likely included</td>
                        <td>Event dependent</td>
                    </tr>
                    <tr>
                        <td>Eligibility requirement</td>
                        <td>Open access</td>
                        <td>Open access</td>
                        <td>Valid student ID</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="note-card">
            <h2>How Student Pricing Works</h2>
            <p>
                Student tickets are not treated as a separate unrelated price tier. Instead, they are
                calculated as a discounted version of the standard ticket price for the selected event.
                This keeps pricing more logical and ensures that student entry remains clearly tied to the
                event’s main pricing structure.
            </p>
        </section>

        <section class="faq-strip">
            <h2>Pricing Questions</h2>
            <div class="faq-mini-grid">
                <div class="faq-mini">
                    <h3>Why do ticket prices vary?</h3>
                    <p>Each event may differ in venue, scale, organiser requirements, session type, and ticket availability.</p>
                </div>
                <div class="faq-mini">
                    <h3>Is student pricing always available?</h3>
                    <p>Not every event may offer student access, and some organisers may request proof of eligibility at check-in.</p>
                </div>
                <div class="faq-mini">
                    <h3>Does premium always include extra sessions?</h3>
                    <p>Premium access varies by event, but typically offers added value such as better seating, priority access, or enhanced networking.</p>
                </div>
            </div>
        </section>

        <section class="cta-card">
            <h2>Ready to Compare Ticket Options?</h2>
            <p>
                Browse upcoming events, review the ticket categories available, and choose the option that best fits
                your goals, budget, and event experience.
            </p>
            <div class="cta-row">
                <a href="events.php" class="cta-button">Browse Events</a>
                <a href="faq.php" class="secondary-btn">View FAQs</a>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php';
