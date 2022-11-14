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
	 * @var State
	 */
	private $_state;



	/**
	 * WebApiLog constructor.
	 *
	 * @param State    $state
	 * @param Registry $registry
	 * @param null     $name
	 */
	public function __construct ( State $state, $name = null ) {
		parent::__construct( $name );
		$this->_state    = $state;
	}


	/**
	 *
	 */
	protected function configure () {
		parent::configure();
		$this->setName( "onecode:web:logger:cleaner" )
		     ->setDescription( "Onecode Web API Logger Commands" );
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
        ObjectManager::getInstance()->create( CleanUp::class )->execute();
	}

}
