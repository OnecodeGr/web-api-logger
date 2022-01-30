<?php
/**
 * WebApiLog
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use Onecode\WebApiLogger\Cron\CleanUp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Framework\Registry;

/**
 * Class WebApiLog
 * @package Onecode\WebApiLogger\Console\Command
 */
class WebApiLog extends Command {
	/**
	 *
	 */
	const CRON = "cron";

	/**
	 * @var array
	 */
	protected $_commandValues = [
		self::CRON => [
			"clean_up",
		],

	];

	/**
	 * @var State
	 */
	private $_state;

	/**
	 * @var Registry
	 */
	private $_registry;

	/**
	 * WebApiLog constructor.
	 *
	 * @param State    $state
	 * @param Registry $registry
	 * @param null     $name
	 */
	public function __construct ( State $state, Registry $registry, $name = null ) {
		parent::__construct( $name );
		$this->_state    = $state;
		$this->_registry = $registry;

	}


	/**
	 *
	 */
	protected function configure () {
		parent::configure();
		$this->setName( "onecode:web:logger" )
		     ->setDescription( "Onecode Web API Logger Commands" );
		#->setDefinition( $this->getInputList() );
		foreach ( $this->_commandValues as $command => $process ) {
			$values        = "";
			$process_count = 1;
			foreach ( $process as $p ) {
				$values .= sprintf( "%02d. ", $process_count ++ ) . $p . PHP_EOL;
			}
			$this->addOption(
				$command,
				$command[0],
				InputOption::VALUE_REQUIRED,
				$values
			);
		}
	}


	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 *
	 * @return int|void|null
	 * @throws LocalizedException
	 */
	protected function execute ( InputInterface $input, OutputInterface $output ) {

		try {
			$this->_state->getAreaCode();
		} catch ( LocalizedException $e ) {
			$this->_state->setAreaCode( Area::AREA_CRONTAB );
		}
		$this->_registry->register( 'isSecureArea', true );

		switch ( $optionValue = $input->getOption( self::CRON ) ) {
			case "01":
			case "clean_up":
				ObjectManager::getInstance()->create( CleanUp::class )->execute();
				break;
		}
	}

}
