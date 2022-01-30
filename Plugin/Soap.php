<?php
/**
 * Soap
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Webapi\Controller\Soap as PluggedInClass;
use Magento\Framework\App\RequestInterface;

class Soap extends AbstractPlugin {
	/**
	 * @param PluggedInClass   $subject
	 * @param RequestInterface $request
	 *
	 * @throws Exception
	 */
	public function beforeDispatch ( PluggedInClass $subject, RequestInterface $request ) {
		if ( $this->_dataHelper->getApiConfig( "active" ) && $this->isApiMethodAccepted() && $this->canTrackUser()) {
			$this->_apiLogger->setApiType( "Soap" )
			                 ->setRequestData( $this->convertContent( $this->_httpRequest->getContent() ) )
			                 ->setMethodRequest( $this->_httpRequest->getMethod() )
			                 ->setUrlRequest( urldecode( $this->_httpRequest->getPathInfo() ) )
			                 ->setApiUser( $this->getIntegratedUser() )
			                 ->save();
		}
	}
}
