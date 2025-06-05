<?php
// SECURE: Sanitized logging of User-Agent input.

$ua = $_SERVER['HTTP_USER_AGENT'];
$escaped_ua = escapeshellarg($ua);
system("echo $escaped_ua >> /tmp/ua_log.txt");
?>
