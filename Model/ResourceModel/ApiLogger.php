<?php

/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ApiLogger
 * @package Onecode\WebApiLogger\Model\ResourceModel\ApiLogger
 */
class ApiLogger extends AbstractDb {


	/**
	 * Initialize resource
	 *
	 * @return void
	 */
	public function _construct () {
		$this->_init( 'onecode_api_logger', 'id' );
	}


}

