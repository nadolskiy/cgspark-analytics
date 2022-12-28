<?php // Connecting header
include_once( PLUGIN_DIR . 'functions/db.php' ); 
include_once( PLUGIN_DIR . 'pages/sections/header.php' ); ?>

<div class="container">
    <h1 data-aos="fade-right">Redirect Plugin</h1>
    <?php include_once( PLUGIN_DIR . 'pages/sections/numbers.php' ); ?>
    <?php include_once( PLUGIN_DIR . 'pages/sections/list.php' ); ?>
    <?php include_once( PLUGIN_DIR . 'pages/sections/add-rule.php' ); ?>
    <?php include_once( PLUGIN_DIR . 'pages/sections/remove.php' ); ?>
</div>

<?php // Connecting footer
include_once( PLUGIN_DIR . 'pages/sections/footer.php' ); ?>