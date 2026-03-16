<?php
require_once "functions.php";
$config = require "config.php";
require "Database.php";
$db = new Database(config: $config['database']);
require "router.php";

?>