<?php
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$path = trim(parse_url($request_uri, PHP_URL_PATH) ?? '', '/');
$query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
$current_page = strtolower(pathinfo(basename($path), PATHINFO_FILENAME));

if ($current_page === '' || $current_page === 'index') {
    $current_page = 'home';
}

if ($query !== '' && strpos($query, 'about') !== false) {
    $current_page = 'aboutus';
}

if ($query !== '' && strpos($query, 'course') !== false) {
    $current_page = 'course';
}

if ($query !== '' && strpos($query, 'contact') !== false) {
    $current_page = 'contact';
}
?>
<header id="header">
    <nav class="navbar">
        <div class="logo">

            <a href="index.php" class="logo-link">

                <img src="images/logocompany.png" alt="Company Logo" class="logo-img">

                <span class="logo-text">
                    AUSTIVE HUMAN CAPITAL Sdn Bhd
                </span>

            </a>

        </div>
        <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-controls="primary-navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-actions">
            <p style="display:none;">current_page=<?php echo htmlspecialchars($current_page); ?> path=<?php echo htmlspecialchars($path); ?></p>
            <ul id="primary-navigation">
                <li class="<?php echo $current_page === 'home' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                <li class="<?php echo $current_page === 'aboutus' ? 'active' : ''; ?>"><a href="aboutus.php">About</a></li>
                <li class="<?php echo $current_page === 'course' ? 'active' : ''; ?>"><a href="course.php">Course</a></li>
                <li class="<?php echo $current_page === 'contact' ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
            </ul>
            <a class="elearning-link" href="https://elearning.austive.com" target="_blank" rel="noopener noreferrer">E-Learning &rarr;</a>
        </div>
    </nav>
</header>
