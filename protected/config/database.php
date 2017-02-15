<?php
require_once( __DIR__. '/../../../app.axora_configuration.php' );
// This is the database connection configuration.
return array(
	
	'connectionString' => 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE,
	'emulatePrepare' => true,
	'username' => DB_USER,
	'password' => DB_PASSWORD,
	'charset' => 'utf8',
);
