<?php

use Src\Config\ServerConf\DatabaseConnection;

$query = "UPDATE Grouppings
SET cle = CASE nom
    WHEN 'REGION' THEN 'code_reg'
    WHEN 'DEPARTEMENT' THEN 'code_dept'
    WHEN 'COMMUNES' THEN 'code_epci'
END
WHERE nom IN ('REGION', 'DEPARTEMENT', 'COMMUNES');

";
DatabaseConnection::executeQuery($query);
