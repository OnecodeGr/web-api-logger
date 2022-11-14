<?php
/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model;

use Magento\Framework\Model\AbstractModel;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger as ResourceModel;
use Onecode\WebApiLogger\Api\Data\ApiLoggerInterface;

/**
 * Class ApiLogger
 * @package Onecode\WebApiLogger\Model\ApiLogger
 */
class ApiLogger extends AbstractModel implements ApiLoggerInterface
{


    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
        $this->setIdFieldName("id");
    }

    /**
     * @inheritdoc
     */
    public function setUrlRequest($urlRequest)
    {
        $this->setData(self::URL_REQUEST, $urlRequest);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRequestData($requestData)
    {
        return $this->setData(self::REQUEST_DATA, $requestData);
    }

    /**
     * @inheritdoc
     */
    public function setApiType($apiType)
    {
        return $this->setData(self::API_TYPE, $apiType);
    }

    /**
     * @inheritdoc
     */
    public function setMethodRequest($methodRequest)
    {
        return $this->setData(self::METHOD_REQUEST, $methodRequest);
    }

    /**
     * @inheritdoc
     */
    public function setApiUser($apiUser)
    {
        return $this->setData(self::API_USER, $apiUser);

    }

    /**
     * @inheritdoc
     */
    public function getUrlRequest()
    {
        return $this->getData(self::URL_REQUEST);
    }

    /**
     * @inheritdoc
     */
    public function getRequestData()
    {
        return $this->getData(self::REQUEST_DATA);
    }

    /**
     * @inheritdoc
     */
    public function getMethodRequest()
    {
        return $this->getData(self::METHOD_REQUEST);
    }

    /**
     * @inheritdoc
     */
    public function getApiType()
    {
        return $this->getData(self::API_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function getApiUser()
    {
        return $this->getData(self::API_USER);
    }

    /**
     * @inheritdoc
     */
    public function setResponseData($responseData)
    {
        return $this->setData(self::RESPONSE_DATA, $responseData);
    }

    /**
     * @inheritdoc
     */
    public function getResponseData()
    {
        return $this->getData(self::RESPONSE_DATA);
    }

}

