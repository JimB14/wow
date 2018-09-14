<?php

// Security function for posted data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Security function for displaying data (POST or GET)
function html($text){
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
function htmlout($text) {
    echo html($text);
}