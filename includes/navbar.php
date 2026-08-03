<?php
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$path = strtolower(trim(parse_url($request_uri, PHP_URL_PATH) ?? '', '/'));
$current_page = $path === '' ? 'index.php' : strtolower(basename($path));
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
            <ul id="primary-navigation">
                <li class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                <li class="<?php echo $current_page === 'aboutus.php' ? 'active' : ''; ?>"><a href="aboutus.php">About</a></li>
                <li class="<?php echo $current_page === 'course.php' ? 'active' : ''; ?>"><a href="course.php">Course</a></li>
                <li class="<?php echo $current_page === 'contact.php' ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
            </ul>
            <a class="elearning-link" href="https://elearning.austive.com" target="_blank" rel="noopener noreferrer">E-Learning &rarr;</a>
        </div>
    </nav>
</header>
