<?php
/**
 * Edit
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Controller\Adminhtml\Logger;


use Magento\Backend\Model\View\Result\Page;
use Onecode\WebApiLogger\Controller\Adminhtml\Logger;
use Onecode\WebApiLogger\Model\ApiLogger;

class Edit extends Logger {


	/**
	 * @return void
	 */
	public function execute () {
		$id = $this->getRequest()->getParam( 'id' );
		/** @var ApiLogger $model */
		$model = $this->_apiLoggerFactory->create();


		if ( $id ) {
			$model->load( $id );
			if ( ! $model->getId() ) {
				$this->messageManager->addError( __( 'This API Request no longer exists.' ) );
				$this->_redirect( '*/*/' );

				return;
			}
		}

		// Restore previously entered form data from session
		#$data = $this->_session->getApiRequestData( true );

		$data = $this->_session->getApiRequestData( true );
		if ( ! empty( $data ) ) {
			$model->setData( $data );
		}
		$this->_coreRegistry->register( 'api_logger', $model );

		/** @var Page $resultPage */
		$resultPage = $this->_resultPageFactory->create();

		$resultPage->getConfig()->getTitle()->prepend( __( 'API Request' . $model->getUrlRequest() ) );

		return $resultPage;
	}
}
