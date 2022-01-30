<?php
/**
 * ApiLogger
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;


class Logger extends Container {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_controller = 'adminhtml_logger';
		$this->_blockGroup = 'Onecode_WebApiLogger';
		$this->_headerText = __( 'API Logger' );
		#	$this->_addButtonLabel = __('Add News');
		parent::_construct();
		$this->removeButton( "add" );
	}
}
