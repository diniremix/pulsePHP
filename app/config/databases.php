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
			'DB_NAME' => '',
		),

		'mysql' => array(
			'DB_USERNAME' => '',
			'DB_PASSWORD' => '',
			'DB_HOST' => '',
			'DB_NAME' => '',
		),

		'postgresql' => array(
			'DB_USERNAME' => '',
			'DB_PASSWORD' => '',
			'DB_HOST' => '',
			'DB_NAME' => '',
		),

		'cubrid' => array(
			'DB_USERNAME' => '',
			'DB_PASSWORD' => '',
			'DB_HOST' => '',
			'DB_NAME' => '',
			'DB_PORT' => ''
		),
	);
?>
