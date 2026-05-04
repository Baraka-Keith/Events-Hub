CREATE DATABASE IF NOT EXISTS eventhub_uk
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE eventhub_uk;

DROP TABLE IF EXISTS support_requests;
DROP TABLE IF EXISTS support_messages;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS newsletter_subscribers;
DROP TABLE IF EXISTS email_outbox;
DROP TABLE IF EXISTS login_verification_codes;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','client') NOT NULL DEFAULT 'client',
  status ENUM('active','disabled') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE login_verification_codes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  code_hash VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  used_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE email_outbox (
  id INT AUTO_INCREMENT PRIMARY KEY,
  recipient_email VARCHAR(160) NOT NULL,
  recipient_name VARCHAR(120) NOT NULL,
  subject VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  email_type ENUM('login_code','ticket_confirmation','support_update','general') NOT NULL DEFAULT 'general',
  status ENUM('queued','sent','failed') NOT NULL DEFAULT 'queued',
  related_booking_id INT NULL,
  related_user_id INT NULL,
  sent_at DATETIME NULL,
  error_message TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (related_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  category VARCHAR(80) NOT NULL,
  city VARCHAR(80) NOT NULL,
  venue VARCHAR(160) NOT NULL,
  event_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  capacity INT NOT NULL DEFAULT 100,
  image_path VARCHAR(255) NOT NULL,
  summary VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  business_need TEXT NOT NULL,
  status ENUM('draft','published','closed') NOT NULL DEFAULT 'published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  ticket_type VARCHAR(80) NOT NULL,
  access_description VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  available_quantity INT NOT NULL DEFAULT 50,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_reference VARCHAR(20) NOT NULL UNIQUE,
  event_id INT NOT NULL,
  ticket_id INT NOT NULL,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NULL,
  organisation VARCHAR(160) NULL,
  quantity INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  payment_method ENUM('apple_pay','card','paypal','bank_transfer','pay_at_door') NOT NULL DEFAULT 'card',
  payment_status ENUM('demo_authorised','pending','paid','failed') NOT NULL DEFAULT 'demo_authorised',
  notes TEXT NULL,
  status ENUM('pending','confirmed','needs_review','cancelled') NOT NULL DEFAULT 'confirmed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(id),
  FOREIGN KEY (ticket_id) REFERENCES tickets(id)
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NULL,
  subject VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  status ENUM('new','read','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE support_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  support_type VARCHAR(80) NOT NULL,
  related_event_id INT NULL,
  subject VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  status ENUM('open','in_progress','resolved') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (related_event_id) REFERENCES events(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE support_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  support_request_id INT NOT NULL,
  sender_role ENUM('client','admin') NOT NULL,
  sender_name VARCHAR(120) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (support_request_id) REFERENCES support_requests(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE newsletter_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO events
(title, slug, category, city, venue, event_date, start_time, end_time, capacity, image_path, summary, description, business_need, status)
VALUES
('TechConnect 2026', 'techconnect-2026', 'Technology', 'London', 'ExCeL London', '2026-06-18', '09:00:00', '18:00:00', 2000, 'img/techeu-summit-25-1-987.webp', 'A flagship UK technology conference for innovators, students, founders, and digital teams.', 'TechConnect brings together keynote talks, hands-on workshops, product showcases, and structured networking for people building or adopting digital technology.', 'Helps professionals and employers discover practical technology trends, meet partners, and upskill teams in one day.', 'published'),
('Creative Design Summit 2026', 'creative-design-summit-2026', 'Design', 'Manchester', 'Manchester Design Centre', '2026-07-09', '10:00:00', '17:00:00', 900, 'img/design.jpeg', 'A design and innovation event for UX, branding, product, and creative teams.', 'The summit focuses on user-centred design, inclusive interfaces, creative strategy, and portfolio development through talks and practical sessions.', 'Supports creative professionals and businesses who need stronger user experiences and more competitive digital products.', 'published'),
('Business Leadership Forum 2026', 'business-leadership-forum-2026', 'Business', 'Edinburgh', 'Edinburgh Conference Centre', '2026-08-21', '09:00:00', '17:30:00', 1200, 'img/forum.webp', 'A leadership event for founders, managers, and growing organisations.', 'This forum offers keynote talks, leadership panels, finance guidance, and networking opportunities for organisations preparing for growth.', 'Connects businesses with leadership insight, peer learning, and commercial partnerships.', 'published'),
('Digital Marketing Conference 2026', 'digital-marketing-conference-2026', 'Marketing', 'Birmingham', 'Birmingham Business Hub', '2026-09-15', '10:00:00', '16:30:00', 850, 'img/digital-marketing-uk.jpeg', 'A practical conference covering SEO, paid media, analytics, and campaign planning.', 'Attendees learn modern digital marketing tactics through case studies, workshops, and campaign review sessions led by industry practitioners.', 'Helps small businesses and marketing teams improve campaign performance and customer reach.', 'published'),
('AI and Machine Learning Summit 2026', 'ai-machine-learning-summit-2026', 'Technology', 'London', 'London Innovation Hall', '2026-10-06', '09:30:00', '17:30:00', 1500, 'img/International-Conference-on-Artificial-Intelligence-and-Machine-Learning.webp', 'A focused event about AI tools, machine learning, responsible adoption, and automation.', 'The summit explores practical machine learning, data strategy, AI ethics, automation workflows, and organisational readiness.', 'Supports businesses and students who need to understand how AI can be adopted responsibly and effectively.', 'published');

INSERT INTO users (full_name, email, password_hash, role)
VALUES
('EventHub Admin', 'admin@eventhub.test', '$2y$10$ibWnQpCQ6TKEpsJGc87Tpuby2TeR3a21AcWd0oD/9oXDioWyNKwD.', 'admin'),
('Client Demo User', 'client@eventhub.test', '$2y$10$gC7a/KmULs7vkucN6uGoWewhNAv.ROPHTfLba3w2hTU2Ms3Vukvwi', 'client');

INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Student', 'Discounted entry with valid student ID', 149.00, 120 FROM events WHERE slug = 'techconnect-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Standard', 'Main event access and networking sessions', 299.00, 1200 FROM events WHERE slug = 'techconnect-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Premium', 'Priority seating, workshop access, and premium lounge', 499.00, 300 FROM events WHERE slug = 'techconnect-2026';

INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Student', 'Discounted summit access with student ID', 99.00, 100 FROM events WHERE slug = 'creative-design-summit-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Standard', 'Main summit talks and networking', 199.00, 650 FROM events WHERE slug = 'creative-design-summit-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Premium', 'Workshop pass and portfolio review access', 349.00, 150 FROM events WHERE slug = 'creative-design-summit-2026';

INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Student', 'Discounted forum entry with valid ID', 129.00, 80 FROM events WHERE slug = 'business-leadership-forum-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Standard', 'Main sessions and networking', 249.00, 800 FROM events WHERE slug = 'business-leadership-forum-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Premium', 'Priority seating and private roundtable access', 429.00, 180 FROM events WHERE slug = 'business-leadership-forum-2026';

INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Student', 'Discounted marketing conference entry', 89.00, 100 FROM events WHERE slug = 'digital-marketing-conference-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Standard', 'Main conference access', 179.00, 600 FROM events WHERE slug = 'digital-marketing-conference-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Premium', 'Campaign workshop and expert clinic access', 299.00, 150 FROM events WHERE slug = 'digital-marketing-conference-2026';

INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Student', 'Discounted AI summit entry', 159.00, 120 FROM events WHERE slug = 'ai-machine-learning-summit-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Standard', 'Main summit talks and networking', 329.00, 900 FROM events WHERE slug = 'ai-machine-learning-summit-2026';
INSERT INTO tickets (event_id, ticket_type, access_description, price, available_quantity)
SELECT id, 'Premium', 'Specialist sessions and priority seating', 549.00, 240 FROM events WHERE slug = 'ai-machine-learning-summit-2026';

INSERT INTO bookings (booking_reference, event_id, ticket_id, full_name, email, phone, organisation, quantity, total_amount, payment_method, payment_status, notes, status)
SELECT 'BK-26001', e.id, t.id, 'Client Demo User', 'client@eventhub.test', '07123456789', 'EventHub Client', 1, t.price, 'apple_pay', 'demo_authorised', 'Seed booking for client dashboard demonstration', 'confirmed'
FROM events e JOIN tickets t ON t.event_id = e.id AND t.ticket_type = 'Premium'
WHERE e.slug = 'techconnect-2026';

INSERT INTO bookings (booking_reference, event_id, ticket_id, full_name, email, phone, organisation, quantity, total_amount, payment_method, payment_status, notes, status)
SELECT 'BK-26002', e.id, t.id, 'Amina Yusuf', 'amina@example.com', '07111111111', 'University of Wolverhampton', 2, t.price * 2, 'card', 'demo_authorised', 'Accessibility seating requested', 'needs_review'
FROM events e JOIN tickets t ON t.event_id = e.id AND t.ticket_type = 'Standard'
WHERE e.slug = 'business-leadership-forum-2026';

INSERT INTO support_requests (full_name, email, support_type, related_event_id, subject, message, status)
SELECT 'Daniel Reed', 'daniel@example.com', 'Booking Support', id, 'Can I change my ticket type?', 'I booked a standard ticket and would like to upgrade to premium if possible.', 'open'
FROM events WHERE slug = 'creative-design-summit-2026';

INSERT INTO support_messages (support_request_id, sender_role, sender_name, message)
SELECT id, 'client', full_name, message FROM support_requests WHERE email = 'daniel@example.com';

INSERT INTO contact_messages (full_name, email, phone, subject, message, status)
VALUES ('Rachel Cole', 'rachel@example.com', '07122222222', 'Partnership enquiry', 'I would like to discuss listing our professional training event on EventHub.', 'new');
