<?php

function pr($var) {
    echo '<pre>' . print_r($var, 1) . '</pre>';
}

//pr($_SERVER); exit;

require "../vendor/autoload.php";
require "../app/app.php";
