<?php
/**
 * Index
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Controller\Adminhtml\Logger;


use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Onecode\WebApiLogger\Controller\Adminhtml\Logger;

class Index extends Logger {

	/**
	 * @return Page|ResponseInterface|ResultInterface
	 */
	public function execute () {
		if ( $this->getRequest()->getQuery( 'ajax' ) ) {
			$this->_forward( 'grid' );

			return;
		}
		/** @var Page $resultPage */
		$resultPage = $this->_resultPageFactory->create();
		$resultPage->setActiveMenu( 'Onecode_WebApiLogger::api_logger' );
		$resultPage->getConfig()->getTitle()->prepend( __( 'Web API Logger' ) );

		return $resultPage;
	}
}
