<?php

use Src\Config\ServerConf\DatabaseConnection;

$query = "CREATE TABLE FixturesHistory (
		name TEXT PRIMARY KEY,
		num int)";
DatabaseConnection::executeQuery($query);