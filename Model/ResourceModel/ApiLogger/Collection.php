<?php

/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model\ResourceModel\ApiLogger;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use  Onecode\WebApiLogger\Model\ApiLogger as ModelClass;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger as ResourceModelClass;


/**
 * Class ${CLASSNAME}
 * @package Onecode\WebApiLogger\Model\ResourceModel\ApiLogger\\${CLASSNAME}
 */
class Collection extends AbstractCollection {
	/**
	 * Initialize resource collection
	 *
	 * @return void
	 */
	public function _construct () {
		$this->_init( ModelClass::class, ResourceModelClass::class );
	}
}
