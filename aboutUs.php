<?php

include 'includes/header.php';
include 'includes/navbar.php';

?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Austive Human Capital Sdn Bhd</title>

    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<!-- ================= ABOUT US ================= -->

<section class="about">

    <div class="about-text">

        <p class="section-subtitle">ABOUT US</p>

        <h2>Empowering People.<br>Transforming Organizations</h2>

        <p>
            Austive Human Capital Sdn Bhd is committed to empowering
            individuals and organizations through professional training,
            certification programmes, and innovative human capital solutions.
            We believe in developing talent, enhancing workplace performance,
            and supporting lifelong learning through both classroom and
            digital learning experiences.
        </p>

    </div>

    <div class="about-image">

        <img src="images/background.png" alt="Austive Team">

    </div>

</section>

<!-- ================= TEAM ================= -->

<section class="team">

    <p class="section-subtitle">OUR TEAM</p>

    <h2>Meet Our Professional Team</h2>

    <p class="team-description">
        Our dedicated team combines industry knowledge,
        professional experience and a passion for helping
        individuals and organizations achieve success.
    </p>

    <div class="team-container">

        <a href="stellar.php" class="team-card member1">

            <img src="images/stellar.png">

            <h3>Stellar Lee Yoke Siew</h3>

            <span>ISO Trainer</span>

        </a>

        <a href="alanox.php" class="team-card member2">

            <img src="images/alanox.png" alt="Tan Chien Loon (Alanox)">

            <h3>Tan Chien Loon (Alanox)</h3>
            
            <span>Teambuilding Trainer</span>
        </a>

        <div class="team-card member3">
            <img src="images/annie.png" alt="Annie Wong Loo Kim">
            <h3>Annie Wong Loo Kim</h3>
            <span>Accounting & Financial Trainer</span>
        </div>

        <div class="team-card member4">
            <img src="images/alex.png" alt="Dr Alex Tan Wei Liang">
            <h3>Dr Alex Tan Wei Liang</h3>
            <span>Quality Improvement Management</span>
        </div>

        <div class="team-card member5">
            <img src="images/liew.png" alt="Liew Weng Kong">
            <h3>Liew Weng Kong</h3>
            <span>Motivation Trainer</span>
        </div>

        <div class="team-card member6">
            <img src="images/nizam.png" alt="Mohd Nizam Bin Mohd Amin">
            <h3>Mohd Nizam Bin Mohd Amin</h3>
            <span>Operation Excellence Trainer</span>
        </div>

        <div class="team-card member7">
            <img src="images/yunus.png" alt="Mohd Yunus Omar">
            <h3>Mohd Yunus Omar</h3>
            <span>Trainer</span>
        </div>

    </div>

</section>

<!-- ================= CLIENTS ================= -->

<section class="clients">

    <p class="section-subtitle">OUR CLIENTS</p>

    <h2>Our Valued Clients</h2>

    <p class="clients-description">
        We are proud to work with a diverse range of clients and organizations across industries.
    </p>

    <div class="clients-grid">

        <?php
        $clientLogos = [];
        for ($i = 1; $i <= 36; $i++) {
            $clientLogos[] = 'logo' . $i . '.png';
        }

        foreach ($clientLogos as $logo) {
            echo '<div class="client-item"><img src="images/logo/' . $logo . '" alt="Client logo"></div>';
        }
        ?>

    </div>

</section>

<!-- ================= GALLERY ================= -->

<section class="gallery">

    <p class="section-subtitle">GALLERY</p>

    <h2>Moments That Matter</h2>

    <p class="gallery-description">
        Explore our training sessions, practical activities and the people behind our work.
    </p>

    <div class="gallery-filters" role="tablist" aria-label="Gallery filters">
        <button class="gallery-filter active" data-filter="all" aria-pressed="true">ALL</button>
        <button class="gallery-filter" data-filter="learning" aria-pressed="false">LEARNING & TRAINING</button>
        <button class="gallery-filter" data-filter="hands-on" aria-pressed="false">HANDS-ON SESSIONS</button>
        <button class="gallery-filter" data-filter="team" aria-pressed="false">TEAM & COMMUNITY</button>
    </div>

    <div class="gallery-grid" id="galleryGrid">

        <article class="gallery-item featured-large" data-category="learning">
            <img src="images/aboutphoto1.png" alt="Learners engaged in discussion">
            <div class="gallery-caption">Learning & Training</div>
        </article>

        <article class="gallery-item feature-medium" data-category="learning">
            <img src="images/aboutphoto2.webp" alt="Focused group discussion during training">
            <div class="gallery-caption">Focused Discussion</div>
        </article>

        <article class="gallery-item feature-medium" data-category="learning">
            <img src="images/aboutphoto4.webp" alt="Participants completing worksheets during training">
            <div class="gallery-caption">Practical Learning</div>
        </article>

        <article class="gallery-item feature-small" data-category="learning">
            <img src="images/aboutphoto9.webp" alt="Instructor leading a learning session">
            <div class="gallery-caption">Instructor-led Session</div>
        </article>

        <article class="gallery-item feature-small" data-category="hands-on">
            <img src="images/aboutphoto6.webp" alt="Large screen explanation during a practical session">
            <div class="gallery-caption">Clear Instruction</div>
        </article>

        <article class="gallery-item feature-small" data-category="hands-on">
            <img src="images/aboutphoto11.png" alt="First-aid practical demonstration">
            <div class="gallery-caption">Practical Application</div>
        </article>

        <article class="gallery-item feature-medium" data-category="team">
            <img src="images/aboutphoto7.webp" alt="Team gathering and community activity">
            <div class="gallery-caption">Team Gathering</div>
        </article>

        <article class="gallery-item feature-medium" data-category="team">
            <img src="images/aboutphoto8.webp" alt="Group photo during a company activity">
            <div class="gallery-caption">Shared Experience</div>
        </article>

        <article class="gallery-item feature-small" data-category="team">
            <img src="images/aboutphoto10.webp" alt="Training completion and seminar group photo">
            <div class="gallery-caption">Community Connection</div>
        </article>

        <article class="gallery-item feature-small" data-category="all">
            <img src="images/aboutphoto3.webp" alt="A professional training environment">
            <div class="gallery-caption">Professional Setting</div>
        </article>

    </div>

</section>

<?php

include 'includes/footer.php';

?>

<script src="js/main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filters = document.querySelectorAll('.gallery-filter');
        const items = document.querySelectorAll('.gallery-item');
        const grid = document.getElementById('galleryGrid');

        filters.forEach(function (button) {
            button.addEventListener('click', function () {
                const filter = this.getAttribute('data-filter');

                filters.forEach(function (item) {
                    item.classList.remove('active');
                    item.setAttribute('aria-pressed', 'false');
                });

                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');

                grid.classList.add('is-changing');

                setTimeout(function () {
                    items.forEach(function (item) {
                        const category = item.getAttribute('data-category');
                        const shouldShow = filter === 'all' || category === filter;
                        item.classList.toggle('is-hidden', !shouldShow);
                    });

                    grid.classList.remove('is-changing');
                }, 180);
            });
        });
    });
</script>

</body>
</html>