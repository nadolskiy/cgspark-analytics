<?php
if ( !defined('ABSPATH') ) {
    //If wordpress isn't loaded load it up.
    $path = $_SERVER['DOCUMENT_ROOT'];
    try {
        include_once $path . '/wp-load.php';
    } catch (\Throwable $th) {
        echo "<script>console.log('ⓟⒽⓟ abspatch.php','Can't include the wp-load.php');</script>"; // TODO: !DELETE ME!
    }
}