<?php
session_start();
session_destroy();
header("Location: Menu_Principal.html");
exit();
?>
