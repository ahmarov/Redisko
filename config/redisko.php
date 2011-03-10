<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	// Default server configuration
	'default' => array(
		'host'       => 'localhost',
		'port'       => 6379,
		'serializer' => Redis::SERIALIZER_IGBINARY, // SERIALIZER_NONE, SERIALIZER_PHP, SERIALIZER_IGBINARY
		'prefix'     => NULL
	),
);
