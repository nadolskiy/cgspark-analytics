<?php // Connecting header
include_once( PLUGIN_DIR . 'functions/db.php' ); 
include_once( PLUGIN_DIR . 'components/header.php' ); ?>

<div class="container">
    <h2 class="section-separator-title" data-aos="fade-right">ViewPorts</h2>
    <?php include_once( PLUGIN_DIR . 'components/viewport.php')?>
    <h2 class="section-separator-title" data-aos="fade-right">Platforms</h2>
    <?php include_once( PLUGIN_DIR . 'components/platforms.php' ); ?>
    <h2 class="section-separator-title" data-aos="fade-right">Browsers</h2>
    <?php include_once( PLUGIN_DIR . 'components/browsers.php')?>

</div>

<?php // Connecting footer
include_once( PLUGIN_DIR . 'components/footer.php' ); ?>