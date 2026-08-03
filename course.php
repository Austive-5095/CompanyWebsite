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

<div class="trainer-back">
    <a href="javascript:history.back()" class="back-link">
        ← Back
    </a>
</div>

<section class="course-list">

    <div class="course-header">

        <p class="section-subtitle">COURSE CATALOGUE</p>

        <h1>Professional Learning Programmes</h1>

        <p>
            Browse our complete range of professional training programmes
            designed to support workforce development and organisational
            excellence.
        </p>

    </div>

    <?php foreach($courses as $index => $course): ?>

    <a href="#" class="course-item">

        <div class="course-no">
            <?= str_pad($index + 1, 2, "0", STR_PAD_LEFT) ?>
        </div>

        <div class="course-title">

            <h2><?= htmlspecialchars($course['course_title']) ?></h2>

        </div>

        <div class="course-arrow">
            →
        </div>

    </a>

    <?php endforeach; ?>

</section>

<?php

include 'includes/footer.php';

?>
