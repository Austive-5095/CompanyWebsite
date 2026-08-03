<?php
// Compute a base href so that relative URLs resolve correctly
// when the site is served from pretty URLs or a subdirectory.
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($base === '' || $base === '.') {
      $base = '/';
} else {
      $base = $base . '/';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

      <meta charset="UTF-8">

      <meta name="viewport"
              content="width=device-width, initial-scale=1.0">

      <title>Austive Human Capital Sdn Bhd</title>

      <base href="<?php echo $base; ?>">

      <!-- CSS -->

      <link rel="stylesheet" href="css/style.css?v=20260731">
      <link rel="stylesheet" href="css/headerfooter.css?v=20260731">
      <link rel="stylesheet" href="css/aboutus.css">
      <link rel="stylesheet" href="css/contact.css">
      <link rel="stylesheet" href="css/home-animate.css?v=20260731">
      <link rel="stylesheet" href="css/responsive.css?v=20260731">
      <link rel="stylesheet" href="css/course.css?v=20260731">
      <script src="js/main.js?v=20260731" defer></script>


      <!-- Font Awesome -->
      <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

