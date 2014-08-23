<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;

class Mail extends Receiver {

	public function __construct($listener)
	{
		$this->listener = $listener;
	}

	public function call(Alert $alert)
	{
		return $this->sendMail($alert->getInfo());
	}

	protected function sendMail($message)
	{
		$config = $this->listener->config->receivers['mail'];

		$m = $this->listener->container->make('Swift_Message');
		$m = $m
			->setSubject($config['subject'])
			->setFrom($config['from'])
			->setTo($config['to'])
			->setBody($message);

		/**
		 * @todo Add option to use a different transport.
		 */
		$mailer = $this->listener->container->make('Swift_MailTransport');

		return $mailer->send($m);
	}
}

