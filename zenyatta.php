<?php

return [
	// Server information
	'server' => env('ZENYATTA_SERVER', 'localhost'),
	'port' => env('ZENYATTA_PORT', 7474),

	// Authentication
	'authenticate' => env('ZENYATTA_AUTHENTICATE', true),
	'user' => env('ZENYATTA_AUTHENTICATE_USER', 'neo4j'),
	'password' => env('ZENYATTA_AUTHENTICATE_PASSWORD', 'neo4j'),
];
