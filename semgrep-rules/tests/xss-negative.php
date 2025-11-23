<?php
$initials = $_REQUEST["initials"];
echo htmlspecialchars($initials, ENT_QUOTES, 'UTF-8');  // safe
?>
