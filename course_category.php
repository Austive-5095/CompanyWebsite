<?php

include 'includes/db.php';

// Validate title_id is a valid positive integer
$raw = $_GET['title_id'] ?? '';

if (!is_string($raw) || !ctype_digit($raw) || (int) $raw <= 0) {
    header('Location: course.php');
    exit;
}

$title_id = (int) $raw;

// Verify the category exists (before fetching any courses)
$catStmt = $pdo->prepare("
    SELECT title_id, course_title
    FROM course_category
    WHERE title_id = ?
");
$catStmt->execute([$title_id]);
$category = $catStmt->fetch(PDO::FETCH_ASSOC);

include 'includes/header.php';
include 'includes/navbar.php';

// Category does not exist -> show message, never display all courses
if (!$category):
?>

<div class="trainer-back">
    <a href="javascript:history.back()" class="back-link">
        ← Back
    </a>
</div>

<section class="course-list">

    <div class="course-header">

        <p class="section-subtitle">COURSE CATALOGUE</p>

        <h1>Category not found.</h1>

    </div>

</section>

<?php
include 'includes/footer.php';
exit;
endif;

// Fetch the courses belonging to this category (parameterized)
$stmt = $pdo->prepare("
    SELECT
        id,
        course_name,
        description,
        price
    FROM courses
    WHERE course_title_id = ?
    ORDER BY id ASC
");
$stmt->execute([$title_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="trainer-back">
    <a href="javascript:history.back()" class="back-link">
        ← Back
    </a>
</div>

<section class="course-list">

    <div class="course-header">

        <p class="section-subtitle">COURSE CATALOGUE</p>

        <h1><?= htmlspecialchars($category['course_title']) ?></h1>

        <p class="category-intro">
            Browse our complete range of professional training programmes
            designed to support workforce development and organisational
            excellence.
        </p>

    </div>

    <hr class="category-divider">

    <?php if (empty($courses)): ?>

    <p class="category-empty">No courses available in this category yet.</p>

    <?php else: ?>

    <div class="category-course-list">

        <?php foreach ($courses as $course): ?>

        <div class="category-course-item">

            <h2 class="category-course-name"><?= htmlspecialchars($course['course_name']) ?></h2>

            <hr class="category-course-divider">

            <?php if (!empty($course['description'])): ?>
            <p class="category-course-desc"><?= nl2br(htmlspecialchars(trim($course['description']))) ?></p>
            <?php endif; ?>

            <p class="category-course-price"><?= isset($course['price']) && !is_null($course['price']) ? 'RM ' . number_format((float) $course['price'], 2) : 'Price on request' ?></p>

        </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

</section>

<?php

include 'includes/footer.php';

?>
