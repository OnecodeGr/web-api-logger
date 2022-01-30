<?php
/**
 * ApiLoggerDataInterface
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Api\Data;

/**
 * Interface ApiLoggerDataInterface
 * @package Onecode\WebApiLogger\Api\Data
 */
interface ApiLoggerDataInterface {

	/**
	 * @param string $urlRequest
	 *
	 * @return $this
	 */
	public function setUrlRequest ( $urlRequest );

	/**
	 * @param string $requestData
	 *
	 * @return $this
	 */
	public function setRequestData ( $requestData );

	/**
	 * @param string $methodRequest
	 *
	 * @return $this
	 */
	public function setMethodRequest ( $methodRequest );

	/**
	 * @param $apiType
	 *
	 * @return $this
	 */
	public function setApiType ( $apiType );

	/**
	 * @param $apiUser
	 *
	 * @return $this
	 */
	public function setApiUser ( $apiUser );

	/**
	 * @return string
	 */
	public function getUrlRequest ();

	/**
	 * @return string
	 */
	public function getRequestData ();

	/**
	 * @return string
	 */
	public function getMethodRequest ();

	/**
	 * @return string
	 */
	public function getApiType ();

	/**
	 * @return string
	 */
	public function getApiUser ();

}
