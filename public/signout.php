<?php
session_start();
session_destroy();
header("Location: /projet_php/public/index.php");
exit();
?> 