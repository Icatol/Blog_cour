<?php
setcookie('sid', '', -1);

$_SESSION['notification']['result'] = 'danger';
$_SESSION['notification']['message'] = 'Vous êtes deconneté !';

header("Location: index.php");
exit();
