<?php namespace Ionut\SecurityListener\Console\Commands;

use Ionut\SecurityListener\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Tail extends Command {

	protected function configure()
	{
		$this
			->setName('tail')
			->setDescription('View live tests on your site.')
			->setHelp(<<<EOT
	View live tests on your site.

	Usage:

	<info>./cli tail</info>

EOT
			);
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->info('Start tail on ' . date('d.m.Y H:i'));
		$file        = $this->config->on_trigger['log_event']['to'];
		$lastContent = false;

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
	}
}
