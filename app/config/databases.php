<?php
/*=========== Route functions for user class ==========*/
/*This file is part of the PulsePHP, Be careful with this file */

/*
examples:
some values for DB_DEFAULT:
+ none
+ mysql
+ postgresql
+ sqlite
+ cubrid

- none: Not using a Database
- mysql and postgresql use the same settings
- sqlite: not supported using ":memory:" in this version
- cubrid: DB_PORT is required
*/

	$databases = array(
		'DB_DEFAULT' => 'none',

		'sqlite' => array(
			'DB_NAME' => ''
		),

		'mysql' => array(
			'DB_HOST' => 'localhost',
			'DB_NAME' => '',
			'DB_USERNAME' => '',
			'DB_PASSWORD' => ''
		),

		'mysql-prod' => array(
			'DB_HOST' => '',
			'DB_NAME' => '',
			'DB_USERNAME' => '',
			'DB_PASSWORD' => ''
		),
		
		'postgresql' => array(
			'DB_HOST' => '',
			'DB_NAME' => '',
			'DB_USERNAME' => '',
			'DB_PASSWORD' => ''
		),

		'postgresql-prod' => array(
			'DB_HOST' => '',
			'DB_NAME' => '',
			'DB_USERNAME' => '',
			'DB_PASSWORD' => ''
		),

		'cubrid' => array(
			'DB_HOST' => '',
			'DB_NAME' => '',
			'DB_USERNAME' => '',
			'DB_PASSWORD' => '',
			'DB_PORT' => ''
		),
	);
?>
