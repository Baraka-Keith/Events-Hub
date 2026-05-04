<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'How It Works - EventHub UK';
$active = '';
$basePath = '';
$pageStyles = <<<'STYLE'
<style>
        .page-banner {
            margin-top: 77px;
            padding: 5rem 1rem 4rem;
            background: linear-gradient(rgba(26, 35, 126, 0.72), rgba(13, 71, 161, 0.72)),
                        url('img/how_it_works_banner.png') center/cover no-repeat;
            text-align: center;
            color: white;
        }

        .page-banner h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .page-banner p {
            max-width: 760px;
            margin: 0 auto;
            font-size: 1.12rem;
            opacity: 0.95;
        }

        .process-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 4rem 1rem;
        }

        .process-intro {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3rem;
        }

        .process-intro h2 {
            font-size: 2rem;
            color: #1a237e;
            margin-bottom: 1rem;
        }

        .process-intro p {
            color: #555;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .timeline {
            position: relative;
            margin: 0 auto 3rem;
            max-width: 900px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 36px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #1e88e5, #1a237e);
            border-radius: 10px;
        }

        .timeline-step {
            position: relative;
            padding-left: 100px;
            margin-bottom: 2.5rem;
        }

        .step-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e88e5, #1a237e);
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(30, 136, 229, 0.25);
        }

        .step-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .step-card h3 {
            margin-top: 0;
            margin-bottom: 0.8rem;
            color: #1a237e;
            font-size: 1.4rem;
        }

        .step-card p {
            margin: 0;
            color: #444;
            line-height: 1.75;
        }

        .summary-box {
            background: linear-gradient(135deg, #f4f8ff, #eef4ff);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .summary-box h2 {
            color: #1a237e;
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .summary-box p {
            color: #4b5563;
            max-width: 720px;
            margin: 0 auto 1.5rem;
            line-height: 1.8;
        }

        .summary-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .page-banner h1 {
                font-size: 2.2rem;
            }

            .timeline::before {
                left: 28px;
            }

            .timeline-step {
                padding-left: 80px;
            }

            .step-number {
                width: 56px;
                height: 56px;
                font-size: 1.1rem;
            }

            .process-intro h2 {
                font-size: 1.7rem;
            }
        }
    </style>
STYLE;
require __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <h1>How EventHub UK Works</h1>
        <p>From discovering the right opportunity to confirming your booking, EventHub UK keeps the event journey clear, simple, and professional.</p>
    </section>

    <main class="process-section">
        <div class="process-intro">
            <h2>A Clear Booking Journey</h2>
            <p>
                EventHub UK is designed to help users move smoothly from exploring opportunities
                to attending valuable professional events. Each step is structured to make the
                platform easy to navigate and simple to use.
            </p>
        </div>

        <div class="timeline">
            <div class="timeline-step">
                <div class="step-number">01</div>
                <div class="step-card">
                    <h3>Discover Events</h3>
                    <p>
                        Start by browsing the Events page, where users can explore conferences,
                        workshops, business forums, and networking opportunities across different categories.
                    </p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">02</div>
                <div class="step-card">
                    <h3>Explore the Details</h3>
                    <p>
                        Each event page provides more information about the venue, schedule, speakers,
                        and event purpose, helping users understand whether the opportunity is right for them.
                    </p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">03</div>
                <div class="step-card">
                    <h3>Choose Your Ticket</h3>
                    <p>
                        Once the right event has been selected, users can continue to the booking page
                        and choose the ticket option that best suits their needs.
                    </p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">04</div>
                <div class="step-card">
                    <h3>Confirm Your Booking</h3>
                    <p>
                        Users then enter their details, review the booking information, and confirm
                        their place, creating a straightforward and reliable registration process.
                    </p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">05</div>
                <div class="step-card">
                    <h3>Attend and Connect</h3>
                    <p>
                        With the booking completed, attendees are ready to join the event, gain new
                        insights, and connect with other professionals in a well-organised setting.
                    </p>
                </div>
            </div>
        </div>

        <div class="summary-box">
            <h2>A Professional Experience from Start to Finish</h2>
            <p>
                The aim of EventHub UK is to make the event process feel organised, accessible,
                and professional at every stage, from first discovery through to final attendance.
            </p>
            <div class="summary-actions">
                <a href="events.php" class="cta-button">Explore Events</a>
                <a href="booking.php" class="cta-button">Book Now</a>
            </div>
        </div>
    </main>

<?php require __DIR__ . '/includes/footer.php';
