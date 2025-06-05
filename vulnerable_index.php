<?php
// WARNING: This is intentionally vulnerable and should not be used in production.

$ua = $_SERVER['HTTP_USER_AGENT'];
system("echo '$ua' >> /tmp/ua_log.txt");
?>
