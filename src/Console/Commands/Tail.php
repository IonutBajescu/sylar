<?php namespace Ionut\Sylar\Console\Commands;

use Ionut\Sylar\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Tail extends Command {

	protected $config;

	protected function configure()
	{
		$this
			->setName('tail')
			->setDescription('View live tests on your site.')
			->setHelp(<<<EOT
	View live tests on your site.

	Usage:

	<info>php vendor/securitylistener tail</info>

EOT
			);
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->info('Start tail on ' . date('d.m.Y H:i'));
		$file        = $this->config->receivers['log']['to'];
		$lastContent = false;

		if(file_exists($file)){
			while ($content = file_get_contents($file)) {
				if ($output->isDebug()) {
					$this->comment('Check log file for new content');
				}

				if ($content !== $lastContent) {
					$newContent = preg_replace('/^' . preg_quote($lastContent) . '/', '', $content);

					// is not first while run
					if ($lastContent != false) {
						$this->comment($newContent);
					}

					$lastContent = $content;
				}

				sleep(1);
			}
		} else{
			$this->error("Log file not exists.");
		}

	}
}
