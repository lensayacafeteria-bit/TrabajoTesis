<?php
session_start();
session_unset();
session_destroy();
header("Location: Menu_admin.html");
exit();
?>
