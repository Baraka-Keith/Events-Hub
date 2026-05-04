    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>EventHub</h3>
                <p>Your gateway to professional growth and networking across the UK.</p>
                <form class="newsletter-form" method="post" action="<?= e($basePath ?? '') ?>newsletter.php">
                    <input type="email" name="email" class="newsletter-input" placeholder="Enter your email" required>
                    <button class="newsletter-button" type="submit">Subscribe</button>
                </form>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="<?= e($basePath ?? '') ?>events.php">Browse Events</a>
                <a href="<?= e($basePath ?? '') ?>how_it_works.html">How It Works</a>
                <a href="<?= e($basePath ?? '') ?>pricing.html">Pricing</a>
                <a href="<?= e($basePath ?? '') ?>contact.php">Contact Us</a>
            </div>
            <div class="footer-section">
                <h3>Resources</h3>
                <a href="<?= e($basePath ?? '') ?>blog.html">Blog</a>
                <a href="<?= e($basePath ?? '') ?>faq.html">FAQs</a>
                <a href="<?= e($basePath ?? '') ?>support.php">Support</a>
                <a href="<?= e($basePath ?? '') ?>terms.html">Terms &amp; Conditions</a>
            </div>
            <div class="footer-section">
                <h3>Admin</h3>
                <a href="<?= e($basePath ?? '') ?>admin/dashboard.php">Dashboard</a>
                <a href="<?= e($basePath ?? '') ?>admin/events.php">Manage Events</a>
                <a href="<?= e($basePath ?? '') ?>admin/bookings.php">Bookings</a>
                <a href="<?= e($basePath ?? '') ?>admin/support.php">Support Requests</a>
                <a href="<?= e($basePath ?? '') ?>admin/users.php">Users</a>
                <a href="<?= e($basePath ?? '') ?>admin/emails.php">Email Outbox</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 EventHub. All rights reserved.</p>
        </div>
    </footer>
    <script src="<?= e($basePath ?? '') ?>static/js/home.js"></script>
</body>
</html>
