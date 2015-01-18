<?php namespace Ionut\Sylar\Receivers;

use Ionut\Sylar\Alert;
use Ionut\Sylar\Listener;

class Mail extends Receiver {

	public function __construct(Listener $listener)
	{
		$this->listener = $listener;
	}

	public function call(Alert $alert)
	{
		return $this->sendMail($this->generateMailBody($alert));
	}

	protected function sendMail($message)
	{
		$config = $this->listener->config->receivers['mail'];

		$m = $this->listener->container->make('Swift_Message');
		$m = $m
			->setSubject($config['subject'])
			->setFrom($config['from'])
			->setTo($config['to'])
			->setBody($message, 'text/html');

		/**
		 * @todo Add option to use a different transport.
		 */
		$mailer = $this->listener->container->make('Swift_MailTransport');

		return $mailer->send($m);
	}

	protected function generateMailBody(Alert $alert)
	{
		$requestExport = print_r($_REQUEST, true);
		$serverExport  = print_r($_SERVER, true);

		return "
{$alert->getHtmlInfo()}
<hr/>
\$_REQUEST: <br/>
<pre>
{$requestExport}
</pre>
<hr/>
\$_SERVER: <br/>
<pre>
{$serverExport}
</pre>
		";
	}
}


