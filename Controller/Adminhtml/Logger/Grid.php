<?php
/**
 * Grid
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Controller\Adminhtml\Logger;


use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Onecode\WebApiLogger\Controller\Adminhtml\Logger;

/**
 * Class Grid
 * @package Onecode\WebApiLogger\Controller\Adminhtml\Logger
 */
class Grid extends Logger {

	/**
	 * @return ResponseInterface|ResultInterface|Page
	 */
	public function execute () {
		return $this->_resultPageFactory->create();
	}
}
