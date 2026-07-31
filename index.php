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
include 'includes/navbar.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Austive Human Capital Sdn Bhd</title>

    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<section class="hero">

    <div class="hero-content">

        <h1>Your Trusted Human Capital Partner</h1>

        <p>
            Connecting exceptional talent with forward-thinking
            organizations through innovative human resource solutions.
        </p>

        <button>View Course</button>

    </div>

</section>

<section class="home-about">

    <div class="home-about-text">

        <h2>About Us</h2>

        <p>
            Austive Human Capital Sdn. Bhd. is committed to empowering individuals and organisations through quality human capital 
            development and professional training. We believe that people are the foundation of every successful business, which is 
            why we strive to provide practical learning experiences that enhance skills, improve performance, and support long-term 
            growth.<br><br>

            With a strong focus on professionalism, innovation, and continuous learning, we work closely with our clients to deliver 
            training solutions that meet today's evolving workforce needs. Our goal is to become a trusted partner in developing capable 
            talent and building a stronger future for businesses and communities.
        </p>

    </div>

<div class="home-about-image">

    <img src="images/aboutphoto1.png" class="photo position1" alt="About Us">


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

    <?php foreach ($courses as $index => $course): ?>

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
</section>
<!-- ================= TESTIMONIALS ================= -->

<section class="home-testimonial">

    <div class="home-testimonial-container">

        <div class="testimonial-header">

            <p class="section-subtitle">TESTIMONIALS</p>

            <h2>What Our Clients Say</h2>

            <p>
                Austive Human Capital provides us with top class training courses and consultants. We are happy and proud to have 
                them as our training partner! 
            </p>

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

<?php

include 'includes/footer.php';

?>

<script src="js/main.js"></script>
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