<?php

use Src\Config\ServerConf\DatabaseConnection;

$query = "UPDATE Grouppings
SET cle = 'code_dep'
WHERE nom ='DEPARTEMENT';
";
DatabaseConnection::executeQuery($query);
