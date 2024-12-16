<?php

define("HOME_PAGE", "app/Views/home.php");
define("VIEWS", "app/Views");
define("MODEL_ACTION", "/app/Model/Actions");
define('MODEL', 'app/Model');
define('ENTETE', 'app/Model/entete.php');



header("Location: " . HOME_PAGE);
exit();
