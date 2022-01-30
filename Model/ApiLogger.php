<?php
/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model;

use \Magento\Framework\Model\AbstractModel;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger as ResourceModel;
use Onecode\WebApiLogger\Api\Data\ApiLoggerDataInterface;

/**
 * Class ApiLogger
 * @package Onecode\WebApiLogger\Model\ApiLogger
 */
class ApiLogger extends AbstractModel implements ApiLoggerDataInterface {


	/**
	 * Initialize resource model
	 * @return void
	 */
	public function _construct () {
		$this->_init( ResourceModel::class );
	}

	/**
	 * @inheritdoc
	 */
	public function setUrlRequest ( $urlRequest ) {
		$this->setData( "url_request", $urlRequest );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setRequestData ( $requestData ) {
		$this->setData( "request_data", $requestData );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setApiType ( $apiType ) {
		$this->setData( "api_type", $apiType );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setMethodRequest ( $methodRequest ) {
		$this->setData( "method_request", $methodRequest );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function setApiUser ( $apiUser ) {
		$this->setData( "api_user", $apiUser );

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getUrlRequest () {
		return $this->_getData( "url_request" );
	}

	/**
	 * @inheritdoc
	 */
	public function getRequestData () {
		return $this->_getData( "request_data" );
	}

	/**
	 * @inheritdoc
	 */
	public function getMethodRequest () {
		return $this->_getData( "method_request" );
	}

	/**
	 * @inheritdoc
	 */
	public function getApiType () {
		return $this->_getData( "api_type" );
	}

	/**
	 * @inheritdoc
	 */
	public function getApiUser () {
		return $this->_getData( "api_user" );
	}
}

