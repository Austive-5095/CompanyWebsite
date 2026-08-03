<?php
$page_title = 'Contact Us | Austive Human Capital';
include 'includes/header.php';
?>

<body class="contact-page">

<?php include 'includes/navbar.php'; ?>

<section class="contact-hero">
    <div class="contact-hero-inner">
        <p class="contact-eyebrow">Contact Us</p>
        <h1>Let’s talk about your next learning journey</h1>
        <p>
            We support course enquiries, corporate training, certification guidance,
            and partnership discussions with a calm, thoughtful experience.
        </p>
    </div>
</section>

<main class="contact-main">

    <section class="contact-grid">

        <aside class="contact-card contact-card-info">
            <h2>Reach Us</h2>
            <p>Our team will help you find the right training solution for your organisation.</p>

            <div class="contact-list">

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h3>Office Address</h3>
                        <p>
                            9&9, 01 Jalan Kempas Indah 1/3,<br>
                            Taman Kempas Indah, 81300 Skudai,<br>
                            Johor Darul Ta'zim
                        </p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h3>Phone</h3>
                        <p><a href="tel:+60126309119">012-630 9119 (Christopher)</a></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h3>Email</h3>
                        <p>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=christophertey81@gmail.com&su=Enquiry%20from%20Website&body=Hi%20Christopher,%0D%0A%0D%0AI%20would%20like%20to%20enquire%20about...">
                                christophertey81@gmail.com
                            </a>
                        </p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fa-brands fa-facebook-f"></i>
                    </div>
                    <div>
                        <h3>Facebook</h3>
                        <p>
                            <a href="https://www.facebook.com/p/Austive-Human-Capital-Management-100083652972042/" target="_blank" rel="noopener">
                                Austive Human Capital Management
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </aside>

        <section class="contact-card contact-card-form">
            <h2>Send an Enquiry</h2>
            <p>Fill in the details below and we will get back to you as soon as possible.</p>

            <?php
            if (isset($_GET['status']) && $_GET['status'] === 'success') {
                echo '<p class="contact-status success">Your enquiry has been sent successfully.</p>';
            } elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
                echo '<p class="contact-status error">Sorry, your enquiry could not be sent. Please try again later.</p>';
            }
            ?>

            <form class="contact-form" action="submit_enquiry.php" method="post">
                <div class="contact-field">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Your name" required>
                </div>

                <div class="contact-field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="contact-field">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="e.g. 01X-XXX XXXX" required>
                </div>

                <div class="contact-field">
                    <label for="topic">Enquiry Type</label>
                    <select id="topic" name="topic" required>
                        <option value="">Select an option</option>
                        <option value="Course Enquiry">Course Enquiry</option>
                        <option value="Corporate Training">Corporate Training</option>
                        <option value="Certification Support">Certification Support</option>
                        <option value="Partnership">Partnership</option>
                    </select>
                </div>

                <div class="contact-field full">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Tell us what you need help with" required></textarea>
                </div>

                <div class="contact-field full">
                    <button type="submit" class="contact-submit">Send Message</button>
                </div>
            </form>
        </section>

    </section>

    <section class="contact-map-card">
        <div>
            <h2>Business Hours</h2>
            <div class="contact-hours">
                <div class="contact-hour-row">
                    <strong>Monday - Friday</strong>
                    <span>9:00 AM - 6:00 PM</span>
                </div>
                <div class="contact-hour-row">
                    <strong>Saturday</strong>
                    <span>Closed</span>
                </div>
                <div class="contact-hour-row">
                    <strong>Sunday</strong>
                    <span>Closed</span>
                </div>
            </div>
        </div>

        <div class="contact-map-note">
            <h3>Visit Our Office</h3>
            <p>
                We are based in Skudai, Johor and support companies across Malaysia
                with professional training and development programmes.
            </p>
        </div>
    </section>

    <div class="contact-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4907.544105902628!2d103.71514237581596!3d1.5527281608883874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da6ff9abf70d61%3A0x8fa8eaf55d11c9d1!2sAustive%20Human%20Capital%20Management!5e1!3m2!1sen!2smy!4v1782976144866!5m2!1sen!2smy"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin">
        </iframe>
    </div>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
