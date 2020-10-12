<?php
// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);
?>
