<?php

return [

	/**
	 * If request information matches filters we have some default actions to do.
	 */
	'receivers' => [
		/**
		 * Log all data to a file.
		 *
		 * 'log' => false
		 */
		'log'     => [
			'to' => dirname(dirname(dirname(__DIR__))) . '/data/logs.txt'
		],

		/**
		 * Send request data, with attacker information, to email.
		 *
		 * 'mail' => [
		 *      'to' => 'contact@example.com',
		 *      'from' => 'from@example.com',
		 *      'subject' => 'Hey!'
		 * ]
		 */
		'mail'    => false,

		/**
		 * !!! WAF !!!
		 *
		 * That's dangerous. Some times, on some IT sites, SecurityListener can give false pozitives.
		 * 'blocker' => [
		 *        'min_gravity' => 5
		 * ]
		 */
		'blocker' => false
	],

	"filtersCollection" => "Ionut\\SecurityListener\\Filters\\Listener\\Collection"
];