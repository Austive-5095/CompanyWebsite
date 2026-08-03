<?php
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$path = trim(parse_url($request_uri, PHP_URL_PATH) ?? '', '/');

// Hosts can hide the .php extension (for example /aboutus instead of
// /aboutus.php), so compare the route name rather than the literal URL.
$current_page = strtolower(pathinfo(basename($path), PATHINFO_FILENAME));
if ($current_page === '' || $current_page === 'index') {
    $current_page = 'home';
}
?>
<header id="header">
    <nav class="navbar">
        <div class="logo">

            <a href="/" class="logo-link">

                <img src="/images/logocompany.png" alt="Austive Human Capital Sdn Bhd" class="logo-img">

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
                <li class="<?php echo $current_page === 'home' ? 'active' : ''; ?>"><a href="/">Home</a></li>
                <li class="<?php echo $current_page === 'aboutus' ? 'active' : ''; ?>"><a href="/aboutus.php">About</a></li>
                <li class="<?php echo $current_page === 'course' ? 'active' : ''; ?>"><a href="/course.php">Course</a></li>
                <li class="<?php echo $current_page === 'contact' ? 'active' : ''; ?>"><a href="/contact.php">Contact</a></li>
            </ul>
            <a class="elearning-link" href="https://elearning.austive.com" target="_blank" rel="noopener noreferrer">E-Learning &rarr;</a>
        </div>
    </nav>
</header>
