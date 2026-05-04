<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Blog - EventHub UK';
$active = '';
$basePath = '';
$pageStyles = <<<'STYLE'
<style>
        .page-banner {
            margin-top: 77px;
            padding: 5rem 1rem 4rem;
            background:
                linear-gradient(rgba(15, 23, 42, 0.75), rgba(30, 64, 175, 0.58)),
                url('img/main.jpg') center/cover no-repeat;
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
            max-width: 760px;
            margin: 0 auto;
            font-size: 1.05rem;
            line-height: 1.85;
            opacity: 0.95;
        }

        .blog-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 1rem;
        }

        .featured-article,
        .article-card,
        .topics-card,
        .newsletter-card,
        .cta-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        }

        .featured-article {
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            min-height: 320px;
            object-fit: cover;
            display: block;
        }

        .featured-content {
            padding: 2rem;
        }

        .post-tag {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .featured-content h2 {
            margin: 0 0 0.9rem;
            color: #1e3a8a;
            font-size: 2rem;
            line-height: 1.25;
        }

        .post-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .featured-content p {
            color: #475569;
            line-height: 1.85;
            margin-bottom: 1.4rem;
        }

        .blog-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            align-items: start;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .article-card {
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .article-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .article-content {
            padding: 1.4rem;
        }

        .article-content h3 {
            margin: 0 0 0.7rem;
            color: #1f2937;
            font-size: 1.2rem;
            line-height: 1.4;
        }

        .article-content p {
            margin: 0 0 1rem;
            color: #475569;
            line-height: 1.75;
        }

        .read-link {
            text-decoration: none;
            color: #2563eb;
            font-weight: 600;
        }

        .sidebar {
            display: grid;
            gap: 1.5rem;
            position: sticky;
            top: 110px;
        }

        .topics-card,
        .newsletter-card {
            padding: 1.5rem;
        }

        .topics-card h3,
        .newsletter-card h3,
        .cta-card h2 {
            margin-top: 0;
            color: #1e3a8a;
        }

        .topic-list {
            display: grid;
            gap: 0.8rem;
        }

        .topic-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0.9rem;
            border-radius: 12px;
            background: #f8fbff;
            border: 1px solid #e2e8f0;
            color: #334155;
        }

        .topic-item span:last-child {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.82rem;
        }

        .newsletter-card p {
            color: #475569;
            line-height: 1.75;
            margin-bottom: 1rem;
        }

        .newsletter-card input {
            width: 100%;
            padding: 0.95rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-size: 0.98rem;
        }

        .newsletter-card input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .cta-card {
            margin-top: 2rem;
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, #f8fbff, #eef4ff);
        }

        .cta-card p {
            max-width: 760px;
            margin: 0 auto 1.2rem;
            color: #475569;
            line-height: 1.8;
        }

        .cta-row {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
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

        @media (max-width: 1000px) {
            .featured-article,
            .blog-layout,
            .articles-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }
        }

        @media (max-width: 700px) {
            .page-banner h1 {
                font-size: 2.2rem;
            }
        }
    </style>
STYLE;
require __DIR__ . '/includes/header.php';
?>

    <section class="page-banner">
        <h1>Insights, Ideas, and Event Inspiration</h1>
        <p>
            Explore articles on professional networking, industry events, leadership, marketing,
            technology trends, and practical tips to help you make the most of every event experience.
        </p>
    </section>

    <main class="blog-section">
        <section class="featured-article">
            <div class="featured-image">
                <img src="img/techeu-summit-25-1-987.webp" alt="Featured article">
            </div>
            <div class="featured-content">
                <div class="post-tag">Featured Article</div>
                <h2>How to Get More Value From Professional Events in 2025</h2>
                <div class="post-meta">
                    <span><i class="fas fa-calendar"></i> 12 March 2025</span>
                    <span><i class="fas fa-user"></i> EventHub Editorial</span>
                    <span><i class="fas fa-folder-open"></i> Networking</span>
                </div>
                <p>
                    Professional events are no longer just about attending talks and collecting leaflets.
                    In 2025, the most valuable event experiences come from preparation, intention, and
                    meaningful follow-up. From choosing the right sessions to approaching networking with
                    more confidence, small decisions can make a big difference.
                </p>
                <a href="#" class="cta-button">Read Article</a>
            </div>
        </section>

        <div class="blog-layout">
            <section class="articles-grid">
                <article class="article-card">
                    <img src="img/design.jpeg" alt="Design article">
                    <div class="article-content">
                        <div class="post-tag">Design</div>
                        <h3>Why Creative Events Matter for Modern Brand Thinking</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 5 April 2025</span>
                        </div>
                        <p>
                            Creative events offer more than inspiration. They help professionals understand
                            how design, branding, and user experience connect with business growth.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/forum.webp" alt="Leadership article">
                    <div class="article-content">
                        <div class="post-tag">Leadership</div>
                        <h3>Three Leadership Qualities That Stand Out at Business Forums</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 18 April 2025</span>
                        </div>
                        <p>
                            Business forums reveal how strong leaders communicate, listen, and respond.
                            These qualities often matter more than polished presentations alone.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/digital-marketing-uk.jpeg" alt="Marketing article">
                    <div class="article-content">
                        <div class="post-tag">Marketing</div>
                        <h3>What Event Professionals Can Learn From Current Digital Marketing Trends</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 30 April 2025</span>
                        </div>
                        <p>
                            From audience targeting to content strategy, event organisers and attendees alike
                            can gain useful insight from the latest digital marketing shifts.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/International-Conference-on-Artificial-Intelligence-and-Machine-Learning.webp" alt="Technology article">
                    <div class="article-content">
                        <div class="post-tag">Technology</div>
                        <h3>Why AI and Machine Learning Events Continue to Grow</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 10 May 2025</span>
                        </div>
                        <p>
                            AI-focused events keep expanding because the subject now touches every industry,
                            from business operations to design, marketing, and product development.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/main.jpg" alt="Networking article">
                    <div class="article-content">
                        <div class="post-tag">Career Growth</div>
                        <h3>How to Network Without Feeling Awkward at Large Events</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 22 May 2025</span>
                        </div>
                        <p>
                            Networking can feel uncomfortable, but a few simple strategies can help attendees
                            start better conversations and build more genuine professional connections.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/networking_opportunities.jpg" alt="Events article">
                    <div class="article-content">
                        <div class="post-tag">Events</div>
                        <h3>What Makes an Event Feel Premium From the Attendee Perspective</h3>
                        <div class="post-meta">
                            <span><i class="fas fa-calendar"></i> 1 June 2025</span>
                        </div>
                        <p>
                            Premium events are not only about higher prices. Attendees notice the details,
                            from smoother registration to better session flow and more thoughtful spaces.
                        </p>
                        <a href="#" class="read-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            </section>

            <aside class="sidebar">
                <div class="topics-card">
                    <h3>Popular Topics</h3>
                    <div class="topic-list">
                        <div class="topic-item"><span>Networking</span><span>6</span></div>
                        <div class="topic-item"><span>Leadership</span><span>4</span></div>
                        <div class="topic-item"><span>Technology</span><span>5</span></div>
                        <div class="topic-item"><span>Marketing</span><span>3</span></div>
                        <div class="topic-item"><span>Career Growth</span><span>4</span></div>
                    </div>
                </div>

                <div class="newsletter-card">
                    <h3>Stay Updated</h3>
                    <p>
                        Subscribe for event insights, new articles, and curated updates from across the
                        EventHub UK platform.
                    </p>
                    <input type="email" placeholder="Enter your email">
                    <button class="cta-button">Subscribe</button>
                </div>
            </aside>
        </div>

        <section class="cta-card">
            <h2>Looking for Your Next Event?</h2>
            <p>
                Explore upcoming conferences, workshops, and networking opportunities across the UK,
                then apply what you’ve learned from the blog to make the most of your experience.
            </p>
            <div class="cta-row">
                <a href="events.php" class="cta-button">Browse Events</a>
                <a href="pricing.php" class="secondary-btn">View Pricing</a>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php';
