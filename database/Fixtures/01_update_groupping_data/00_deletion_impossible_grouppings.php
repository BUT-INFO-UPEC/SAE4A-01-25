<?php

use Src\Config\ServerConf\DatabaseConnection;

$query = "DELETE FROM Grouppings
WHERE nom IN ('SAISONS', 'SEMAINES', 'LISTE_DATES');
";
DatabaseConnection::executeQuery($query);
