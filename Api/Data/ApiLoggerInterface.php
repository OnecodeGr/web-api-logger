<?php
/**
 * ApiLoggerRepositoryInterface
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Api\Data;

/**
 * Interface ApiLoggerRepositoryInterface
 * @package Onecode\WebApiLogger\Api\Data
 */
interface ApiLoggerInterface
{


    const ENTITY_ID = "id";
    const URL_REQUEST = "url_request";
    const METHOD_REQUEST = "method_request";
    const API_USER = "api_user";
    const API_TYPE = "api_type";
    const RESPONSE_DATA = "response_data";
    const REQUEST_DATA = "request_data";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /**
     * @param string $urlRequest
     *
     * @return $this
     */
    public function setUrlRequest($urlRequest);

    /**
     * @param string $requestData
     *
     * @return $this
     */
    public function setRequestData($requestData);

    /**
     * @param string $methodRequest
     *
     * @return $this
     */
    public function setMethodRequest($methodRequest);

    /**
     * @param $apiType
     *
     * @return $this
     */
    public function setApiType($apiType);

    /**
     * @param $apiUser
     *
     * @return $this
     */
    public function setApiUser($apiUser);

    /**
     * @return string
     */
    public function getUrlRequest();

    /**
     * @return string
     */
    public function getRequestData();

    /**
     * @return string
     */
    public function getMethodRequest();

    /**
     * @return string
     */
    public function getApiType();

    /**
     * @return string
     */
    public function getApiUser();

    /**
     * @param string $responseData
     * @return mixed
     */
    public function setResponseData($responseData);

    /**
     * @return string
     */
    public function getResponseData();

}
