<?php

include 'includes/db.php';

// 查询课程分类
$stmt = $pdo->query("
    SELECT title_id, course_title
    FROM course_category
    ORDER BY title_id ASC
");

$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';

?>
<body>
<?php include 'includes/navbar.php'; ?>

<section class="hero">

    <div class="hero-content">

        <h1>Your Trusted Human Capital Partner</h1>

        <p>
            Connecting exceptional talent with forward-thinking
            organizations through innovative human resource solutions.
        </p>

        <a href="course.php"><button>View Course</button></a>   

    </div>

</section>

<section class="home-about">

    <div class="home-about-text">
        <p class="home-about-eyebrow">WHO WE ARE</p>
        <h2>People-first learning for <span>lasting growth.</span></h2>

        <div class="home-about-copy">
            <p>Austive Human Capital Sdn. Bhd. helps individuals and organisations build practical skills through quality training and professional development.</p>
            <p>We partner with clients to create learning experiences that strengthen performance, support continuous growth, and prepare people for what is next.</p>
        </div>

        <div class="home-about-points">
            <span>Practical learning</span>
            <span>Trusted partnership</span>
        </div>

    </div>

<div class="home-about-image">

    <img src="images/aboutphoto1.png" class="about-image-main" alt="Participants taking part in a training session">


</div>

</section>

<!-- ================= WHY CHOOSE AUSTIVE ================= -->

<section class="home-why">

    <div class="home-why-container">

        <div class="why-header">

            <p class="section-subtitle">WHY CHOOSE AUSTIVE</p>

            <h2>Your Trusted Partner in Human Capital Development</h2>

            <p>
                We are committed to delivering practical learning
                experiences that empower individuals, strengthen
                organisations and create sustainable business growth.
            </p>

        </div>

        <div class="why-grid">

            <div class="why-item">

                <span>01</span>

                <h3>Experienced Trainers</h3>

                <p>
                    Learn from industry professionals with extensive
                    practical experience across various industries,
                    delivering practical knowledge and real-world insights.
                </p>

            </div>

            <div class="why-item">

                <span>02</span>

                <h3>Industry-Relevant Programmes</h3>

                <p>
                    Our programmes are carefully designed to align with
                    current industry standards, ensuring participants
                    gain practical and applicable workplace skills.
                </p>

            </div>

            <div class="why-item">

                <span>03</span>

                <h3>Flexible Learning Solutions</h3>

                <p>
                    We offer classroom, virtual and e-learning
                    experiences, allowing organisations and individuals
                    to learn anytime, anywhere.
                </p>

            </div>

            <div class="why-item">

                <span>04</span>

                <h3>Practical & Results-Driven</h3>

                <p>
                    Every programme focuses on hands-on learning,
                    helping participants immediately apply new
                    knowledge and skills in the workplace.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ================= TRAINING CATEGORIES ================= -->
<section class="training">

    <div class="training-header">
        <p class="section-subtitle">TRAINING CATEGORIES</p>
        <h2>Explore Our Training Programmes</h2>
        <p class="training-intro">
            Choose from a wide range of professional training courses designed to strengthen skills and support career growth.
        </p>
    </div>
    <?php foreach (array_slice($courses, 0, 6) as $index => $course): ?>

    <a href="training-category.php?id=<?= $course['title_id'] ?>" class="training-item">

        <span class="training-number">
            <?= str_pad($index + 1, 2, "0", STR_PAD_LEFT) ?>
        </span>

        <div class="training-content">
            <h3><?= htmlspecialchars($course['course_title']) ?></h3>
        </div>

        <div class="training-right">
            <span class="arrow">→</span>
        </div>

    </a>

    <?php endforeach; ?>

    <div class="training-btn">

    <a href="course.php" class="view-course-btn">
        View All Courses →
    </a>

</div>
</section>
<!-- ================= TESTIMONIALS ================= -->

<section class="home-testimonial">

    <div class="home-testimonial-container">

        <div class="testimonial-header">

            <h2>What Our Clients Say</h2>

        </div>

        <div class="testimonial-list">

            <!-- Testimonial 1 -->

            <div class="testimonial-item">

                <div class="testimonial-top">

                    <span class="testimonial-rating">★★★★★</span>

                </div>

                <p class="testimonial-text">
                    Austive Human Capital provides us with top class training courses and consultants. 
                    We are happy and proud to have them as our training partner! 
                </p>

                <div class="testimonial-author">

                    <h4>Human Resource Manager</h4>

                    <span>Corporate Client</span>

                </div>

            </div>

            <!-- Testimonial 2 -->

            <div class="testimonial-item">

                <div class="testimonial-top">

                    <span class="testimonial-rating">★★★★★</span>

                </div>

                <p class="testimonial-text">
                    Our management involves providing formal training for all employees annually and having relevent 
                    professional certification. Austive Human Capital worked closely with us to help us achieve significant 
                    amount of savings, through participation in various grants and benefits. It has been a pleasure to 
                    have Austive Human Capital as our training partner.
                </p>

                <div class="testimonial-author">

                    <h4>Operations Manager</h4>

                    <span>Corporate Client</span>

                </div>

            </div>

            <!-- Testimonial 3 -->

            <div class="testimonial-item">

                <div class="testimonial-top">

                    <span class="testimonial-rating">★★★★★</span>

                </div>

                <p class="testimonial-text">
                    Great patience was shown to understand our requirements and training sessions were well-coordinated 
                    with highly qualified instructions which ultimately met all our requirements.
                </p>

                <div class="testimonial-author">

                    <h4>Training Executive</h4>

                    <span>Corporate Client</span>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= CLIENTS ================= -->

<section class="home-clients">

    <div class="clients-header">

        <p class="section-subtitle">OUR CLIENTS</p>

        <h2>Trusted by Leading Organisations</h2>

        <p>
            We are proud to partner with organisations from various
            industries, delivering professional training and human
            capital development solutions.
        </p>

    </div>

    <div class="clients-slider">

        <div class="clients-track">

            <!-- 第一组 -->

            <img src="images/logo/logo1.png" alt="Client">
            <img src="images/logo/logo2.png" alt="Client">
            <img src="images/logo/logo3.png" alt="Client">
            <img src="images/logo/logo4.png" alt="Client">
            <img src="images/logo/logo5.png" alt="Client">
            <img src="images/logo/logo6.png" alt="Client">
            <img src="images/logo/logo7.png" alt="Client">
            <img src="images/logo/logo8.png" alt="Client">
            <img src="images/logo/logo9.png" alt="Client">
            <img src="images/logo/logo10.png" alt="Client">
            <img src="images/logo/logo11.png" alt="Client">
            <img src="images/logo/logo12.png" alt="Client">
            <img src="images/logo/logo13.png" alt="Client">
            <img src="images/logo/logo14.png" alt="Client">
            <img src="images/logo/logo15.png" alt="Client">
            <img src="images/logo/logo16.png" alt="Client">
            <img src="images/logo/logo17.png" alt="Client">
            <img src="images/logo/logo18.png" alt="Client">
            <img src="images/logo/logo19.png" alt="Client">
            <img src="images/logo/logo20.png" alt="Client">
            <img src="images/logo/logo21.png" alt="Client">
            <img src="images/logo/logo22.png" alt="Client">
            <img src="images/logo/logo23.png" alt="Client">
            <img src="images/logo/logo24.png" alt="Client">
            <img src="images/logo/logo25.png" alt="Client">
            <img src="images/logo/logo26.png" alt="Client">
            <img src="images/logo/logo27.png" alt="Client">
            <img src="images/logo/logo28.png" alt="Client">
            <img src="images/logo/logo29.png" alt="Client">
            <img src="images/logo/logo30.png" alt="Client">
            <img src="images/logo/logo31.png" alt="Client">
            <img src="images/logo/logo32.png" alt="Client">
            <img src="images/logo/logo33.png" alt="Client">
            <img src="images/logo/logo34.png" alt="Client">
            <img src="images/logo/logo35.png" alt="Client">
            <img src="images/logo/logo36.png" alt="Client">
            <img src="images/logo/logo37.png" alt="Client">

            <!-- 复制一份，做无限滚动 -->

            <img src="images/logo/logo2.png" alt="Client">
            <img src="images/logo/logo3.png" alt="Client">
            <img src="images/logo/logo4.png" alt="Client">
            <img src="images/logo/logo5.png" alt="Client">
            <img src="images/logo/logo6.png" alt="Client">
            <img src="images/logo/logo7.png" alt="Client">
            <img src="images/logo/logo8.png" alt="Client">
            <img src="images/logo/logo9.png" alt="Client">
            <img src="images/logo/logo10.png" alt="Client">
            <img src="images/logo/logo11.png" alt="Client">
            <img src="images/logo/logo12.png" alt="Client">
            <img src="images/logo/logo13.png" alt="Client">
            <img src="images/logo/logo14.png" alt="Client">
            <img src="images/logo/logo15.png" alt="Client">
            <img src="images/logo/logo16.png" alt="Client">
            <img src="images/logo/logo17.png" alt="Client">
            <img src="images/logo/logo18.png" alt="Client">
            <img src="images/logo/logo19.png" alt="Client">
            <img src="images/logo/logo20.png" alt="Client">
            <img src="images/logo/logo21.png" alt="Client">
            <img src="images/logo/logo22.png" alt="Client">
            <img src="images/logo/logo23.png" alt="Client">
            <img src="images/logo/logo24.png" alt="Client">
            <img src="images/logo/logo25.png" alt="Client">
            <img src="images/logo/logo26.png" alt="Client">
            <img src="images/logo/logo27.png" alt="Client">
            <img src="images/logo/logo28.png" alt="Client">
            <img src="images/logo/logo29.png" alt="Client">
            <img src="images/logo/logo30.png" alt="Client">
            <img src="images/logo/logo31.png" alt="Client">
            <img src="images/logo/logo32.png" alt="Client">
            <img src="images/logo/logo33.png" alt="Client">
            <img src="images/logo/logo34.png" alt="Client">
            <img src="images/logo/logo35.png" alt="Client">
            <img src="images/logo/logo36.png" alt="Client">
            <img src="images/logo/logo37.png" alt="Client">

        </div>

    </div>

</section>

<?php

include 'includes/footer.php';

?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sections = document.querySelectorAll('.hero, .home-about, .home-why, .training, .home-testimonial, .home-services');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            sections.forEach(function (section) {
                observer.observe(section);
            });
        } else {
            sections.forEach(function (section) {
                section.classList.add('is-visible');
            });
        }
    });
</script>

</body>
</html>
