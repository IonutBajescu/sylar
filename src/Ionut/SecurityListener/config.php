<?php

return [

	/**
	 * If request information matches filters we have some default actions to do.
	 */
	'on_trigger' => [
		/**
		 * Log all data to a file.
		 *
		 * 'log_event' => false
		 */
		'log_event' => [
			'to' => dirname(dirname(dirname(__DIR__))).'/data/logs.txt'
		],

		/**
		 * Send request data, with attacker information, to email.
		 *
		 * 'send_to_email' => [
		 *      'mail' => 'contact@example.com'
		 * ]
		 */
		'send_to_email' => false,

		/**
		 * That's dangerous. Some times, on some IT sites, SecurityListener can give false pozitives.
		 * 'block_ip' => [
		 * 		'on_gravity' => 'high'
		 * ]
		 */
		'block_ip' => false
	],

	'patterns' => [
		'sqli' => [
			[
				'pattern' => '/\\d\'/i',
				'gravity' => 'low',
				'desc'    => 'Attacker try to test *{param}* parameter.'
			],

			[
				'pattern' => '/\'$/i',
				'gravity' => 'low',
				'desc'    => 'Attacker try to test *{param}* parameter.'
			],

			[
				'pattern' => '#u[/\\*\\+!]*n[/\\*\\+!]*i[/\\*\\+!]*o[/\\*\\+!]*n[/\\*\\+!]*(all|)[/\\*\\+!]*s[/\\*\\+!]*e[/\\*\\+!]*l[/\\*\\+!]*e[/\\*\\+!]*c[/\\*\\+!]*t#i',
				'gravity' => 'high',
				'desc'    => 'Attacker try to get sensitive data from database.'
			],

			[
				'pattern' => '/order(.{1,4})by/i',
				'gravity' => 'medium',
				'desc'    => 'Attacker try to find column number from this table.'
			],
		],


		'xss' => [
			[
				'pattern' => '/document.cookie/i',
				'gravity' => 'low',
				'desc'    => 'Attacker try to steal users cookies.'
			],

			[
				'pattern' => '/<script/i',
				'gravity' => 'low',
				'desc'    => 'Attacker try to test {param} parameter.'
			],
		],


		'lfi' => [
			[
				'pattern' => '/\\/\\.\\.\\//',
				'gravity' => 'high',
				'desc'    => 'Attacker try to access other folders, folders may contain sensitive data.'
			],
		]
	]
];